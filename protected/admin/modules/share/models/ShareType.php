<?php

/**
 * Типы акций
 *
 * @category Model
 * @package  Module.Share
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{share_type}}':
 * @property integer $id
 * @property integer $title
 * @property integer $status
 */
class ShareType extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{share_type}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'title', 'required' ),
            array( 'status', 'numerical', 'integerOnly' => true ),
            array( 'id, title, status', 'safe', 'on' => 'search' ),
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
     * Получение списка типов
     * @return array
     */
    public function getTypeList()
    {
        $models = self::model()->findAll(array( 'select' => 'id, title' ));
        return CHtml::listData($models, 'id', 'title');
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
     * @return ShareType статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

