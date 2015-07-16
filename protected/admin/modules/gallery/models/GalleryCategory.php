<?php

/**
 * Категории галереи
 *
 * @category Model
 * @package  Module.Gallery
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{gallery_category}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property integer $create_date
 * @property integer $update_date
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property Gallery[] $gallery
 */
class GalleryCategory extends CActiveRecord
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
        return '{{gallery_category}}';
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
            array( 'alias', 'unique', 'caseSensitive' => false ),
            array( 'create_date, update_date, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'parent_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'text, meta_keywords, meta_description', 'safe' ),
            array( 'parent_id, text', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, parent_id, title, alias, text, create_date, update_date, meta_keywords, meta_description, status, sort',
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
            'gallery' => array( self::HAS_MANY, 'Gallery', 'category_id', 'order' => 'gallery.create_date DESC' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('gallery', 'ID'),
            'parent_id'        => Yii::t('gallery', 'Родитель'),
            'title'            => Yii::t('gallery', 'Название'),
            'alias'            => Yii::t('gallery', 'Алиас'),
            'text'             => Yii::t('gallery', 'Текст'),
            'create_date'      => Yii::t('gallery', 'Дата создания'),
            'update_date'      => Yii::t('gallery', 'Дата обновления'),
            'meta_keywords'    => Yii::t('gallery', 'Мета ключевые слова'),
            'meta_description' => Yii::t('gallery', 'Мета описание'),
            'status'           => Yii::t('gallery', 'Статус'),
            'sort'             => Yii::t('gallery', 'Сортировка'),
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
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('text', $this->text, true);
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

        return array( 0 => Yii::t('gallery', 'Корневая директория') ) + CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение родителя
     * @return string
     */
    public function getParent()
    {
        $data = $this->parentList;
        return isset($data[$this->parent_id]) ? $data[$this->parent_id] : Yii::t('gallery', '*неизвестно*');
    }

    /**
     * Получение дерева родителей
     * @return array
     */
    public function getParentTree()
    {
        return array( 0 => Yii::t('gallery', 'Корневая директория') ) + $this->getParentTreeIterator();
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
            self::STATUS_INACTIVE => Yii::t('gallery', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('gallery', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('gallery', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return GalleryCategory статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

