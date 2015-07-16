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
 * @property string $param
 * @property string $label
 * @property string $description
 * @property string $type
 * @property string $default
 * @property string $value
 * @property integer $module_id
 * @property string $visible
 * 
 * Доступные модели связей:
 * @property SubSetting[] $sub
 */
class MainSetting extends CActiveRecord
{
	/**
	 * Название таблицы в базе данных
	 * @return string
	 */
	public function tableName()
	{
		return '{{setting_main}}';
	}

	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'param, label, type', 'required' ),
			array( 'param', 'unique' ),
			array( 'param', 'match', 'pattern' => '/^[A-Z0-9_]+$/', 'message' => 'Параметр должен состоять из букв латинского алфавита в вверхнем регистре' ),
			array( 'description, default, value, module_id, visible', 'safe' ),
			//array( 'value', 'required', 'on' => 'create' ),
		);
	}

	/**
	 * Правила связей с таблицами базы данных
	 * @return array
	 */
	public function relations()
	{
		return array(
			'sub' => array( self::HAS_MANY, 'SubSetting', 'parent_id' ),
		);
	}

	/**
	 * Индивидуальные метки атрибутов
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id'			 => 'ID',
			'param'			 => 'Параметр',
			'label'			 => 'Метка',
			'description'	 => 'Описание',
			'type'			 => 'Тип',
			'default'		 => 'Значение поумолчанию',
			'value'			 => 'Значение',
			'module_id'		 => 'Модуль',
			'visible'		 => 'Видно',
		);
	}

	/**
	 * Получение типов
	 * @return array
	 */
	public function getTypes()
	{
		return array(
			'char'	 => 'Текстовая строка',
			'text'	 => 'Текстовая область',
			'check'	 => 'Чекбокс',
			'radio'	 => 'Радио-кнопка',
			'list'	 => 'Выпадающий список',
		);
	}

	/**
	 * Возвращает статическую модель класса ActivRecord
	 * @param string $className
	 * @return MainSetting статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

