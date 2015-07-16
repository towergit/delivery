<?php

/**
 * Платежные системы
 *
 * @category Model
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{payment_system}}':
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $site
 * @property integer $type
 * @property integer $status
 * @property integer $debug
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property PaymentPurse[] $purses
 */
class PaymentSystem extends CActiveRecord
{

    /**
     * Тип
     */
    const TYPE_AUTOMATICAL   = 1;
    const TYPE_MANUAL        = 2;
    const TYPE_SEMIAUTOMATIC = 3;

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Отладка
     */
    const DEBUG     = 1;
    const NOT_DEBUG = 0;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{payment_system}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'title, code, type', 'required' ),
            array( 'code', 'unique', 'caseSensitive' => false ),
            array( 'status, debug, sort', 'numerical', 'integerOnly' => true ),
            array( 'type', 'in', 'range' => array_keys($this->typeList) ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'debug', 'in', 'range' => array_keys($this->debugList) ),
            array( 'site', 'safe' ),
            array( 'id, title, code, site, type, status, debug, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'purses' => array( self::HAS_MANY, 'PaymentPurse', 'payment_system_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'     => Yii::t('payment', 'ID'),
            'title'  => Yii::t('payment', 'Название'),
            'code'   => Yii::t('payment', 'Код'),
            'site'   => Yii::t('payment', 'Сайт'),
            'type'   => Yii::t('payment', 'Тип'),
            'status' => Yii::t('payment', 'Статус'),
            'debug'  => Yii::t('payment', 'Отладка'),
            'sort'   => Yii::t('payment', 'Порядок'),
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('debug', $this->debug);

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
            'notdebug' => array(
                'condition' => 'debug = :debug',
                'params'    => array( ':debug' => self::NOT_DEBUG ),
            ),
            'debug'    => array(
                'condition' => 'debug = :debug',
                'params'    => array( ':debug' => self::DEBUG ),
            ),
        );
    }

    /**
     * Поиск платежной системы по коду
     * @param string $code код
     * @return object
     */
    public function findByCode($code)
    {
        return self::model()->notdebug()->active()->findByAttributes(array( 'code' => $code ));
    }

    /**
     * Получение списка систем
     * @return array
     */
    public function getSystemList()
    {
        $models = self::model()->findAll(array( 'select' => 'id, title' ));
        return CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение списка типов
     * @return array
     */
    public function getTypeList()
    {
        return array(
            self::TYPE_AUTOMATICAL   => Yii::t('payment', 'Автоматический'),
            self::TYPE_MANUAL        => Yii::t('payment', 'Ручной'),
            self::TYPE_SEMIAUTOMATIC => Yii::t('payment', 'Полуавтоматический'),
        );
    }

    /**
     * Получение типа
     * @return string
     */
    public function getType()
    {
        $data = $this->typeList;
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('payment', '*неизвестно*');
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
     * Получение списка отладки
     * @return array
     */
    public function getDebugList()
    {
        return array(
            self::NOT_DEBUG => Yii::t('payment', 'Нет'),
            self::DEBUG     => Yii::t('payment', 'Да'),
        );
    }

    /**
     * Получение статуса отладки
     * @return string
     */
    public function getDebug()
    {
        $data = $this->debugList;
        return isset($data[$this->debug]) ? $data[$this->debug] : Yii::t('payment', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return PaymentSystem статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

