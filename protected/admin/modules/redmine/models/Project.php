<?php

/**
 * Проекты
 *
 * @category Model
 * @package  Module.Redmine
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{redmine_project}}':
 * @property integer $id
 * @property string $identifier
 * @property string $title
 * @property string $description
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 */
class Project extends CActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_CLOSED   = 2;
    const STATUS_ARCHIVE  = 3;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{redmine_project}}';
    }

    /**
     * Поведения
     * @return array
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'           => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_date',
                'updateAttribute' => 'update_date',
            ),
        );
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'identifier, title', 'required' ),
            array( 'identifiet', 'unique', 'caseSensitive' => false ),
            array( 'title', 'length', 'max' => 100 ),
            array( 'create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'description, update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, identifier, title, description, create_date, update_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('redmine', 'ID'),
            'identifier'  => Yii::t('redmine', 'Идентификатор'),
            'title'       => Yii::t('redmine', 'Название'),
            'description' => Yii::t('redmine', 'Описание'),
            'create_date' => Yii::t('redmine', 'Дата создания'),
            'update_date' => Yii::t('redmine', 'Дата редактирования'),
            'status'      => Yii::t('redmine', 'Статус'),
        );
    }

    /**
     * Именованная группа условий
     * @return array
     */
    public function scopes()
    {
        return array(
            'inactive' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_INACTIVE ),
            ),
            'active'   => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_ACTIVE ),
            ),
            'closes'   => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_CLOSED ),
            ),
            'archive'  => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_ARCHIVE ),
            ),
        );
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('identifier', $this->identifier, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->create, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id',
            ),
        ));
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('redmine', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('redmine', 'Активен'),
            self::STATUS_CLOSED   => Yii::t('redmine', 'Закрыт'),
            self::STATUS_ARCHIVE  => Yii::t('redmine', 'Архивный'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('redmine', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Project статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

