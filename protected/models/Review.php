<?php

/**
 * Отзывы
 *
 * @category Model
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{review}}':
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $company
 * @property integer $status
 * @property integer $sort
 */
class Review extends ActiveRecord
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
        return '{{review}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'name, text', 'required' ),
            array( 'status, sort', 'numerical', 'integerOnly' => true ),
            array( 'status, sort', 'length', 'max' => 11 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'company', 'default', 'setOnEmpty' => true, 'value' => null ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'      => Yii::t('main', 'ID'),
            'name'    => Yii::t('main', 'Имя'),
            'text'    => Yii::t('main', 'Отзыв'),
            'company' => Yii::t('main', 'Компания'),
            'status'  => Yii::t('main', 'Статус'),
            'sort'    => Yii::t('main', 'Сортировка'),
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
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('main', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('main', 'Активнен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('main', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Review статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

