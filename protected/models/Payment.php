<?php

/**
 * Оплата
 *
 * @category Model
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{payment}}':
 * @property integer $id
 * @property string $code
 * @property float $sum
 * @property string $system
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $status
 */
class Payment extends ActiveRecord {

    /**
     * Статус
     */
    const STATUS_CREATE = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAILURE = 2;

    public $basket;

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
    public function behaviors() {
        return array(
            'emailBahevior' => array(
                'class' => 'ext.EmailBahavior'
            ),
        );
    }

    public function scopes() {
        return array(
            'lastRecord' => array(
                'condition' => 'MAX(id)',
                # 'order' => '"id" ASC',
                'limit' => 1,
            ),
        );
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules() {
        return array(
            array('sum, system, name, email, phone', 'required'),
            array('sum', 'compareSum'),
            array('sum', 'sumValidation'),
            array('email', 'email'),
        );
    }

    public function compareSum($attribute, $params) {

        if ($this->$attribute <= 0) {
            $this->addError($attribute, 'Сумма должна быть больше нуля.');
        }
    }

    public function sumValidation($attribute, $params) {

        $basket = Basket::model()->findByPk(Yii::app()->session->itemAt('basket_id'));

        if ($basket) {
            
            $objects = json_decode($basket->object, true);
            
            //Для мультиплатежей
            if(count($objects) > 1)
                return true;

            list($objectId) = $objects;
            list($objectId) = array_keys($objectId);
            $objectHelp = ObjectHelp::model()->findByPk($objectId);

            if ($this->$attribute > $objectHelp->TotalSum - $objectHelp->TotalSumCollected) {
                $this->addError($attribute, 'Максимальная сумма помощи по данном объекту составляет ' . ($objectHelp->TotalSum - $objectHelp->TotalSumCollected) . '!');
            }
        }
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('main', 'ID'),
            'sum' => Yii::t('main', 'Другая сумма'),
            'system' => Yii::t('main', 'Способ оплаты'),
            'name' => Yii::t('main', 'Имя'),
            'email' => Yii::t('main', 'Email'),
            'phone' => Yii::t('main', 'Телефон'),
            'status' => Yii::t('main', 'Статус'),
        );
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();

            $criteria->compare("DATE_FORMAT(date,'%Y-%m-%d')", date('Y-m-d'));
            $criteria->order = "id DESC";
            $criteria->limit = 1;

            $lastPayment = Payment::model()->find($criteria);
             
            $lastPayment->code = preg_replace('/_\d{4}$/i','',$lastPayment->code);

            if ($lastPayment)
                $lastPaymentID = (int) substr($lastPayment->code, -4);
            else
                $lastPaymentID = 0;

            $offset = 4 - strlen($lastPaymentID);

            if ($offset)
                $paymentCount = str_repeat('0', $offset) . ++$lastPaymentID;
            else
                $paymentCount = ++$lastPaymentID;

            $paymentCode = $this->system . date('dmY') . $paymentCount.'_'. substr(time(), -4);

            $this->code = $paymentCode;
            $this->session_id = Yii::app()->session->sessionId;
        }

        return parent::beforeSave();
    }

    public function setadditionalParams($data) {
        
        $this->basket_id = $this->basket->id;
        $mockArray = array();
        $helpsObjects = $this->basket->objects;

        if (isset($data['multiple'])) {

            $multipleArray = $data['multiple']['data'];
            $tmp = array();

            foreach ($multipleArray as $key => $value) {
                $mockArray[$key] = $value;
            }
        } else {
            $mockArray = array($this->basket->keys() => $this->sum);
        }

        $this->basket->updateObjects($mockArray);
        
        $idsList = array();
        
        foreach ($helpsObjects as $key => $value) {

            $helpModel = ObjectHelp::model()->findByPk(key($value));
            $idsList[] = $helpModel->uniqid;
        }

        $this->ids_list = implode($idsList, ',');
        $this->deleteAllByAttributes(array('basket_id' => $this->basket_id));
        
    }

    public function afterSave() {
        parent::afterSave();
        if ($this->status == Payment::STATUS_SUCCESS){
           $this->emailBahevior->paymentComplite();
        }            
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Payment статический метод класса
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
