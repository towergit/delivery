<?php

/**
 * Управляющие
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Manager extends User
{
    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria           = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date);
        $criteria->compare('FROM_UNIXTIME(last_visit, "%d.%m.%Y")', $this->last_visit);
        $criteria->compare('status', $this->status);
        $criteria->with     = array( 'profile', 'assignment' => array(
            'condition' => '
                itemname = "manager" OR 
                itemname = "audit" OR 
                itemname = "financeManager" OR 
                itemname = "administrator" OR 
                itemname = "superadministrator"
            ',
        ) );
        $criteria->together = true;
        $criteria->compare('profile.phone', $this->phone, true);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'create_date DESC',
            ),
            'pagination' => array(
                'pageSize' => (int)Yii::app()->session['pageCount'] ? Yii::app()->session['pageCount'] : 10,
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Manager статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

