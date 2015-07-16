<?php

/**
 * Комментарии к задачам
 *
 * @category Model
 * @package  Module.Redmine
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{redmine_task_comment}}':
 * @property integer $id
 * @property integer $task_id
 * @property integer $user_id
 * @property string $message
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property Task[] $task
 * @property User[] $author_id
 */
class TaskComment extends CActiveRecord
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
        return '{{redmine_task_comment}}';
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
            array( 'task_id, user_id, message', 'required' ),
            array( 'task_id, user_id, create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'task_id, user_id', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, task_id, user_id, message, create_date, update_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'task' => array( self::BELONGS_TO, 'Task', 'task_id' ),
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
            'id'          => Yii::t('redmine', 'ID'),
            'task_id'     => Yii::t('redmine', 'Задача'),
            'user_id'     => Yii::t('redmine', 'Пользователь'),
            'message'     => Yii::t('redmine', 'Сообщение'),
            'create_date' => Yii::t('redmine', 'Дата создания'),
            'update_date' => Yii::t('redmine', 'Дата редактирования'),
            'status'      => Yii::t('redmine', 'Статус'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('task_id', $this->task_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'create_date DESC',
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
            self::STATUS_INACTIVE => Yii::t('redmine', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('redmine', 'Активен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('redmine', '*неизвестно*');
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->author_id = Yii::app()->user->id;

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return TaskComment статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

