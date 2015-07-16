<?php

/**
 * Категории событий
 *
 * @category Model
 * @package  Module.Event
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{event_category}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property string $color
 * @property integer $create_date
 * @property integer $update_date
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $status
 * @property integer $read_only
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property Event[] $events
 */
class EventCategory extends CActiveRecord
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
        return '{{event_category}}';
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
            array( 'parent_id, title, alias', 'required' ),
            array( 'create_date, update_date, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'parent_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'text, color, meta_keywords, meta_description', 'safe' ),
            array( 'text, color, meta_keywords, meta_description, update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, parent_id, title, alias, text, color, create_date, update_date, meta_keywords, meta_description, status, sort',
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
            'events' => array( self::HAS_MANY, 'Event', 'category_id' ),
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
            'parent_id'        => Yii::t('event', 'Родитель'),
            'title'            => Yii::t('event', 'Название'),
            'alias'            => Yii::t('event', 'Алиас'),
            'text'             => Yii::t('event', 'Текст'),
            'color'            => Yii::t('event', 'Цвет'),
            'create_date'      => Yii::t('event', 'Дата создания'),
            'update_date'      => Yii::t('event', 'Дата обновления'),
            'meta_keywords'    => Yii::t('event', 'Мета ключевые слова'),
            'meta_description' => Yii::t('event', 'Мета описание'),
            'status'           => Yii::t('event', 'Статус'),
            'sort'             => Yii::t('event', 'Сортировка'),
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
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'sort',
            ),
        ));
    }

    /**
     * Получение списка категорий
     * @return array
     */
    public function getCategoryList()
    {
        $models = self::model()->findAll(array( 'select' => 'id, title' ));
        return CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение списка родителей
     * @return array
     */
    public function getParentList()
    {
        $criteria         = new CDbCriteria;
        $criteria->select = 'id, title';
        $criteria->compare('id', '<>' . $this->id);

        $models = $this->findAll($criteria);

        return array( 0 => Yii::t('event', 'Корневая директория') ) + CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение родителя
     * @return string
     */
    public function getParent()
    {
        $data = $this->parentList;
        return isset($data[$this->parent_id]) ? $data[$this->parent_id] : Yii::t('event', '*неизвестно*');
    }

    /**
     * Получение дерева родителей
     * @return array
     */
    public function getParentTree()
    {
        return array( 0 => Yii::t('event', 'Корневая директория') ) + $this->getParentTreeIterator();
    }

    /**
     * Получение дерева родительских категорий
     * @param integer $parent_id ID родителя
     * @param integer $level уровень
     * @return array
     */
    public function getParentTreeIterator($parent_id = 0, $level = 1)
    {
        $criteria            = new CDbCriteria;
        $criteria->condition = 'parent_id = :parent_id AND id <> :id';
        $criteria->params    = array( ':parent_id' => (int) $parent_id, ':id' => (int) $this->id );
        $criteria->order     = 'sort';

        $results = $this->findAll($criteria);

        $items = array();

        if (empty($results))
            return $items;

        foreach($results as $result)
        {
            $childItems = $this->getParentTreeIterator($result->id, ($level + 1));
            $items += array( $result->id => str_repeat('&nbsp;&nbsp;', $level) . $result->title ) + $childItems;
        }

        return $items;
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
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return EventCategory статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

