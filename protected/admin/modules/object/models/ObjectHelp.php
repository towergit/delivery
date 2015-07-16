<?php

/**
 * Объекты помощи
 *
 * @category Model
 * @package  Module.Object
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{object_help}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $image
 * @property string $text
 * @property string $country
 * @property string $city
 * @property integer $publish_date
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $elect
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property ObjectPackage[] $packages
 */
class ObjectHelp extends ActiveRecord {

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PERFORMED = 2;
    const STATUS_EXECUTED = 3;

    /**
     * Избранный
     */
    const ELECT_NO = 0;
    const ELECT_YES = 1;

    /**
     * Копирование id объекта
     * 
     * @var type 
     */
    protected $_id;
    
    /**
     *
     * Иденитификатор владельца
     * 
     * @var type 
     */
    protected $_owner = 'object';
    
    /**
     * Поведения
     * @return array
     */
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_date',
                'updateAttribute' => 'update_date',
            ),
            'imagesUpload' => array(
                'class' => 'ext.ImagesUploadBehavior',
                'uploadPath' => 'object',
                'fileField' => 'image'
            ),
        );
    }

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName() {
        return '{{object_help}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules() {
        return array(
            array('title, alias, text', 'required'),
            array('alias', 'unique', 'caseSensitive' => false),
            array('publish_date, create_date, update_date, elect, status', 'numerical', 'integerOnly' => true),
            array('publish_date, create_date, update_date', 'length', 'max' => 10),
            array('update_date, country, city', 'default', 'setOnEmpty' => true, 'value' => null),
            array('elect', 'in', 'range' => array_keys($this->electList)),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('id, title, alias, category_id, uniqid, sort', 'safe'),
            array('id, title, alias, image, category_id, sort,uniqid, text, publish_date, create_date, update_date, elect, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations() {
        return array(
            'packages' => array(self::HAS_MANY, 'ObjectPackage', 'help_id', 'order' => 'packages.sort'),
            'category' => array(self::BELONGS_TO, 'ObjectCategory', 'category_id'),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('object', 'ID'),
            'create_date' => Yii::t('object', 'Дата создания'),
            'update_date' => Yii::t('object', 'Дата обновления'),
            'status' => Yii::t('object', 'Статус'),
            'uniqid' => Yii::t('object', 'Уникальный идентификатор'),
        );
    }

    /**
     * Именованная группа условий
     * @return array
     */
    public function scopes() {
        return array(
            'inactive' => array(
                'condition' => 'status = :status',
                'params' => array(':status' => self::STATUS_INACTIVE),
            ),
            'active' => array(
                'condition' => 'status = :status',
                'params' => array(':status' => self::STATUS_ACTIVE),
            ),
            'elect' => array(
                'condition' => 'elect = :elect',
                'params' => array(':elect' => self::ELECT_YES),
            )
        );
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date);
        $criteria->compare('FROM_UNIXTIME(update_date, "%d.%m.%Y")', $this->create_date);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'create_date DESC',
            ),
        ));
    }

    /**
     * Получение общей суммы
     * @return float
     */
    public function getTotalSum() {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(sum) as sum';
        $criteria->compare('status', ObjectPackage::STATUS_ACTIVE);
        $criteria->compare('help_id', $this->id);

        $model = ObjectPackage::model()->find($criteria);

        if ($model === null)
            return 0;

        return $model->getAttribute('sum');
    }

    /**
     * Получение общей собранной суммы
     * @return float
     */
    public function getTotalSumCollected() {
        $criteria = new CDbCriteria;
        $criteria->select = 'SUM(sum_collected) as sum';
        $criteria->compare('status', ObjectPackage::STATUS_ACTIVE);
        $criteria->compare('help_id', $this->id);

        $model = ObjectPackage::model()->find($criteria);

        if ($model === null)
            return 0;

        return $model->getAttribute('sum');
    }

    /**
     * Получение всех объектов помощи
     */
    public static function getHelpsList() {

        $model = self::model()->findAll();

        return CHtml::listData($model, 'id', 'title');
    }

    /**
     * Получение процента
     * @return float
     */
    public function getPercent() {
        if (!$this->totalSum)
            return 0;

        return round(($this->totalSumCollected * 100) / $this->totalSum, 1);
    }

    /**
     * Получение списка избранных
     * @return array
     */
    public function getElectList() {
        return array(
            self::ELECT_NO => Yii::t('object', 'Нет'),
            self::ELECT_YES => Yii::t('object', 'Да'),
        );
    }

    /**
     * Получение избранного
     * @return string
     */
    public function getElect() {
        $data = $this->electList;
        return isset($data[$this->elect]) ? $data[$this->elect] : Yii::t('object', '*неизвестно*');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList() {
        return array(
            self::STATUS_INACTIVE => Yii::t('object', 'Не активен'),
            self::STATUS_ACTIVE => Yii::t('object', 'Активен'),
            self::STATUS_PERFORMED => Yii::t('object', 'Выполняется'),
            self::STATUS_EXECUTED => Yii::t('object', 'Выполнен'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus() {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('object', '*неизвестно*');
    }
    
    public function beforeDelete() {
          if(parent::beforeSave() === false) {
            return false;
          }
  
        $this->_id = $this->id;

        return true;
    }

    public function afterDelete() {

        $UploadFilemodels = UploadFile::model()->findAllByAttributes(array( 'owner_name' => $this->_owner,'owner_id' => $this->_id));

        foreach ($UploadFilemodels as $Uploadfile) {
            $this->imagesUpload->deleteFile(null,$Uploadfile);
        }

        $res = ObjectPackage::model()->deleteAllByAttributes(array(
            'help_id' => $this->_id
        ));

        return true;
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return ObjectHelp статический метод класса
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
