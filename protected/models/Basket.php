<?php

/**
 * Корзина
 *
 * @category Model
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{basket}}':
 * @property string $session_id
 * @property integer $object
 */
class Basket extends ActiveRecord {

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName() {
        return '{{basket}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules() {
        return array(
            array('session_id, object', 'required'),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels() {
        return array(
            'session_id' => Yii::t('main', 'Идентификатор пользователя'),
            'object' => Yii::t('main', 'Объекты'),
        );
    }

    /**
     * Получение общей суммы
     * @return float
     */
    public static function getTotalSum() {
        $sum = 0;
        $model = self::model()->findByAttributes(array('session_id' => Yii::app()->session->sessionId));

        if (!$model)
            return $sum;

        $ids = CJSON::decode($model->object);

        foreach ($ids as $id) {
            $object = ObjectHelp::model()->findByPk($id);

            $sum = $sum + $object->totalSum;
        }

        return $sum;
    }

    /**
     * Добавление нового значения
     * @param mixed $id идентификаторы объектов
     */
    public function setItem($id) {

        $model = new Basket();
        $model->session_id = Yii::app()->session->sessionId;

        if (!is_array($id)){
             $id = array(array($id => 0));
        }
           

        $ids = CJSON::encode($id);

        $model->object = $ids;
        $model->save();
        Yii::app()->session->add('basket_id', $model->id);
        
    }

    /* else
      {
      $id = array($id);
      $ids = CJSON::encode($id);

      $model->object = $ids;
      $model->save();

      if (is_array($id))
      {
      foreach($id as $i)
      {
      if (!in_array($i, $ids))
      {
      array_push($ids, $i);
      $model->object = CJSON::encode($ids);
      $model->save();
      }
      }
      }
      else
      {
      if (!in_array($id, $ids))
      {
      array_push($ids, $id);
      $model->object = CJSON::encode($ids);
      $model->save();
      }
      }
      }
      } */

    /**
     * Получение ебъектов
     * @return array
     */
    public function getObjects() {
    #   $model = self::model()->findByAttributes(array('session_id' => Yii::app()->session->sessionId));

     #   if (!$model)
      #      return array();
        return CJSON::decode($this->object);
    }
    
    public function updateObjects($objects) {

        if(!is_array($objects))
            throw new Exception ('Нужен массив', 400);
        
        $basketObjects = $this->objects;
        

        foreach ($objects as $key => $val) {

            foreach ($basketObjects as &$bas)
                if(isset($bas[$key])) {

                     $bas[$key] = $val;
                } 

        }

        $this->object = CJSON::encode($basketObjects);
        $this->save();

    }
    
    public function keys() {
          foreach ($this->objects as $obj) {
              
            foreach ($obj as $key => $value)
              if(count($this->objects) == 1){
                  $keys = $key;
                  break;
              }else {
                  $keys[] = $key;
              }
              
          }

         return $keys;
        
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Basket статический метод класса
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
