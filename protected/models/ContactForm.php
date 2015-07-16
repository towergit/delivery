<?php

/**
 * Связь с нами
 *
 * @category Form
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные поля:
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $body
 */
class ContactForm extends CFormModel
{

    /**
     * @var string имя 
     */
    public $name;

    /**
     * @var string email 
     */
    public $email;

    /**
     * @var string тема
     */
    public $subject;

    /**
     * @var string сообщение
     */
    public $body;

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'name, email, subject, body', 'required' ),
            array( 'email', 'email' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'name'    => Yii::t('main', 'Имя'),
            'email'   => Yii::t('main', 'Email'),
            'subject' => Yii::t('main', 'Тема'),
            'body'    => Yii::t('main', 'Сообщение'),
        );
    }

}

