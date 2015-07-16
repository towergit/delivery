<?php

/**
 * Программа обучения
 *
 * @category Model
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{training_program}}':
 * @property integer $id
 * @property integer $stage_id
 * @property integer $educator_id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property TrainingStage[] $stage
 * @property TrainingLecturer[] $lecturer
 */
class TrainingProgram extends CActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * @var integer год
     */
    public $year;

    /**
     * @var integer месяц
     */
    public $month;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{training_program}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'year, month', 'required' ),
            array( 'educator_id, name', 'required' ),
            array( 'stage_id, educator_id, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'stage_id, educator_id, sort', 'length', 'max' => 11 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'description', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, stage_id, educator_id, name, description, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'stage'    => array( self::BELONGS_TO, 'TrainingStage', 'stage_id' ),
            'lecturer' => array( self::BELONGS_TO, 'TrainingLecturer', 'educator_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('training', 'ID'),
            'stage_id'    => Yii::t('training', 'Стадия обучения'),
            'educator_id' => Yii::t('training', 'Преподователь'),
            'name'        => Yii::t('training', 'Название'),
            'description' => Yii::t('training', 'Описание'),
            'status'      => Yii::t('training', 'Статус'),
            'sort'        => Yii::t('training', 'Сортировка'),
            'year'        => Yii::t('training', 'Год'),
            'month'       => Yii::t('training', 'Месяц'),
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
        $criteria->compare('stage_id', $this->stage_id);
        $criteria->compare('educator_id', $this->educator_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'sort',
            ),
        ));
    }
    
    public function getYearOnMonth()
    {
        $model = TrainingStage::model()->findByAttributes(array( 'id' => $this->stage_id ));
        
        if ($model === null)
            return false;
        
        return $model->parent_id;
    }
    
    public function getMonth()
    {
        $id = $this->yearOnMonth;
        
        $models = TrainingStage::model()->findAllByAttributes(array( 'parent_id' => $id ));
        return CHtml::listData($models, 'id', 'name');
    }

    /**
     * Получение списка категорий
     * @return array
     */
    public function getCategoryList()
    {
        $models = self::model()->findAll(array( 'select' => 'id, name' ));
        return CHtml::listData($models, 'id', 'name');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('training', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('training', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('training', '*неизвестно*');
    }
    
    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->month)
            $this->stage_id = $this->month;

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return TrainingProgram статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

