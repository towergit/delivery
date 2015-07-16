<?php

/**
 * Слушатели
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Listener extends User
{
    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('last_visit', $this->last_visit, true);
        $criteria->compare('status', $this->status);
        $criteria->with     = array( 'assignment' );
        $criteria->together = true;
        
        $criteria->addSearchCondition(
            new CDbExpression('CONCAT(assignment.itemname)'), 'listener'
        );

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'create_date DESC',
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Listener статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

