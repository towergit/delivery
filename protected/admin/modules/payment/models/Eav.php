<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eav
 *
 * @author vlad
 */
class Eav extends CActiveRecord {
   
    public $attrs = array();
    
        /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName() {
        return '{{eav}}';
    }
    
        /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return PaymentLecture статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    
    
}
