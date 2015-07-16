<?php

/**
 * Востановление данных пользователя
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные поля формы:
 * @property string $username_or_email
 * @property integer $id
 */
class RecoveryForm extends CFormModel
{

    /**
     * @var string логин или email
     */
    public $username_or_email;

    /**
     * @var integer ID пользователя
     */
    public $id;

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'username_or_email', 'required' ),
            array( 'username_or_email', 'match', 'pattern' => '/^[A-Za-z0-9@.-\s,]+$/iu', 'message' => 'неправильные символы (A-z0-9)' ),
            array( 'username_or_email', 'checkExists' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username_or_email' => 'Логин или адрес эл. почты',
        );
    }

    /**
     * Проверка на корректность ввода данных
     */
    public function checkExists()
    {
        if (!$this->hasErrors())
        {
            if (strpos($this->username_or_email, '@'))
            {
                $user = User::model()->findByAttributes(array( 'email' => $this->username_or_email ));

                if ($user !== null)
                    $this->id = $user->id;
            }
            else
            {
                $user = User::model()->findByAttributes(array( 'username' => $this->username_or_email ));

                if ($user !== null)
                    $this->id = $user->id;
            }

            if ($user === null)
            {
                if (strpos($this->username_or_email, '@'))
                    $this->addError('username_or_email', 'Данный адрес электронной почты не найден');
                else
                    $this->addError('username_or_email', 'Данный логин не найден');
            }
        }
    }

}

