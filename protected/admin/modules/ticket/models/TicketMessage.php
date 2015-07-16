<?php

/**
 * Сообщения тикетов
 *
 * @category Model
 * @package  Module.Ticket
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{ticket_user}}':
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $user_id
 * @property integer $manager_id
 * @property string $message
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property Ticket[] $ticket
 * @property User[] $user
 * @property User[] $manager
 */
class TicketMessage extends CActiveRecord
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
        return '{{ticket_user}}';
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
            array( 'ticket_id, message', 'required' ),
            array( 'ticket_id, user_id, manager_id, create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'ticket_id, user_id, manager_id', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'user_id, manager_id, update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, ticket_id, user_id, manager_id, message, create_date, update_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'ticket'  => array( self::BELONGS_TO, 'Ticket', 'ticket_id' ),
            'user'    => array( self::BELONGS_TO, 'User', 'user_id' ),
            'manager' => array( self::BELONGS_TO, 'User', 'manager_id' ),
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
            'ticket_id'   => Yii::t('ticket', 'Тикет'),
            'user_id'     => Yii::t('ticket', 'Пользователь'),
            'manager_id'  => Yii::t('ticket', 'Менеджер'),
            'message'     => Yii::t('ticket', 'Сообщение'),
            'create_date' => Yii::t('ticket', 'Дата создания'),
            'update_date' => Yii::t('ticket', 'Дата обновления'),
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
        $criteria->compare('user.username', $this->user_id);
        $criteria->compare('manager.username', $this->manager_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('FROM_UNIXTIME(t.create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(t.update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->with = array( 'user', 'manager' );

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.create_date',
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
        $auth   = Yii::app()->authManager;
        $userId = Yii::app()->user->id;

        if ($auth->checkAccess('createTicket', $userId))
            $this->manager_id = $userId;
        else
            $this->user_id    = $userId;

        return parent::beforeValidate();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return TicketMessage статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

