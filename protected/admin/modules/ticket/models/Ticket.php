<?php

/**
 * Тикеты
 *
 * @category Model
 * @package  Module.Ticket
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{ticket}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $code
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $close_date
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property User[] $user
 * @property TicketCategory[] $category
 * @property TicketMessage[] $messages
 */
class Ticket extends CActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_CLOSE    = 2;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{ticket}}';
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
            array( 'user_id, category_id, code', 'required' ),
            array( 'code', 'unique', 'caseSensitive' => false ),
            array( 'user_id, category_id, create_date, update_date, close_date, status', 'numerical', 'integerOnly' => true ),
            array( 'user_id, category_id', 'length', 'max' => 11 ),
            array( 'create_date, update_date, close_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'update_date, close_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, user_id, category_id, code, create_date, update_date, close_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'user'         => array( self::BELONGS_TO, 'User', 'user_id' ),
            'category'     => array( self::BELONGS_TO, 'TicketCategory', 'category_id' ),
            'messages'     => array( self::HAS_MANY, 'TicketMessage', 'ticket_id', 'order' => 'messages.create_date ASC' ),
            'firstMessage' => array( self::HAS_ONE, 'TicketMessage', 'ticket_id', 'order' => 'firstMessage.create_date ASC' ),
            'lastMessage'  => array( self::HAS_ONE, 'TicketMessage', 'ticket_id', 'order' => 'lastMessage.create_date DESC' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('ticket', 'ID'),
            'user_id'     => Yii::t('ticket', 'Пользователь'),
            'category_id' => Yii::t('ticket', 'Категория'),
            'code'        => Yii::t('ticket', 'Код'),
            'create_date' => Yii::t('ticket', 'Дата создания'),
            'update_date' => Yii::t('ticket', 'Дата обновления'),
            'close_date'  => Yii::t('ticket', 'Дата закрытия'),
            'status'      => Yii::t('ticket', 'Статус'),
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
        $criteria->compare('user.username', $this->user_id, true);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('FROM_UNIXTIME(t.create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(t.update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('FROM_UNIXTIME(close_date, "%d.%m.%Y")', $this->close_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->with = array( 'user' );

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.status ASC, t.create_date DESC',
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
            self::STATUS_INACTIVE => Yii::t('ticket', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('ticket', 'Активно'),
            self::STATUS_CLOSE    => Yii::t('ticket', 'Закрыто'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ticket', '*неизвестно*');
    }

    /**
     * До валидации модели
     * @return boolean
     */
    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->user_id = Yii::app()->user->id;
            $this->code    = uniqid();
        }

        return parent::beforeValidate();
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->status == Ticket::STATUS_CLOSE)
            $this->close_date = new CDbExpression('UNIX_TIMESTAMP()');

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Ticket статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

