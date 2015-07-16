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
 * @property string $description
 * @property string $text
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $publish_date
 * @property integer $unpublish_date
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $elect
 * @property integer $visits
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property MaterialCategory[] $category
 * @property User[] $createUser
 * @property User[] $updateUser
 */
class Material extends ActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_ARCHIVE  = 2;

    /**
     * Избранный
     */
    const ELECT_NO  = 0;
    const ELECT_YES = 1;

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
            'multilingual'       => array(
                'class'               => 'ext.MultilingualBehavior',
                'localizedAttributes' => array( 'title', 'text', 'meta_keywords', 'meta_description' ),
                'langTableName'       => 'material_lang',
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
            array( 'category_id, title, text, alias', 'required' ),
            array( 'alias', 'unique', 'caseSensitive' => false ),
//            array( 'alias', 'AliasValidator' ),
            array( 'category_id, create_user_id, update_user_id, create_date, update_date, publish_date, unpublish_date, elect, visits, status, sort',
                'numerical', 'integerOnly' => true ),
            array( 'category_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date, publish_date, unpublish_date', 'length', 'max' => 10 ),
            array( 'elect', 'in', 'range' => array_keys($this->electList) ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'description, meta_keywords, meta_description', 'safe' ),
            array( 'description, update_user_id, update_date, meta_keywords, meta_description, unpublish_date', 'default',
                'setOnEmpty' => true, 'value'      => null ),
            array( 'id, category_id, title, alias, description, text, create_date, update_date, publish_date, unpublish_date, meta_keywords, meta_description, elect, visits, status, sort',
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
            'category'   => array( self::BELONGS_TO, 'MaterialCategory', 'category_id' ),
            'createUser' => array( self::BELONGS_TO, 'User', 'create_user_id' ),
            'updateUser' => array( self::BELONGS_TO, 'User', 'update_user_id' ),
            'comments'   => array( self::HAS_MANY, 'Comment', 'owner_id', 'condition' => 'comments.owner_name = "material"' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('material', 'ID'),
            'category_id'      => Yii::t('material', 'Категория'),
            'title'            => Yii::t('material', 'Название'),
            'alias'            => Yii::t('material', 'Алиас'),
            'description'      => Yii::t('material', 'Описание'),
            'text'             => Yii::t('material', 'Текст'),
            'create_user_id'   => Yii::t('material', 'Создал'),
            'update_user_id'   => Yii::t('material', 'Обновил'),
            'create_date'      => Yii::t('material', 'Дата создания'),
            'update_date'      => Yii::t('material', 'Дата обновления'),
            'publish_date'     => Yii::t('material', 'Дата нач. публикации'),
            'unpublish_date'   => Yii::t('material', 'Дата кон. публикации'),
            'meta_keywords'    => Yii::t('material', 'Мета ключевые слова'),
            'meta_description' => Yii::t('material', 'Мета описание'),
            'elect'            => Yii::t('material', 'Избранный'),
            'visits'           => Yii::t('material', 'Просмотров'),
            'status'           => Yii::t('material', 'Статус'),
            'sort'             => Yii::t('material', 'Сортировка'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'description' => Yii::t('material', 'Если данное поле пустое то краткое описание будет взято из текста'),
        );
    }

    /**
     * Условие по умолчанию
     * @return array
     */
    public function defaultScope()
    {
        return $this->multilingual->localizedCriteria();
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
            'elect'    => array(
                'condition' => 't.elect = :elect',
                'params'    => array( ':elect' => self::ELECT_YES ),
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
        $criteria->compare('t.category_id', $this->category_id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('createUser.username', $this->create_user_id, true);
        $criteria->compare('updateUser.username', $this->update_user_id, true);
        $criteria->compare('FROM_UNIXTIME(publish_date, "%d.%m.%Y")', $this->publish_date, true);
        $criteria->compare('FROM_UNIXTIME(unpublish_date, "%d.%m.%Y")', $this->unpublish_date, true);
        $criteria->compare('elect', $this->elect, true);
        $criteria->compare('visits', $this->visits, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.sort', $this->sort);

        $criteria->with = array( 'createUser', 'updateUser' );

        return new CActiveDataProvider($this,
            array(
            'criteria' => $this->multilingual->modifySearchCriteria($criteria),
            'sort'     => array(
                'defaultOrder' => 't.sort',
            ),
        ));
    }
    
    public function countComments() {
        
        Yii::import('application.modules.comment.models.*');
        
        $criteria            = new CDbCriteria;
        $criteria->condition = 't.owner_name = :ownerName AND t.owner_id = :ownerId AND t.status = :status';
        $criteria->params    = array(
            ':ownerName' => 'material',
            ':ownerId'   => $this->id,
            ':status'    => Comment::STATUS_APPROVED,
        );

        return count(Comment::model()->findAll($criteria));
    }

    /**
     * Получение даты конца публикации
     * @return string
     */
    public function getUnpublishDate()
    {
        return $this->unpublish_date != 0 ? Date::format($this->unpublish_date) : Yii::t('material', 'никогда');
    }

    /**
     * Получение списка избранных
     * @return array
     */
    public function getElectList()
    {
        return array(
            self::ELECT_NO  => Yii::t('material', 'Нет'),
            self::ELECT_YES => Yii::t('material', 'Да'),
        );
    }

    /**
     * Получение избранного
     * @return string
     */
    public function getElect()
    {
        $data = $this->electList;
        return isset($data[$this->elect]) ? $data[$this->elect] : Yii::t('material', '*неизвестно*');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('material', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('material', 'Активнен'),
            self::STATUS_ARCHIVE  => Yii::t('material', 'Архивен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('material', '*неизвестно*');
    }

    /**
     * До валидации модели
     * @return boolean
     */
    public function beforeValidate()
    {
        if ($this->publish_date)
            $this->publish_date = strtotime($this->publish_date);

        if ($this->unpublish_date)
            $this->unpublish_date = strtotime($this->unpublish_date);

        return parent::beforeValidate();
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

