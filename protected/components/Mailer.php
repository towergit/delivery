<?php

/**
 * Mailer
 * компонен отправки писем
 * с возможностью применять шаблоны
 *
 * @category component
 * @package  components
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Mailer {

    /**
     * @var mixed получатель, или получатели письма
     */
    private $_to = null;

    /**
     * @var string отправитель письма
     */
    private $_from = null;

    /**
     * @var string тема отправляемого письма
     */
    private $_subject = '';

    /**
     * @var string текст отправляемого сообщение
     */
    private $_message = '';

    /**
     * @var string ответ на адрес
     */
    private $_replyTo = null;

    /**
     * @var string путь ответа
     */
    private $_returnPath = null;

    /**
     * @var string точная копия
     */
    private $_cc = null;

    /**
     * @var string скрытая копия
     */
    private $_bcc = null;

    /**
     * @var mixed вложеные файлы
     */
    private $_attachment = null;

    /**
     * @var string заголовки
     */
    private $_headers = '';

    /**
     * @var string тип письма (возможные типы "text/html", "text/plain")
     */
    public $contentType = 'text/html';

    /**
     * @var string кодировка        Yii::import('application.modules.comment.models.*');
      Yii::import('application.modules.comment.models.*');
     */
    public $charset = 'utf-8';

    /**
     * @var integer перенос строки на данное количество символов
     */
    public $lineLength = 70;

    /**
     * Получатель, или получатели письма
     * @param mixed $string
     * @return string
     */
    public function to($string) {
        return $this->_to = $string;
    }

    /**
     * Отправитель письма
     * @param string $email адрес эл. почты
     * @param string $name имя отправителя
     * @return string
     */
    public function from($email, $name = null) {
        if ($name !== null)
            $this->_headers .= "From: $name <{$email}>\r\n";
        else
            $this->_headers .= "From: {$email}\r\n";

        return $this->_from = $email;
    }

    /**
     * Тема отправляемого письма
     * @param string $string
     * @return string
     */
    public function subject($string) {
        return $this->_subject = $string;
    }

    /**
     * Текст отправляемого сообщение
     * @param string $string
     * @return string
     */
    public function message($string) {
        return $this->_message = wordwrap($string, $this->lineLength);
    }

    public function templateMessage($text, $params = null) {
        $str = $text;

        if ($params !== null) {
            if (!is_array($params))
                throw new CHttpException(404, 'Парметры должны быть массивом!');

            foreach ($params as $key => $value)
                $str = str_replace("%$key%", $value, $str);

            if (php_sapi_name() == "cli") {

                return $this->_message =  wordwrap($str, $this->lineLength);
                
            } else {

                return $this->_message = Yii::app()->controller->renderPartial('application.views.layouts.mail.layout', array('content' => wordwrap($str, $this->lineLength)), true);
            }
        } else {
            if (php_sapi_name() == "cli") {

                return $this->_message =  wordwrap($text, $this->lineLength);
                
            } else {
                return $this->_message = Yii::app()->controller->renderPartial('application.views.layouts.mail.layout', array('content' => wordwrap($text, $this->lineLength)), true);
            }
        }
    }

    /**
     * Ответ на адрес
     * @param string $string
     * @return string
     */
    public function replyTo($string) {
        $this->_headers .= "Reply-To: {$string}\r\n";
        return $this->_replyTo = $string;
    }

    /**
     * Путь ответа
     * @param string $string
     * @return string
     */
    public function returnPath($string) {
        $this->_headers .= "Return-Path: {$string}\r\n";
        return $this->_returnPath = $string;
    }

    /**
     * Точная копия
     * @param string $string
     * @return string
     */
    public function cc($string) {
        $this->_headers .= "Cc: {$string}\r\n";
        return $this->_cc = $string;
    }

    /**
     * Скрытая копия
     * @param string $string
     * @return string
     */
    public function bcc($string) {
        $this->_headers .= "Bcc: {$string}\r\n";
        return $this->_bcc = $string;
    }

    /**
     * Вложеные файлы
     * @param string $string
     * @return string
     */
    public function attachment($string) {
        return $this->_attachment = $string;
    }

    /**
     * Заголовки
     * @return string
     */
    private function headers() {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: {$this->contentType}; charset=" . $this->charset . "\r\n";
        $headers .= $this->_headers;

        return $headers;
    }

    /**
     * Отправка письма
     * @return mixed
     */
    public function send() { ///
        return mail($this->_to, $this->_subject, $this->_message, $this->headers());
    }

    /**
     * Получение статуса отправки письма
     * @return boolean
     */
    public function getStatus() {
        return $this->send();
    }

}
