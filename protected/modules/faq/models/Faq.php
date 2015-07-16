<?php

/**
 * Список FAQ
 *
 * @category Model
 * @package  Module.Faq
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{faq}}':
 * @property integer $id
 * @property integer $category_id
 * @property string $question
 * @property string $answer
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property FaqCategory[] $category
 */
class Faq extends CActiveRecord
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
        return '{{faq}}';
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
            array( 'category_id, question, answer', 'required' ),
            array( 'category_id, create_date, update_date, status, sort', 'numerical', 'integerOnly' => true ),
            array( 'category_id, sort', 'length', 'max' => 11 ),
            array( 'create_date, update_date', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'update_date', 'default', 'setOnEmpty' => true, 'value' => null ),
            array( 'id, category_id, question, answer, create_date, update_date, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'category' => array( self::BELONGS_TO, 'FaqCategory', 'category_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('faq', 'ID'),
            'category_id' => Yii::t('faq', 'Категория'),
            'question'    => Yii::t('faq', 'Вопрос'),
            'answer'      => Yii::t('faq', 'Ответ'),
            'create_date' => Yii::t('faq', 'Дата создания'),
            'update_date' => Yii::t('faq', 'Дата обновления'),
            'status'      => Yii::t('faq', 'Статус'),
            'sort'        => Yii::t('faq', 'Сортировка'),
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
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('question', $this->question, true);
        $criteria->compare('answer', $this->answer, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date, true);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->update_date, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.sort',
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
            self::STATUS_INACTIVE => Yii::t('faq', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('faq', 'Активен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('faq', '*неизвестно*'));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Faq статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

