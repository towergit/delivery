<?php

/**
 * Блок контента
 *
 * @category Model
 * @package  Module.Contentblock
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{content_block}}':
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property integer $type
 * @property string $content
 * @property string $desription
 * @property integer $status
 */
class ContentBlock extends CActiveRecord
{

    const SIMPLE_TEXT = 1;
    const PHP_CODE    = 2;
    const HTML_TEXT   = 3;
    
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{content_block}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'title, code, type, content', 'required' ),
            array( 'code', 'unique', 'caseSensitive' => false ),
            array( 'type, status', 'numerical', 'integerOnly' => true ),
            array( 'title, code', 'length', 'max' => 50 ),
            array( 'description', 'length', 'max' => 255 ),
            array( 'type', 'in', 'range' => array_keys($this->typeList) ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'title, code, content, description', 'filter', 'filter' => 'trim' ),
            array( 'id, title, code, type, content, description, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('contentblock', 'ID'),
            'title'       => Yii::t('contentblock', 'Название'),
            'code'        => Yii::t('contentblock', 'Уникальный код'),
            'type'        => Yii::t('contentblock', 'Тип'),
            'content'     => Yii::t('contentblock', 'Контент'),
            'description' => Yii::t('contentblock', 'Описание'),
            'status'      => Yii::t('contentblock', 'Статус'),
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
                'condition' => 'status = :status',
                'params'    => array( ':status' => self::STATUS_INACTIVE ),
            ),
            'active'   => array(
                'condition' => 'status = :status',
                'params'    => array( ':status' => self::STATUS_ACTIVE ),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    /**
     * Получение списка типов
     * @return array
     */
    public function getTypeList()
    {
        return array(
            self::SIMPLE_TEXT => Yii::t('contentblock', 'Простой текст'),
            self::PHP_CODE    => Yii::t('contentblock', 'Исполняемый PHP код'),
            self::HTML_TEXT   => Yii::t('contentblock', 'HTML код'),
        );
    }
    
    /**
     * Получение типа
     * @return string
     */
    public function getType()
    {
        $data = $this->typeList;
        return (isset($data[$this->type])) ? $data[$this->type] : Yii::t('contentblock', '*неизвестно*');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('contentblock', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('contentblock', 'Активно'),
        );
    }

    /**
     * Получение статуса активности
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status])) ? $data[$this->status] : Yii::t('contentblock', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return ContentBlock статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

