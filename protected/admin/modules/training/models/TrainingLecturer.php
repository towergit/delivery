<?php

/**
 * Преподователи
 *
 * @category Model
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{coach}}':
 * @property integer $id
 * @property string $name
 * @property string $photo
 * @property string $description
 * @property string $text
 * @property integer $status
 */
class TrainingLecturer extends CActiveRecord
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
        return '{{coach}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'name', 'required' ),
            array( 'status', 'numerical', 'integerOnly' => true ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'photo, description, text', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, name, photo, description, text, status', 'safe', 'on' => 'search' ),
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
            'name'        => Yii::t('training', 'Название'),
            'photo'       => Yii::t('training', 'Фото'),
            'description' => Yii::t('training', 'Описание'),
            'text'        => Yii::t('training', 'Текст'),
            'status'      => Yii::t('training', 'Статус'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id',
            ),
        ));
    }
    
    /**
     * Получение списка преподавателей
     * @return array
     */
    public function getLecturerList()
    {
        $models = self::model()->findAll(array( 'select' => 'id, name' ));
        return array( 0 => Yii::t('training', 'Без преподователя') ) + CHtml::listData($models, 'id', 'name');
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
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('training', '*неизвестно*'));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return TrainingLecturer статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

