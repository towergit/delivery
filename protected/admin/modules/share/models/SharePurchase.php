<?php

/**
 * Покупка акций
 *
 * @category Model
 * @package  Module.Share
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{share_purchase}}':
 * @property integer $id
 * @property integer $type_id
 * @property integer $count
 * @property integer $whom
 * @property integer $user_id
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $price
 * @property string $data
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property ShareType[] $type
 * @property User[] $user
 */
class SharePurchase extends CActiveRecord
{

    const SHARE_HIMSELF             = 0;
    const SHARE_STUDENT             = 1;
    const SHARE_EXTERNAL_MAN        = 2;
    const SHARE_EXTERNAL_MAN_NOT_18 = 3;
    const STATUS_SENT               = 0;
    const STATUS_CHECKED            = 1;
    const STATUS_CONDUCTED          = 2;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{share_purchase}}';
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
            array( 'type_id, count, user_id, price', 'required' ),
            array( 'type_id, count, user_id, create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'type_id, count, user_id', 'length', 'max' => 11 ),
//            array( 'whom', 'in', 'range' => array_keys($this->whomList) ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'whom, data', 'safe' ),
            array( 'id, type_id, whom, user_id, price, data, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'type' => array( self::BELONGS_TO, 'ShareType', 'type_id' ),
            'user' => array( self::BELONGS_TO, 'User', 'user_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('share', 'ID'),
            'type_id'     => Yii::t('share', 'Тип акции'),
            'count'       => Yii::t('share', 'Количество'),
            'whom'        => Yii::t('share', 'Кому'),
            'user_id'     => Yii::t('share', 'Пользователь'),
            'price'       => Yii::t('share', 'Цена'),
            'create_date' => Yii::t('share', 'Дата создания'),
            'update_date' => Yii::t('share', 'Дата редактирования'),
            'data'        => Yii::t('share', 'Данные'),
            'status'      => Yii::t('share', 'Статус'),
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
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('count', $this->count);
        $criteria->compare('whom', $this->whom);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('data', $this->data);
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
     * Получение списка на кого
     * @return array
     */
    public function getWhomList()
    {
        return array(
            self::SHARE_HIMSELF             => Yii::t('share', 'Самому себе'),
            self::SHARE_STUDENT             => Yii::t('share', 'Другому студенту'),
            self::SHARE_EXTERNAL_MAN        => Yii::t('share', 'Внешнему человеку'),
            self::SHARE_EXTERNAL_MAN_NOT_18 => Yii::t('share', 'Внешнему человеку не достигшему 18 лет'),
        );
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_SENT      => Yii::t('share', 'Отправлено'),
            self::STATUS_CHECKED   => Yii::t('share', 'Проверено'),
            self::STATUS_CONDUCTED => Yii::t('share', 'Проведено'),
        );
    }

    /**
     * Получение на кого
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('share', '*неизвестно*'));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return SharePurchase статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

