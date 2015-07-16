<?php

/**
 * Загрузка файлов
 *
 * @category Model
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{upload_file}}':
 * @property integer $id
 * @property string $module
 * @property integer $content_id
 * @property string $file
 */
class UploadFile extends CActiveRecord {

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName() {
        return '{{upload_file}}';
    }

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
        );
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules() {
        return array(
            array('owner_name, owner_id, file', 'safe'),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations() {
        return array();
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'owner_name' => 'Модуль',
            'owner_id' => 'ID контента',
            'file' => 'Файл',
        );
    }

    /**
     * Получение всех файлов
     * @param string $module модуль
     * @param integer $contentID ID контента
     * @return object
     */
    public static function findAllFiles($module, $contentID) {
        return self::model()->findAllByAttributes(array('owner_name' => $module, 'owner_id' => $contentID));
    }

    /**
     * Получение файла
     * @param string $module модуль
     * @param integer $content_id ID контента
     * @return object
     */
    public static function getFile($module, $content_id) {
        $criteria = new CDbCriteria();
        $criteria->order = 'id ASC';
        $criteria->condition = 'owner_name = :module AND owner_id = :content_id';
        $criteria->params = array(':module' => $module, ':content_id' => $content_id);

        $model = self::model()->find($criteria);

        if ($model !== null)
            return $model;

        return null;
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return UploadFile статический метод класса
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
