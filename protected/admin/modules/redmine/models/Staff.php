<?php

/**
 * Персонал
 *
 * @category Model
 * @package  Module.Redmine
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{redmine_staff}}':
 * @property integer $id
 */
class Staff extends CActiveRecord
{
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{redmine_staff}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'id', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array();
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('redmine', 'ID'),
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

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'sort',
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Staff статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

