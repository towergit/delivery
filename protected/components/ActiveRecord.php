<?php

/**
 * Модель
 *
 * @category Module
 * @package  Modules
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ActiveRecord extends CActiveRecord
{
    /**
     * Индивидуальные описания атрибутов
     * @return array
     */
    public function attributeDescriptions()
    {
        return array();
    }
    
    /**
     * Получение описания атрибута
     * @param string $attribute
     * @return string
     */
    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();
        return isset($descriptions[$attribute]) ? $descriptions[$attribute] : '';
    }
}

