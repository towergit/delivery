<?php

/**
 * Пулы акций
 *
 * @category Model
 * @package  Module.Share
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{share_pool}}':
 * @property integer $id
 * @property integer $title
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 */
class SharePool extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{share_pool}}';
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
            array( 'title', 'required' ),
            array( 'create_date, update_date, status', 'numerical', 'integerOnly' => true ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'id, title, create_date, update_date, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('share', 'ID'),
            'title'       => Yii::t('share', 'Название'),
            'create_date' => Yii::t('share', 'Дата создания'),
            'update_date' => Yii::t('share', 'Дата обновления'),
            'status'      => Yii::t('share', 'Статус'),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
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
            self::STATUS_INACTIVE => Yii::t('share', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('share', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('share', '*неизвестно*'));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return SharePool статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

