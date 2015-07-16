<?php

/**
 * Категории объектов
 *
 * @category Model
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{object_category}}':
 * @property integer $id
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
 * @property ObjectHelp[] $objects
 */
class ObjectCategory extends ActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    
    public $image;
    
     /*
     * Иденитификатор владельца
     * 
     * @var type 
     */
    protected $_owner = 'сategory';
         
    
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{object_category}}';
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
            'imagesUpload' => array(
                'class' => 'ext.ImagesUploadBehavior',
                'uploadPath' => 'сategory',
                'singlePic' => true,
                'fileField' => 'image'
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
            array( 'title, alias', 'required' ),
            array( 'create_date, update_date, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'text, meta_keywords, meta_description', 'safe' ),
            array( 'text, update_date, meta_keywords, meta_description', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, title, alias, text, create_date, update_date, meta_keywords, meta_description, status, sort',
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
            'objects' => array( self::HAS_MANY, 'ObjectHelp', 'category_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('object', 'ID'),
            'title'            => Yii::t('object', 'Название'),
            'alias'            => Yii::t('object', 'Алиас'),
            'text'             => Yii::t('object', 'Текст'),
            'create_date'      => Yii::t('object', 'Дата создания'),
            'update_date'      => Yii::t('object', 'Дата обновления'),
            'meta_keywords'    => Yii::t('object', 'Мета ключевые слова'),
            'meta_description' => Yii::t('object', 'Мета описание'),
            'status'           => Yii::t('object', 'Статус'),
            'sort'             => Yii::t('object', 'Сортировка'),
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
    public function getCategory2List()
    {
        $models = self::model()->active()->findAll(array( 'select' => 'alias, title' ));
        return array( 'all' => Yii::t('main', 'Все') ) + CHtml::listData($models, 'alias', 'title');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('object', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('object', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('object', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return ObjectCategory статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

