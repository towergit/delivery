<?php

/**
 * Избранные материалы
 *
 * @category Model
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Elect extends Material
{

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.category_id', $this->category_id);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('createUser.username', $this->create_user_id, true);
        $criteria->compare('updateUser.username', $this->update_user_id, true);
        $criteria->compare('FROM_UNIXTIME(publish_date, "%d.%m.%Y")', $this->publish_date, true);
        $criteria->compare('FROM_UNIXTIME(unpublish_date, "%d.%m.%Y")', $this->unpublish_date, true);
        $criteria->compare('elect', Material::ELECT_YES);
        $criteria->compare('visits', $this->visits, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.sort', $this->sort);

        $criteria->with = array( 'createUser', 'updateUser' );

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.sort',
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Elect статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

