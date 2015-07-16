<?php

/**
 * Стадии обучения
 *
 * @category Model
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{training_stage}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property TrainingProgram[] $stages
 */
class TrainingStage extends CActiveRecord
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
        return '{{training_stage}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'parent_id, name', 'required' ),
            array( 'status, sort', 'numerical', 'integerOnly' => true ),
            array( 'parent_id, sort', 'length', 'max' => 11 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'id, parent_id, name, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'stages' => array( self::HAS_MANY, 'TrainingProgram', 'stage_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'        => Yii::t('training', 'ID'),
            'parent_id' => Yii::t('training', 'Родитель'),
            'name'      => Yii::t('training', 'Название'),
            'status'    => Yii::t('training', 'Статус'),
            'sort'      => Yii::t('training', 'Сортировка'),
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
        $criteria->compare('name', $this->name, true);
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
    
    /**
     * Получение годов обучения
     * @return array
     */
    public function getYearList()
    {
        $models = self::model()->findAllByAttributes(array( 'parent_id' => 0 ));
        return CHtml::listData($models, 'id', 'name');
    }
    
    /**
     * Получение названия
     * @return string
     */
    public function getTitle()
    {
        $model = self::model()->findByAttributes(array( 'id' => $this->parent_id ));
        
        if ($model)
            return $model->name . ' (' . $this->name . ')';
        
        return $this->name;
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
     * Получение списка родителей
     * @return array
     */
    public function getParentList()
    {
        $criteria         = new CDbCriteria;
        $criteria->select = 'id, name';
        $criteria->compare('id', '<>' . $this->id);

        $models = $this->findAll($criteria);

        return array( 0 => Yii::t('training', 'Без родителя') ) + CHtml::listData($models, 'id', 'name');
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
        $criteria->order     = 'id';

        $results = $this->findAll($criteria);

        $items = array();

        if (empty($results))
            return $items;

        foreach($results as $result)
        {
            $childItems = $this->getParentTreeIterator($result->id, ($level + 1));
            $items += array( $result->id => str_repeat('&nbsp;&nbsp;', $level) . $result->name ) + $childItems;
        }

        return $items;
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
     * @return TrainingStage статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

