<?php

/**
 * Комментарии
 *
 * @category Model
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{comment}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $owner_name
 * @property integer $owner_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $site
 * @property string $text
 * @property string $ip
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property User[] $author
 */
class Comment extends CActiveRecord
{

    const STATUS_NEED_CHECK = 0;
    const STATUS_APPROVED   = 1;
    const STATUS_SPAM       = 2;

    /**
     * @var string проверочный код
     */
    public $verifyCode;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{comment}}';
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
            array( 'owner_name, owner_id, name, email, text', 'required' ),
            array( 'owner_name, name, email, text, site', 'filter', 'filter' => 'trim' ),
            array( 'parent_id, owner_id, user_id, create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'name, email, site', 'length', 'max' => 255 ),
            array( 'ip', 'length', 'max' => 20 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'email', 'email' ),
            array( 'site', 'url' ),
            array( 'text', 'safe' ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
//            array( 'verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements() ),
            array( 'id, parent_id, owner_name, owner_id, user_id, name, email, site, text, ip, create_date, update_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'author' => array( self::BELONGS_TO, 'User', 'user_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('comment', 'ID'),
            'parent_id'   => Yii::t('comment', 'Родитель'),
            'owner_name'  => Yii::t('comment', 'Модель'),
            'owner_id'    => Yii::t('comment', 'Контент'),
            'name'        => Yii::t('comment', 'Имя'),
            'email'       => Yii::t('comment', 'Email'),
            'site'        => Yii::t('comment', 'Сайт'),
            'text'        => Yii::t('comment', 'Текст'),
            'verifyCode'  => Yii::t('comment', 'Код проверки'),
            'ip'          => Yii::t('comment', 'IP адрес'),
            'create_date' => Yii::t('comment', 'Дата создания'),
            'update_date' => Yii::t('comment', 'Дата обновления'),
            'status'      => Yii::t('comment', 'Статус'),
        );
    }

    /**
     * Именованная группа условий
     * @return array
     */
    public function scopes()
    {
        return array(
            'new'      => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_NEED_CHECK ),
            ),
            'approved' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_APPROVED ),
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
        $criteria->compare('owner_name', $this->owner_name, true);
        $criteria->compare('owner_id', $this->owner_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('ip', $this->ip, true);
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
     * Получение контента
     * @return string
     */
    public function getContent()
    {
        if (isset($this->owner_name, $this->owner_id))
        {
            $model = CActiveRecord::model(ucfirst($this->owner_name))->findByPk($this->owner_id);
            
            if ($model !== null)
                return CHtml::link($model->title, "$this->owner_name/$this->owner_name/update/$this->owner_id");
            else
                return Yii::t('comment', '*неизвестно*');
        }
        
        return Yii::t('comment', '*неизвестно*');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_NEED_CHECK => Yii::t('comment', 'На проверке'),
            self::STATUS_APPROVED   => Yii::t('comment', 'Одобрен'),
            self::STATUS_SPAM       => Yii::t('comment', 'Спам'),
        );
    }

    /**
     * Получение статуса активности
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status])) ? $data[$this->status] : Yii::t('comment', '*неизвестно*');
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->ip = Yii::app()->request->userHostAddress;

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Comment статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

