<?php

/**
 * Оплата
 *
 * @category Model
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{payment}}':
 * @property integer $id
 * @property string $code
 * @property float $sum
 * @property string $system
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $status
 */
class AdditionEmailList extends ActiveRecord
{
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{addition_emails_list}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
          //  array('email', 'uniqEmail'),
            array('email', 'email'),
            array('email', 'unique'),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'name'     => Yii::t('main', 'Имя'),
            'email'    => Yii::t('main', 'Еmail'),
            'data' => Yii::t('main', 'Дата создания'),
        );
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Payment статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

