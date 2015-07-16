<?php

/**
 * Альтернативный менеджер урлов с поддержкой языков
 *
 * @category Component
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LangUrlManager extends CUrlManager
{

    /**
     * @var array список языков 
     */
    public $languages;

    /**
     * @var string параметр языка 
     */
    public $langParam = 'language';

    /**
     * @var boolean отображение языка в URL строке 
     */
    public $languageInPath = false;

    /**
     * Инициализация приложения
     */
    public function init()
    {
        $lang      = new Language;
        $languages = $lang->languageList;

        if (!isset($languages[0]))
            $this->languages = null;

        $this->languages = $languages;

        if ($this->getCookieLanguage())
            Yii::app()->language = $this->getCookieLanguage();
        elseif ($this->getDefaultLanguage())
            Yii::app()->language = $this->getDefaultLanguage();
        elseif ($this->getClientLanguage())
            Yii::app()->language = $this->getClientLanguage();

        if ($this->languageInPath && is_array($this->languages))
        {
            $r = array();

            foreach($this->rules as $rule => $p)
            {
                if (preg_match('#^admin#', $rule))
                    $r[(str_replace('admin',
                            'admin/<' . $this->langParam . ':\w{2}>', $rule))]     = $p;
                else
                    $r[(($rule[0] == '/') ? '/<' . $this->langParam . ':\w{2}>' : '<' . $this->langParam . ':\w{2}>/') . $rule] = $p;
            }

            $this->rules = array_merge($r, $this->rules);
            $p           = parent::init();
            $this->processRules();

            return $p;
        }
        else
            return parent::init();
    }

    /**
     * Создание URL
     * @param string $route
     * @param array $params параметры
     * @param string $ampersand разделитель
     * @return string
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if (is_array($this->languages) && $this->languageInPath)
        {
            if (!isset($params[$this->langParam]))
                $params[$this->langParam] = Yii::app()->language;


            if ((Yii::app()->sourceLanguage == $params[$this->langParam]) && ($params[$this->langParam] == Yii::app()->language))
                unset($params[$this->langParam]);
        }

        return parent::createUrl($route, $params, $ampersand);
    }

    /**
     * Выполняет очистку адреса от языка
     * @return string обработанную строку адреса
     */
    public function getCleanUrl($url)
    {
        strstr($url, '?') ? list($url, $param) = explode("?", $url) : $param = false;
        // Убираем homeUrl из адреса
        $url   = preg_replace("#^(" . Yii::app()->request->scriptUrl . "|" . Yii::app()->request->baseUrl . ")#",
            '', $url);
        // Убираем из пути адреса языковой параметр
        if ($url != '' && $url != '/')
        {
            if ($url[0] == '/')
                $url = substr($url, 1);
            if ($url[strlen($url) - 1] != '/')
                $url .= '/';
            $url = preg_replace("#^(" . implode("|", $this->languages) . ")/#",
                '', $url);
        }
        // Убираем косую черту в конце пути для единоообразия
        if ($url != '' && $url[strlen($url) - 1] == '/')
            $url = substr($url, 0, strlen($url) - 1);
        // Убираем из GET-парамметров адреса языковой парамметр
        if ($param != false)
        {
            parse_str($param, $param);
            if (isset($param[$this->langParam]))
                unset($param[$this->langParam]);
            if ($param != array())
                $url .= '?' . http_build_query($param);
        }
        return $url;
    }

    /**
     * При принудительном изменении языка, определяет как добавлять язык
     * @return string обработанную строку адреса
     * первый парамметр url должен быть очищен от языкового парамметра с помощью getCleanUrl.
     */
    public function replaceLangUrl($url, $lang = false)
    {
        if ($lang)
        {
            if ($this->languageInPath)
            {
                if (preg_match('#^admin\/[a-z]{2}#', $url))
                    $url = preg_replace('#^admin\/[a-z]{2}\/#',
                        'admin/' . $lang . '/', $url);
                else
                    $url = $lang . ($url != '' ? '/' . $url : '');
            }
            else
                $url = $url . (strstr($url, '?') ? '&' : '?') . $this->langParam . '=' . $lang;
        }

        return $url;
    }

    /**
     * Получение языка из cookie
     * @return string|boolean
     */
    private function getCookieLanguage()
    {
        if (Yii::app()->request->cookies[$this->langParam])
            return CHtml::encode(Yii::app()->request->cookies[$this->langParam]);

        return false;
    }

    /**
     * Получение языка из браузера
     * @return string|boolean
     */
    private function getClientLanguage()
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            foreach($langs as $value)
            {
                $choice = substr($value, 0, 2);

                if (in_array($choice, $this->languages))
                    return $choice;
            }
        }

        return false;
    }

    /**
     * Получение языка по умолчанию
     * @return string|boolean
     */
    private function getDefaultLanguage()
    {
        $language = Language::getDefaultLanguage();

        if ($language !== null)
            return $language->url;

        return false;
    }

}

