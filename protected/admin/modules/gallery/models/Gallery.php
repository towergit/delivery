<?php

/**
 * Галерея
 *
 * @category Model
 * @package  Module.Gallery
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{gallery}}':
 * @property integer $id
 * @property integer $category_id
 * @property integer $create_user_id
 * @property string $filename
 * @property string $path
 * @property string $alt
 * @property string $description
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property GalleryCategory[] $category
 * @property User[] $createUser
 */
class Gallery extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{gallery}}';
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
            array( 'category_id, create_user_id, filename, path', 'required' ),
            array( 'filename', 'unique', 'caseSensitive' => false ),
            array( 'category_id, create_user_id, create_date, update_date, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'category_id, create_user_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'alt, description', 'safe' ),
            array( 'id, category_id, create_user_id, filename, path, alt, description, create_date, update_date, status, sort',
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
            'category'   => array( self::BELONGS_TO, 'GalleryCategory', 'category_id' ),
            'createUser' => array( self::BELONGS_TO, 'User', 'create_user_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('gallery', 'ID'),
            'category_id'    => Yii::t('gallery', 'Категория'),
            'create_user_id' => Yii::t('gallery', 'Создал'),
            'filename'       => Yii::t('gallery', 'Название'),
            'path'           => Yii::t('gallery', 'Путь'),
            'alt'            => Yii::t('gallery', 'Альтернативный текст'),
            'description'    => Yii::t('gallery', 'Описание'),
            'create_date'    => Yii::t('gallery', 'Дата создания'),
            'update_date'    => Yii::t('gallery', 'Дата обновления'),
            'status'         => Yii::t('gallery', 'Статус'),
            'sort'           => Yii::t('gallery', 'Сортировка'),
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
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('filename', $this->filename, true);
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
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->create_user_id = Yii::app()->user->id;

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Gallery статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

