<?php

/**
 * Пакеты помощи
 *
 * @category Model
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{object_package}}':
 * @property integer $id
 * @property integer $help_id
 * @property string $title
 * @property float $sum
 * @property float $sum_collected
 * @property integer $status
 */
class ObjectPackage extends ActiveRecord
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
        return '{{object_package}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'help_id, title, sum', 'required' ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'sum_collected', 'safe' ),
            array( 'id, help_id, title, sum, sum_collected, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'object'   => array( self::BELONGS_TO, 'ObjectHelp', 'help_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('object', 'ID'),
            'help_id'       => Yii::t('object', 'Объект помощи'),
            'title'         => Yii::t('object', 'Навзвание'),
            'sum'           => Yii::t('object', 'Сумма'),
            'sum_collected' => Yii::t('object', 'Собранная сумма'),
            'status'        => Yii::t('object', 'Статус'),
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
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {        

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('help_id', $this->help_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id DESC',
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
            self::STATUS_INACTIVE => Yii::t('object', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('object', 'Активен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('object', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return ObjectPackage статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
}

