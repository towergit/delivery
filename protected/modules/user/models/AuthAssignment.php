<?php

/**
 * Контроль доступа
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{auth_assignment}':
 * @property string $itemname
 * @property integer $userid
 * @property string $bizrule
 * @property string $data
 * 
 * Доступные модели связей:
 * @property AuthItem[] $authItem
 * @property User[] $user
 */
class AuthAssignment extends CActiveRecord
{
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{auth_assignment}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'itemname, userid', 'required' ),
            array( 'bizrule, data', 'safe' ),
            array( 'itemname, userid, bizrule, data', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'authItem' => array( self::BELONGS_TO, 'AuthItem', 'itemname' ),
            'user'     => array( self::BELONGS_TO, 'User', 'userid' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'itemname' => Yii::t('user', 'Назначение'),
            'userid'   => Yii::t('user', 'Пользователь'),
            'bizrule'  => Yii::t('user', 'Бизнес-правило'),
            'data'     => Yii::t('user', 'Данные'),
        );
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return AuthAssignment статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

