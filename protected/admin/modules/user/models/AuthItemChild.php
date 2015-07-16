<?php

/**
 * Контроль доступа
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{auth_item_child}':
 * @property string $parent
 * @property string $child
 */
class AuthItemchild extends CActiveRecord
{
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{auth_item_child}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'parent, child', 'safe' ),
            array( 'parent, child', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'parent' => Yii::t('user', 'Родитель'),
            'child'  => Yii::t('user', 'Ребенок'),
        );
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return AuthItemChild статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

