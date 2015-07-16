<?php

/**
 * Аутентификация пользователя
 *
 * @category Component
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class UserIdentity extends CUserIdentity
{

    const ERROR_NONE             = 0;
    const ERROR_USERNAME_INVALID = 1;
    const ERROR_PASSWORD_INVALID = 2;
    const ERROR_NOTACTIVE        = 4;
    const ERROR_BANNED           = 5;

    /**
     * @var integer идентификатор пользователя
     */
    private $_id;

    /**
     * @var object данные пользователя
     */
    private $_model;

    /**
     * Аутентификации пользователя
     * @return string
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(array( 'username' => $this->username ));

        if ($user === null)
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        elseif ($user->status == User::STATUS_INACTIVE)
        {
            $this->errorCode = self::ERROR_NOTACTIVE;
        }
        elseif ($user->status == User::STATUS_BLOCK)
        {
            $this->errorCode = self::ERROR_BANNED;
        }
        elseif (!CPasswordHelper::verifyPassword($this->password, $user->password))
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
        else
        {
            $this->_model    = $user;
            $this->_id       = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }

        return !$this->errorCode;
    }

    /**
     * Получение данных пользователя
     * @return object
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * Получение ID пользователя
     * @return ineger
     */
    public function getId()
    {
        return $this->_id;
    }

}

