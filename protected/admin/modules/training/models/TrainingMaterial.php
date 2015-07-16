<?php

/**
 * Материалы программы обучения
 *
 * @category Model
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{training_material}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $program_id
 * @property string $title
 * @property string $data
 * @property string $description
 * @property integer $type
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property TrainingProgram[] $program
 */
class TrainingMaterial extends CActiveRecord
{

    /**
     * Тип
     */
    const TYPE_NONE  = 0;
    const TYPE_FILE  = 1;
    const TYPE_VIDEO = 2;
    const TYPE_AUDIO = 3;

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
        return '{{training_material}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'parent_id, program_id, title, type', 'required' ),
            array( 'parent_id, program_id, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'parent_id, program_id, sort', 'length', 'max' => 11 ),
            array( 'type', 'in', 'range' => array_keys($this->typeList) ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'data, description', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, parent_id, program_id, title, data, type, status, sort', 'safe', 'on' => 'search' ),
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
            'program' => array( self::BELONGS_TO, 'TrainingProgram', 'program_id' ),
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
            'parent_id'   => Yii::t('training', 'Родитель'),
            'program_id'  => Yii::t('training', 'Программа'),
            'title'       => Yii::t('training', 'Название'),
            'data'        => Yii::t('training', 'Данные'),
            'description' => Yii::t('training', 'Описание'),
            'type'        => Yii::t('training', 'Тип'),
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
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('program_id', $this->program_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('type', $this->type);
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
        $models = self::model()->findAll(array( 'select' => 'id, title' ));
        return CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение списка родителей
     * @return array
     */
    public function getParentList()
    {
        $criteria         = new CDbCriteria;
        $criteria->select = 'id, title';
        $criteria->compare('id', '<>' . $this->id);

        $models = $this->findAll($criteria);

        return array( 0 => Yii::t('training', 'Без родителя') ) + CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение родителя
     * @return string
     */
    public function getParent()
    {
        $data = $this->parentList;
        return isset($data[$this->parent_id]) ? $data[$this->parent_id] : Yii::t('training', '*неизвестно*');
    }

    /**
     * Получение дерева родителей
     * @return array
     */
    public function getParentTree()
    {
        return array( 0 => Yii::t('training', 'Без родителя') ) + $this->getParentTreeIterator();
    }

    /**
     * Получение дерева родительских категорий
     * @param integer $parent_id ID родителя
     * @param integer $level уровень
     * @return array
     */
    public function getParentTreeIterator($parent_id = 0, $level = 1)
    {
        $criteria            = new CDbCriteria;
        $criteria->condition = 'parent_id = :parent_id AND id <> :id';
        $criteria->params    = array( ':parent_id' => (int) $parent_id, ':id' => (int) $this->id );
        $criteria->order     = 'sort';

        $results = $this->findAll($criteria);

        $items = array();

        if (empty($results))
            return $items;

        foreach($results as $result)
        {
            $childItems = $this->getParentTreeIterator($result->id, ($level + 1));
            $items += array( $result->id => str_repeat('&nbsp;&nbsp;', $level) . $result->title ) + $childItems;
        }

        return $items;
    }

    /**
     * Получение списка типов
     * @return array
     */
    public function getTypeList()
    {
        return array(
            self::TYPE_NONE  => Yii::t('training', 'Без типа'),
            self::TYPE_FILE  => Yii::t('training', 'Файл'),
            self::TYPE_VIDEO => Yii::t('training', 'Видео'),
            self::TYPE_AUDIO => Yii::t('training', 'Аудио'),
        );
    }

    /**
     * Получение типа
     * @return string
     */
    public function getType()
    {
        $data = $this->typeList;
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('training', '*неизвестно*');
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
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return TrainingMaterial статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

