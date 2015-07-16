<?php

/**
 * Категории материалов
 *
 * @category Model
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{material}}':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $publish_date
 * @property integer $start_publish_date
 * @property integer $end_publish_date
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $visits
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property MaterialCategory[] $category
 * @property User[] $createUser
 * @property User[] $updateUser
 */
class Material extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{material}}';
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
//            'multilingual'       => array(
//                'class'               => 'ext.MultilingualBehavior',
//                'localizedAttributes' => array( 'title', 'text', 'meta_keywords', 'meta_description' ),
//                'langTableName'       => 'material_lang',
//            ),
        );
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'category_id, title, text, alias', 'required' ),
            array( 'alias', 'unique', 'caseSensitive' => false ),
            array( 'alias', 'AliasValidator' ),
            array( 'category_id, create_user_id, update_user_id, create_date, update_date, publish_date, start_publish_date, end_publish_date, visits, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'category_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date, publish_date, start_publish_date, end_publish_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'meta_keywords, meta_description', 'safe' ),
            array( 'update_user_id, update_date, meta_keywords, meta_description, start_publish_date, end_publish_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, title, alias, text, create_date, update_date, publish_date, meta_keywords, meta_description, start_publish_date, end_publish_date, visits, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'category'   => array( self::BELONGS_TO, 'MaterialCategory', 'category_id' ),
            'createUser' => array( self::BELONGS_TO, 'User', 'create_user_id' ),
            'updateUser' => array( self::BELONGS_TO, 'User', 'update_user_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'                 => Yii::t('material', 'ID'),
            'category_id'        => Yii::t('material', 'Категория'),
            'title'              => Yii::t('material', 'Название'),
            'alias'              => Yii::t('material', 'Алиас'),
            'text'               => Yii::t('material', 'Текст'),
            'create_user_id'     => Yii::t('material', 'Создал'),
            'update_user_id'     => Yii::t('material', 'Обновил'),
            'create_date'        => Yii::t('material', 'Дата создания'),
            'update_date'        => Yii::t('material', 'Дата обновления'),
            'publish_date'       => Yii::t('material', 'Дата публикации'),
            'start_publish_date' => Yii::t('material', 'Дата начала публикации'),
            'end_publish_date'   => Yii::t('material', 'Дата конца публикации'),
            'meta_keywords'      => Yii::t('material', 'Мета ключевые слова'),
            'meta_description'   => Yii::t('material', 'Мета описание'),
            'visits'             => Yii::t('material', 'Просмотров'),
            'status'             => Yii::t('material', 'Статус'),
            'sort'               => Yii::t('material', 'Сортировка'),
        );
    }

    /**
     * Условие по умолчанию
     * @return array
     */
//    public function defaultScope()
//    {
//        return $this->multilingual->localizedCriteria();
//    }

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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('createUser.username', $this->create_user_id, true);
        $criteria->compare('updateUser.username', $this->update_user_id, true);
        $criteria->compare('FROM_UNIXTIME(publish_date, "%d.%m.%Y")', $this->publish_date, true);
        $criteria->compare('FROM_UNIXTIME(end_publish_date, "%d.%m.%Y")', $this->end_publish_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.sort', $this->sort);
        
        $criteria->with = array( 'category', 'createUser', 'updateUser' );

        return new CActiveDataProvider($this,
            array(
//            'criteria' => $this->multilingual->modifySearchCriteria($criteria),
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.sort',
            ),
        ));
    }

    /**
     * Получение списка категорий
     * @return array
     */
    public function getCategoryList()
    {
        $models = MaterialCategory::model()->findAll(array( 'select' => 'id, title' ));
        return CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение даты начала публикации
     * @return string
     */
    public function getPublishDate()
    {
        return $this->start_publish_date != 0 ? Date::format($this->start_publish_date) : Date::format($this->publish_date);
    }

    /**
     * Получение даты конца публикации
     * @return string
     */
    public function getUnpublishDate()
    {
        return $this->end_publish_date != 0 ? Date::format($this->end_publish_date) : Yii::t('material', 'никогда');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('material', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('material', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('material', '*неизвестно*'));
    }
    
    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if (!$this->publish_date)
            $this->publish_date = new CDbExpression('UNIX_TIMESTAMP()');
        
        if ($this->isNewRecord)
            $this->create_user_id = Yii::app()->user->id;
        else
            $this->update_user_id = Yii::app()->user->id;

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Material статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

