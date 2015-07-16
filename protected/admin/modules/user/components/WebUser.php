<?php

/**
 * Аутентификация пользователя
 *
 * @category Component
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class WebUser extends CWebUser
{

    /**
     * @var object данные пользователя 
     */
    private $_model;

    /**
     * Действие перед выходом
     * @return type
     */
    public function beforeLogout()
    {
        $user = $this->loadUser(Yii::app()->user->id);

        if ($user !== null)
        {
            $user->last_visit = date('Y-m-d H:i:s');
            $user->save();
        }

        return parent::beforeLogout();
    }

    /**
     * Получение логина пользователя
     * @return string
     */
    public function getUsername()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user->username;
    }
    
    /**
     * Получение адреса эл. почты пользователя
     * @return string
     */
    public function getEmail()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user->email;
    }
    
    /**
     * Получение пользователя по id
     * @param integer $id
     * @return object
     */
    protected function loadUser($id)
    {
        if ($this->_model === null)
            $this->_model = User::model()->with('profile')->findByPk($id);

        return $this->_model;
    }

}

