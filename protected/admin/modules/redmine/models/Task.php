<?php

/**
 * Задачи
 *
 * @category Model
 * @package  Module.Redmine
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{redmine_task}}':
 * @property integer $id
 * @property integer $project_id
 * @property integer $author_id
 * @property string $title
 * @property string $description
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $end_date
 * @property integer $done_ratio
 * @property integer $priority
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property Project[] $project
 * @property User[] $author_id
 */
class Task extends CActiveRecord
{

    /**
     * Приоритет
     */
    const PRIORITY_HIGH   = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW    = 3;

    /**
     * Статус
     */
    const STATUS_NEW     = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_REVIEW  = 3;
    const STATUS_CLOSED  = 4;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{redmine_task}}';
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
            array( 'project_id, title, description, priority', 'required' ),
            array( 'title', 'length', 'max' => 100 ),
            array( 'project_id, author_id, create_date, update_date, end_date, done_ratio, priority, status', 'numerical', 'integerOnly' => true ),
            array( 'project_id, author_id', 'length', 'max' => 11 ),
            array( 'create_date, update_date, end_date', 'length', 'max' => 10 ),
            array( 'priority', 'in', 'range' => array_keys($this->priorityList) ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, project_id, author_id, title, description, create_date, update_date, end_date, done_ratio, priority, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'project' => array( self::BELONGS_TO, 'Project', 'project_id' ),
            'author'  => array( self::BELONGS_TO, 'User', 'author_id' ),
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
            'project_id'  => Yii::t('redmine', 'Проект'),
            'author_id'   => Yii::t('redmine', 'Автор'),
            'title'       => Yii::t('redmine', 'Заголовок'),
            'description' => Yii::t('redmine', 'Описание'),
            'create_date' => Yii::t('redmine', 'Дата создания'),
            'update_date' => Yii::t('redmine', 'Дата редактирования'),
            'end_date'    => Yii::t('redmine', 'Дата окончания'),
            'done_ratio'  => Yii::t('redmine', 'Готовность, %'),
            'priority'    => Yii::t('redmine', 'Приоритет'),
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
            'new'    => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_NEW ),
            ),
            'inwork' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_IN_WORK ),
            ),
            'review' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_REVIEW ),
            ),
            'closed' => array(
                'condition' => 't.status = :status',
                'params'    => array( ':status' => self::STATUS_CLOSED ),
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
        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('author_id', $this->author_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('FROM_UNIXTIME(end_date, "%d.%m.%Y")', $this->end_date, true);
        $criteria->compare('done_ratio', $this->done_ratio);
        $criteria->compare('priority', $this->priority);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'create_date DESC, status ASC',
            ),
        ));
    }

    /**
     * Получение списка процентного соотношения сделанной работы
     * @return array
     */
    public function getDoneRatioList()
    {
        $data = array();

        for($i = 10; $i < 100; $i + 10)
            $data[$i] = $i;

        return $data;
    }

    /**
     * Получение соотношения сделанной работы
     * @return string
     */
    public function getDoneRatio()
    {
        $data = $this->doneRatioList;
        return isset($data[$this->done_ratio]) ? $data[$this->done_ratio] : Yii::t('redmine', '*неизвестно*');
    }

    /**
     * Получение списка приоритетов
     * @return array
     */
    public function getPriorityList()
    {
        return array(
            self::PRIORITY_HIGH   => Yii::t('redmine', 'Высокий'),
            self::PRIORITY_MEDIUM => Yii::t('redmine', 'Средний'),
            self::PRIORITY_LOW    => Yii::t('redmine', 'Низкий'),
        );
    }

    /**
     * Получение приоритета
     * @return string
     */
    public function getPriority()
    {
        $data = $this->priorityList;
        return isset($data[$this->priority]) ? $data[$this->priority] : Yii::t('redmine', '*неизвестно*');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_NEW     => Yii::t('redmine', 'Новая'),
            self::STATUS_IN_WORK => Yii::t('redmine', 'В работе'),
            self::STATUS_REVIEW  => Yii::t('redmine', 'На проверке'),
            self::STATUS_CLOSED  => Yii::t('redmine', 'Закрытая'),
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
        {
            $this->status    = self::STATUS_NEW;
            $this->author_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Task статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

