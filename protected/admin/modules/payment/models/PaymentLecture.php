<?php

/**
 * Оплата лекций
 *
 * @category Model
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{payment_lecture}}':
 * @property integer $id
 * @property string $code
 * @property integer $system_id
 * @property string $sum
 * @property string $lecture
 * @property string $email
 * @property string $data
 * @property timestamp $created
 * @property timestamp $updated
 * @property string $status
 * @property string $confirmed
 * 
 * Доступные модели связей:
 * @property PaymentSystem[] $system
 */
class PaymentLecture extends CActiveRecord
{

    const STATUS_CREATE  = 'create';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILURE = 'failure';
    const CONFIRMED     = 1;
    const NOT_CONFIRMED = 0;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{payment_lecture}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'code, system_id, sum, lecture, email', 'required' ),
            array( 'system_id, confirmed', 'numerical', 'integerOnly' => true ),
            array( 'data, updated', 'safe' ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'confirmed', 'in', 'range' => array_keys($this->confirmedStatusList) ),
            array( 'id, code, system_id, sum, lecture, email, data, created, updated, status, confirmed', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'system' => array( self::BELONGS_TO, 'PaymentSystem', 'system_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'        => Yii::t('payment', 'ID'),
            'code'      => Yii::t('payment', 'Код'),
            'system_id' => Yii::t('payment', 'Система'),
            'sum'       => Yii::t('payment', 'Сумма'),
            'lecture'   => Yii::t('payment', 'Лекция'),
            'email'     => Yii::t('payment', 'Эл. адрес'),
            'data'      => Yii::t('payment', 'Данные'),
            'created'   => Yii::t('payment', 'Дата создания'),
            'updated'   => Yii::t('payment', 'Обновлено'),
            'status'    => Yii::t('payment', 'Статус'),
            'confirmed' => Yii::t('payment', 'Подтверждено'),
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
        $criteria->compare('code', $this->code);
        $criteria->compare('lecture', $this->lecture);
        $criteria->compare('sum', $this->sum);
        $criteria->compare('email', $this->email);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('confirmed', $this->confirmed);
        $criteria->with = array( 'system' );
        $criteria->compare('system.title', $this->system_id, true);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.id DESC',
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
            self::STATUS_CREATE  => Yii::t('payment', 'Создано'),
            self::STATUS_SUCCESS => Yii::t('payment', 'Оплачено'),
            self::STATUS_FAILURE => Yii::t('payment', 'Отказано'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('payment', '*неизвестно*'));
    }

    /**
     * Получение списка статусов подтверждений
     * @return array
     */
    public function getConfirmedStatusList()
    {
        return array(
            self::CONFIRMED     => Yii::t('payment', 'Да'),
            self::NOT_CONFIRMED => Yii::t('payment', 'Нет'),
        );
    }

    /**
     * Получение статуса подтверждения
     * @return string
     */
    public function getConfirmedStatus()
    {
        $data = $this->confirmedStatusList;
        return (isset($data[$this->confirmed]) ? $data[$this->confirmed] : Yii::t('payment', '*неизвестно*'));
    }

    /**
     * До начала валидации
     * @return boolean
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate())
        {
            if ($this->isNewRecord)
                $this->code = uniqid();

            return true;
        }
        else
            return false;
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if (!$this->isNewRecord)
                $this->updated = date('Y-m-d H:i:s');

            return true;
        }
        else
            return false;
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return PaymentLecture статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

