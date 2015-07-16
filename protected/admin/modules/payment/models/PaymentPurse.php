<?php

/**
 * Кошельки платежной системы
 *
 * @category Model
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{payment_purse}}':
 * @property integer $id
 * @property integer $payment_system_id
 * @property string $name
 * @property string $alias
 * @property string $pattern
 * @property string $example
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property PaymentSystem[] $paymentSystem
 */
class PaymentPurse extends CActiveRecord
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
        return '{{payment_purse}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'payment_system_id, name, alias', 'required' ),
            array( 'alias', 'unique', 'caseSensitive' => false ),
            array( 'payment_system_id, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'payment_system_id, sort', 'length', 'max' => 11 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'pattern, example', 'safe' ),
            array( 'pattern, example', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, payment_system_id, name, pattern, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
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
            'payment_system_id' => Yii::t('payment', 'Платежная система'),
            'name'              => Yii::t('payment', 'Название'),
            'alias'             => Yii::t('payment', 'Алиас'),
            'pattern'           => Yii::t('payment', 'Шаблон'),
            'example'           => Yii::t('payment', 'Пример'),
            'status'            => Yii::t('payment', 'Статус'),
            'sort'              => Yii::t('payment', 'Сортировка'),
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
        $criteria->compare('payment_system_id', $this->payment_system_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('pattern', $this->pattern, true);
        $criteria->compare('example', $this->example, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'sort',
            ),
        ));
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
     * Получение списка кошельков
     * @return array
     */
    public function getPurseList()
    {
        $models = self::model()->findAll(array( 'select' => 'id, name' ));
        return CHtml::listData($models, 'id', 'name');
    }

    /**
     * Получение списка статусов активности
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('payment', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('payment', 'Активно'),
        );
    }

    /**
     * Получение статуса активности
     * @return string
     */
    public function getActiveStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->active]) ? $data[$this->active] : Yii::t('payment', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return PaymentPurse статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

