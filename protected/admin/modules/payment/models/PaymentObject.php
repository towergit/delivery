<?php

Yii::import('application.admin.modules.object.models.*');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payment
 *
 * @author vlad
 */
class PaymentObject extends CActiveRecord {

    public $total_sum;
    public $rest_sum;
    public $object_help;
    public $id_oject;
    private $_statusList = array(
        0 => 'Созданый',
        1 => 'Удачный платеж',
        2 => 'Неудачный платеж'
    );

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName() {
        return '{{payment}}';
    }
    
    /**
     * Поведения
     * @return array
     */
    public function behaviors()
    {
        return array(
            'emailBahevior' => array(
                'class' => 'ext.EmailBahavior'
            ),
        );
    }
    
    public function rules() {
        return array(
            array('sum, system, name, email, phone, status, ids_list', 'required'),
            array('email', 'email'),
            array('id, object_help, total_sum, rest_sum, code, sum, ids_list,id_oject, name, date, email, phone, status, object, system',
                'safe'),
            array('id, object_help, total_sum, rest_sum, code, sum, name, id_oject, ids_list, date, email, phone, status, object, system',
                'safe', 'on' => 'search'),
        );
    }

    public function getobject() {

        $object = ObjectHelp::model()->findByAttributes(array('uniqid' => $this->ids_list));

        return $object;
    }

    public function getStatusString() {

        if (isset($this->_statusList[$this->status])) {
            $result = $this->_statusList[$this->status];
        } else {
            $result = 'unknow';
        }
        return $result;
    }

    public function getrestsum() {

        $this->ids_list;

        $payments = $this->findAllByAttributes(array('ids_list' => $this->ids_list), array('order' => 'id ASC'));

        $restsum = 0;

        for ($i = 0; $i < count($payments); $i++) {

            if ($payments[$i]->status != 1) {

                if ($payments[$i]->id == $this->id) {
                    break;
                } else {
                    continue;
                }
            }

            $restsum += $payments[$i]->sum;

            if ($payments[$i]->id == $this->id) {
                break;
            };
        }

        return $restsum;
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels() {
        return array(
            'code' => Yii::t('payment', 'Код операции'),
            'sum' => Yii::t('payment', 'Сумма платежа'),
            'name' => Yii::t('payment', 'Имя плательщика'),
            'email' => Yii::t('payment', 'E-mail'),
            'date' => Yii::t('payment', 'Дата'),
            'phone' => Yii::t('payment', 'Телефон'),
            'status' => Yii::t('payment', 'Статус'),
            'object' => Yii::t('payment', 'Объект'),
            'system' => Yii::t('payment', 'Система'),
            'rest_sum' => Yii::t('payment', 'Собрано'),
            'total_sum' => Yii::t('payment', 'Всего'),
            'id_oject' => Yii::t('payment', 'ID Объекта помощи'),
            'ids_list' => Yii::t('payment', 'Объект помощи')
        );
    }

    public function getStatusList() {
        return $this->_statusList;
    }

    /**
     * Получение списка систем
     * @return array
     */
    public function getSystemList() {
        
        $paysystem = PaymentSystem::model()->findAll();            
        return CHtml::listData($paysystem, 'id', 'title');
        
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search() {
        $criteria = new CDbCriteria;
        $objectList = null;

        if ($this->ids_list) {
            $objectCriteria = clone $criteria;

            $objectCriteria->compare('title', $this->ids_list, true);


            $objectsHelp = ObjectHelp::model()->findAll($objectCriteria);


            foreach ($objectsHelp as $object) {
                $objectList[] = $object->uniqid;
            }
        }

        
        $system = PaymentSystem::model()->findByPk($this->system);
        $systemCode = $system->code;
        
        $criteria->compare('t.code', $this->code, true);

        if ($this->ids_list)
            $criteria->addInCondition('ids_list', $objectList);

        $criteria->compare('ids_list', $this->id_oject, true);
        $criteria->compare('sum', $this->sum, true);
        $criteria->compare('system', $systemCode,true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.date DESC',
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return PaymentBank статический метод класса
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        parent::beforeSave();
       
        $system = PaymentSystem::model()->findByPk($this->system);
        $systemCode = $system->code;
        
        if ($this->isNewRecord) {

            $basket = new Basket();
            $basket->item = $this->ids_list;
            
            $criteria = new CDbCriteria();

            $criteria->compare("DATE_FORMAT(date,'%Y-%m-%d')", date('Y-m-d'));
            $criteria->order = "id DESC";
            $criteria->limit = 1;

            $lastPayment = Payment::model()->find($criteria);

            if ($lastPayment)
                $lastPaymentID = (int) substr($lastPayment->code, -4);
            else
                $lastPaymentID = 0;

            $offset = 4 - strlen($lastPaymentID);

            if ($offset)
                $paymentCount = str_repeat('0', $offset) . ++$lastPaymentID;
            else
                $paymentCount = ++$lastPaymentID;

            $paymentCode = $systemCode . date('dmY') . $paymentCount;

            $this->code = $paymentCode;
            $this->session_id = Yii::app()->session->sessionId;
        }
        
        $helpModel = ObjectHelp::model()->findByPk($this->ids_list);
        $this->system = $systemCode;    
        $this->ids_list = $helpModel->uniqid;
            
        return true;
    }

    public function afterSave() {
        
        $objects = array();
        // Корзина
        $basket = Basket::model()->findByPk($this->basket_id);
// 
        if($this->status != Payment::STATUS_SUCCESS || $this->status == Payment::STATUS_FAILURE || !$basket){

            return true;
        }
         
        $this->emailBahevior->paymentComplite();  
        
        if($basket)
            $objects = CJSON::decode($basket->object);
            $objects = $basket->objects;
            $count = count($objects);

        foreach ($objects as $key => $value) {
            $object_id = key($value);
            //payment sum
            $sum = $value[$object_id];

            $object = ObjectHelp::model()->findByPk($object_id);
            $package = ObjectPackage::model()->find(array(
                'condition' => 'help_id = :help_id',
                'params' => array(':help_id' => $object->id),
                'order' => 'sort',
            ));
            $difference = $package->sum - $package->sum_collected;

            if ($difference >= $sum) {
                $package->sum_collected = $package->sum_collected + $sum;
                $package->save();
            } else {
                $package->sum_collected = $package->sum_collected + $difference;
                $package->save();

                $sum = $sum - $difference;

               // $this->payment($sum, $package->id);
            }
        }
        
        if($basket)
            $basket->delete();
        
        return true;
    }

    /**
     * Оплата
     * @param float $sum сумма
     * @param intger $id идентификатор пакета
     */
    protected function payment($sum, $id) {
        if ($sum != 0) {
            $package = ObjectPackage::model()->find(array(
                'condition' => 'help_id = :help_id AND id <> :id',
                'params' => array(':help_id' => $id, ':id' => $id),
            ));
            
            $difference = $package->sum - $package->sum_collected;
            

                if ($difference >= $sum) {
                        $package->sum_collected = $package->sum_collected + $sum;
                        $package->save();
                    } /*else {
                        $package->sum_collected = $package->sum_collected + $difference;

                        //$package->save();

                        $sum = $sum - $difference;

                        $this->payment($sum, $this->id);
                    }*/

        }
    }

}
