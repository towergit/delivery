<?php

/**
 * Банковские реквизиты
 *
 * @category Model
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{payment_bank}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $fullname
 * @property string $bank_name
 * @property string $curd_number
 * @property string $settlement_account
 * @property string $correspondent_account
 * @property string $biс
 * @property string $code_reason
 * @property string $tin
 * @property string $swift_code
 * @property string $сlearing_сode
 * 
 * Доступные модели связей:
 * @property User[] $user
 */
class PaymentBank extends CActiveRecord
{

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{payment_bank}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'user_id, name, fullname, bank_name, settlement_account', 'required' ),
            array( 'user_id', 'numerical', 'integerOnly' => true ),
            array( 'user_id', 'length', 'max' => 11 ),
            array( 'card_number', 'length', 'max' => 16 ),
            array( 'settlement_account, correspondent_account', 'length', 'max' => 20 ),
            array( 'biс', 'length', 'max' => 9 ),
            array( 'code_reason, tin, swift_code, сlearing_сode', 'safe' ),
            array( 'card_number, correspondent_account, biс', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, user_id, name, fullname, bank_name, curd_number, settlement_account, correspondent_account, biс, code_reason, tin, swift_code, сlearing_сode', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
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
            'id'                    => Yii::t('payment', 'ID'),
            'user_id'               => Yii::t('payment', 'Пользователь'),
            'name'                  => Yii::t('payment', 'Название'),
            'fullname'              => Yii::t('payment', 'ФИО получателя'),
            'bank_name'             => Yii::t('payment', 'Наименование банка'),
            'card_number'           => Yii::t('payment', 'Номер карты'),
            'settlement_account'    => Yii::t('payment', 'Расчетный счет'),
            'correspondent_account' => Yii::t('payment', 'Корреспондентский счет'),
            'biс'                   => Yii::t('payment', 'БИК'),
            'code_reason'           => Yii::t('payment', 'КПП'),
            'tin'                   => Yii::t('payment', 'ИНН банка'),
            'swift_code'            => Yii::t('payment', 'SWIFT-код банка'),
            'сlearing_сode'         => Yii::t('payment', 'Клиринговый код (для зарубежных банков)'),
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
        $criteria->compare('user.username', $this->user_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('fullname', $this->fullname, true);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('card_number', $this->card_number, true);
        $criteria->compare('settlement_account', $this->settlement_account, true);
        $criteria->compare('correspondent_account', $this->correspondent_account, true);
        $criteria->compare('biс', $this->biс, true);
        $criteria->compare('code_reason', $this->code_reason, true);
        $criteria->compare('tin', $this->tin, true);
        $criteria->compare('swift_code', $this->swift_code, true);
        $criteria->compare('сlearing_сode', $this->сlearing_сode, true);
        
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
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return PaymentBank статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

