<?php

/**
 * Языки
 *
 * @category Model
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{language}}':
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $local
 * @property integer $default
 * @property integer $status
 * @property integer $sort
 */
class Language extends CActiveRecord
{

    const STATUS_INACTIVE  = 0;
    const STATUS_ACTIVE    = 1;
    const DEFAULT_LANGUAGE = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{language}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'title, url, local', 'required' ),
            array( 'url', 'unique', 'caseSensitive' => false ),
            array( 'title', 'length', 'max' => 20 ),
            array( 'default, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'id, title, url, default, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'      => Yii::t('language', 'ID'),
            'title'   => Yii::t('language', 'Название'),
            'url'     => Yii::t('language', 'URL'),
            'local'   => Yii::t('language', 'Локализация'),
            'default' => Yii::t('language', 'По умолчанию'),
            'status'  => Yii::t('language', 'Статус'),
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
        $criteria->compare('url', $this->url, true);
        $criteria->compare('local', $this->local, true);
        $criteria->compare('default', $this->default);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id',
            ),
        ));
    }
    
    public static function getList()
    {
        $models = self::model()->active()->findAll(array( 'select' => 'url, title' ));
        return CHtml::listData($models, 'url', 'title');
    }

    /**
     * Получение языка по умолчанию
     * @return object
     */
    public static function getDefaultLanguage()
    {
        return self::model()->findByAttributes(array( 'default' => self::DEFAULT_LANGUAGE ));
    }

    /**
     * Получение списка доступных языков
     * @return array
     */
    public function getLanguageList()
    {
        $models = $this->active()->findAll(array( 'select' => 'url, title' ));
        return CHtml::listData($models, 'url', 'title');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('language', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('language', 'Активно'),
        );
    }

    /**
     * Получение статуса активности
     * @return string
     */
    public function getActiveStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status])) ? $data[$this->status] : Yii::t('language', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Language статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

