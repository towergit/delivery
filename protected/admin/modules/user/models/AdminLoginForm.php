<?php

/**
 * Авторизация
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные поля формы:
 * @property string $username
 * @property string $password
 * @property integer $rememberMe
 */
class AdminLoginForm extends CFormModel
{

    /**
     * @var string имя пользователя
     */
    public $username;

    /**
     * @var string пароль
     */
    public $password;

    /**
     * @var integer запомнить меня
     */
    public $rememberMe;

    /**
     * @var string идентификация
     */
    private $_identity;

    /**
     * Правила проверки для атрибутов формы
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'username, password', 'required' ),
            array( 'rememberMe', 'boolean' ),
            array( 'password', 'authenticate' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username'   => Yii::t('user', 'Логин'),
            'password'   => Yii::t('user', 'Пароль'),
            'rememberMe' => Yii::t('user', 'Запомнить меня'),
        );
    }

    /**
     * Аутентификация
     * @param string $attribute
     * @param array $params
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->username, $this->password);

            if ($this->_identity->authenticate())
            {
                $duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
                Yii::app()->user->login($this->_identity, $duration);
            }
            else
            {
                switch($this->_identity->errorCode)
                {
                    case UserIdentity::ERROR_NONE:
                        $duration = $this->rememberMe ? 3600 * 24 * 30 : 0;
                        Yii::app()->user->login($this->_identity, $duration);
                        break;

                    case UserIdentity::ERROR_USERNAME_INVALID:
                        $this->addError('username', Yii::t('user', 'Неверный логин или пароль'));
                        break;

                    case UserIdentity::ERROR_PASSWORD_INVALID:
                        $this->addError('username', Yii::t('user', 'Неверный логин или пароль'));
                        break;

                    case UserIdentity::ERROR_NOTACTIVE:
                        $this->addError('username', Yii::t('user', 'Пользователь не активен. Обратитесь к администратору'));
                        break;

                    case UserIdentity::ERROR_BANNED:
                        $this->addError('username', Yii::t('user', 'Пользователь забанен. Обратитесь к администратору'));
                        break;
                }
            }
        }
    }

}

