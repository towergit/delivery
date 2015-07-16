<?php

/**
 * Вывод средств
 *
 * @category Model
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{output_money}}':
 * @property integer $id
 * @property string $code
 * @property integer $user_id
 * @property integer $payment_system_id
 * @property integer $purse_id
 * @property integer $sum
 * @property integer $update_date
 * @property integer $publish_date
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property User[] $user
 * @property PaymentUserPurse[] $purse
 * @property PaymentSystem[] $paymentSystem
 */
class OutputMoney extends CActiveRecord
{

    /**
     * Статус
     */
    const STATUS_SENT    = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILURE = 2;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{output_money}}';
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
            array( 'code, user_id, purse_id, sum', 'required' ),
            array( 'code', 'unique', 'caseSensitive' => false ),
            array( 'user_id, payment_system_id, purse_id, create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'user_id, payment_system_id, purse_id', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, code, user_id, payment_system_id, purse_id, sum, create_date, update_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'user'          => array( self::BELONGS_TO, 'User', 'user_id' ),
            'purse'         => array( self::BELONGS_TO, 'PaymentUserPurse', 'purse_id' ),
            'paymentSystem' => array( self::BELONGS_TO, 'PaymentSystem', 'payment_system_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('payment', 'ID'),
            'user_id'           => Yii::t('payment', 'Пользователь'),
            'purse_id'          => Yii::t('payment', 'Кошелек'),
            'payment_system_id' => Yii::t('payment', 'Платежная система'),
            'code'              => Yii::t('payment', 'Код'),
            'sum'               => Yii::t('payment', 'Сумма'),
            'create_date'       => Yii::t('payment', 'Дата создания'),
            'update_date'       => Yii::t('payment', 'Дата обновления'),
            'status'            => Yii::t('payment', 'Статус'),
        );
    }

    /**
     * Именованная группа условий
     * @return array
     */
    public function scopes()
    {
        return array(
            'sent'    => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_SENT ),
            ),
            'success' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_SUCCESS ),
            ),
            'failure' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_FAILURE ),
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('user.username', $this->user_id, true);
        $criteria->compare('purse_id', $this->purse_id, true);
        $criteria->compare('payment_system_id', $this->payment_system_id, true);
        $criteria->compare('sum', $this->sum, true);
        $criteria->compare('FROM_UNIXTIME(t.create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(t.update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('t.status', $this->status);

        $criteria->with = array( 'user' );

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
            self::STATUS_SENT    => Yii::t('payment', 'Отправлен'),
            self::STATUS_SUCCESS => Yii::t('payment', 'Подтвержден'),
            self::STATUS_FAILURE => Yii::t('payment', 'Отменен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('payment', '*неизвестно*');
    }

    /**
     * До валидации модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->code = uniqid();
        
        return parent::beforeSave();
    }
    
    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return OtputMoney статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

