<?php

/**
 * События
 *
 * @category Model
 * @package  Module.Event
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{event}}':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $start_date
 * @property integer $end_date
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property EventCategory[] $category
 */
class Event extends CActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{event}}';
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
            array( 'category_id, title, alias', 'required' ),
            array( 'alias', 'unique', 'caseSensitive' => false ),
            array( 'alias', 'AliasValidator' ),
            array( 'category_id, create_date, update_date, start_date, end_date, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'category_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date, start_date, end_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'text, meta_keywords, meta_description', 'safe' ),
            array( 'organizers, theme, speakers, duration, cost, contacts, venue, comment', 'safe' ),
            array( 'text, update_date, end_date, meta_keywords, meta_description', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, title, alias, text, create_date, update_date, start_date, end_date, meta_keywords, meta_description, status, sort',
                'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'category' => array( self::BELONGS_TO, 'EventCategory', 'category_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('event', 'ID'),
            'category_id'      => Yii::t('event', 'Категория'),
            'title'            => Yii::t('event', 'Название'),
            'alias'            => Yii::t('event', 'Алиас'),
            'text'             => Yii::t('event', 'Текст'),
            'create_date'      => Yii::t('event', 'Дата создания'),
            'update_date'      => Yii::t('event', 'Дата обновления'),
            'start_date'       => Yii::t('event', 'Дата начала'),
            'end_date'         => Yii::t('event', 'Дата конца'),
            'meta_keywords'    => Yii::t('event', 'Мета ключевые слова'),
            'meta_description' => Yii::t('event', 'Мета описание'),
            'status'           => Yii::t('event', 'Статус'),
            'sort'             => Yii::t('event', 'Сортировка'),
            
            'organizers'       => Yii::t('event', 'Организаторы'),
            'theme'            => Yii::t('event', 'Тема'),
            'speakers'         => Yii::t('event', 'Спикеры'),
            'duration'         => Yii::t('event', 'Продолжительность'),
            'cost'             => Yii::t('event', 'Стоимость'),
            'contacts'         => Yii::t('event', 'Контакты'),
            'venue'            => Yii::t('event', 'Место проведения'),
            'comment'          => Yii::t('event', 'Комментарии'),
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
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('FROM_UNIXTIME(start_date, "%d.%m.%Y")', $this->start_date, true);
        $criteria->compare('FROM_UNIXTIME(end_date, "%d.%m.%Y")', $this->end_date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.sort',
            ),
        ));
    }

    /**
     * Получение даты конца
     * @return string
     */
    public function getEndDate()
    {
        return $this->end_date != 0 ? Date::format($this->end_date) : Yii::t('event', 'тот же день');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('event', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('event', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('event', '*неизвестно*');
    }

    /**
     * До валидации модели
     * @return boolean
     */
    public function beforeValidate()
    {
        if ($this->start_date)
            $this->start_date = strtotime($this->start_date);

        if ($this->end_date)
            $this->end_date = strtotime($this->end_date);

        return parent::beforeValidate();
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if (!$this->start_date)
            $this->start_date = new CDbExpression('UNIX_TIMESTAMP()');

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Event статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

