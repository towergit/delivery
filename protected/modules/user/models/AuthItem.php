<?php

/**
 * Контроль доступа
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{auth_item}}':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * Доступные модели связей:
 * @property AuthAssignment[] $authAssignment
 * @property AuthItemChild[] $authItemChild
 * @property AuthItemChild[] $authItemChildren
 */
class AuthItem extends CActiveRecord
{

    const ROLE      = 2;
    const TASK      = 1;
    const OPERATION = 0;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{auth_item}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'name, type, description', 'required' ),
            array( 'name', 'match', 'pattern' => '/^([a-z_])+$/i' ),
            array( 'name', 'unique', 'caseSensitive' => true ),
            array( 'name', 'length', 'max' => 64 ),
            array( 'type', 'numerical', 'integerOnly' => true ),
            array( 'description', 'length', 'min' => 1, 'max' => 125 ),
            array( 'bizrule, data', 'safe' ),
            array( 'name, type, description, bizrule, data', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'authAssignment'   => array( self::HAS_MANY, 'AuthAssignment', 'itemname' ),
            'authItemChild'    => array( self::HAS_MANY, 'AuthItemChild', 'parent' ),
            'authItemChildren' => array( self::HAS_MANY, 'AuthItemChild', 'child' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'name'        => Yii::t('user', 'Название'),
            'type'        => Yii::t('user', 'Тип'),
            'description' => Yii::t('user', 'Описание'),
            'bizrule'     => Yii::t('user', 'Бизнес-правило'),
            'data'        => Yii::t('user', 'Данные'),
        );
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'description',
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return AuthItem статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

