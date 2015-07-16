<?php

/**
 * Управление настройками
 *
 * @category Model
 * @package  Module.Setting
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{setting}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $label
 * @property string $value
 */
class SubSetting extends CActiveRecord
{
	public $radio;
	
	/**
	 * Название таблицы в базе данных
	 * @return string
	 */
	public function tableName()
	{
		return '{{setting_sub}}';
	}

	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'parent_id, title, value', 'required' ),
		);
	}

	/**
	 * Правила связей с таблицами базы данных
	 * @return array
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * Индивидуальные метки атрибутов
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id'		 => 'ID',
			'parent_id'	 => 'Родитель',
			'title'		 => 'Название',
			'value'		 => 'Значение',
		);
	}

	/**
	 * Возвращает статическую модель класса ActivRecord
	 * @param string $className
	 * @return SubSetting статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

