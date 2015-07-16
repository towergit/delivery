<?php

/**
 * Модули
 *
 * @category Model
 * @package  Module.Module
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{module}}':
 * @property integer $id
 * @property string $name
 * @property integer $sort
 */
class Module extends CActiveRecord
{
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{module}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'name', 'required' ),
            array( 'name', 'unique', 'caseSensitive' => false ),
            array( 'name', 'length', 'max' => 20 ),
            array( 'sort', 'numerical', 'integerOnly' => true ),
            array( 'id, name, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'   => Yii::t('module', 'ID'),
            'name' => Yii::t('module', 'Название'),
            'sort' => Yii::t('module', 'Сортировка'),
        );
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'sort',
            ),
        ));
    }

    /**
     * Получение списка модулей
     * @return array
     */
    public function getModuleList()
    {
        $modules = self::model()->findAll(array( 'select' => 'id, name' ));

        if ($modules === null)
            return array();

        $array = array();

        foreach($modules as $item)
        {
            $module           = Yii::app()->getModule($item->name);
            $array[$item->id] = $module->name;
        }

        return $array;
    }

    /**
     * Получение версии
     * @return string
     */
    public function getVersion()
    {
        $module = Yii::app()->getModule($this->name);
        $class  = '';

        if (preg_match('/^Beta/', $module->version))
            $class = 'label-info';
        elseif (preg_match('/^Alpha/', $module->version))
            $class = 'label-warning';
        else
            $class = 'label-success';

        return '<span class="label ' . $class . '">' . $module->version . '</span>';
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Module статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

