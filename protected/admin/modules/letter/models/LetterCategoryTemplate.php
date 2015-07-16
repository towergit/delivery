<?php

/**
 * Категории шаблонов
 *
 * @category Model
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{category_email}}':
 * @property integer $id
 * @property string $title
 * @property timestamp $create_date
 * @property timestamp $update_date
 * @property integer $active
 * @property integer $deleted
 * @property integer $sort
 */
class LetterCategoryTemplate extends CActiveRecord
{

	const ACTIVE		 = 1;
	const NOT_ACTIVE	 = 0;
	
	const DELETED		 = 1;
	const NOT_DELETED	 = 0;

	/**
	 * Название таблицы в базе данных
	 * @return string
	 */
	public function tableName()
	{
		return '{{category_email}}';
	}

	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'title', 'required' ),
			array( 'title', 'length', 'max' => 255 ),
			array( 'active, deleted', 'numerical', 'integerOnly' => true ),
			array( 'active', 'in', 'range' => array_keys($this->activeStatusList) ),
			array( 'update_date', 'safe' ),
			array( 'id, title, create_date, update_date, active, deleted', 'safe', 'on' => 'search' ),
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
			'id'			 => Yii::t('letter', 'ID'),
			'title'			 => Yii::t('letter', 'Название'),
			'create_date'	 => Yii::t('letter', 'Дата создания'),
			'update_date'	 => Yii::t('letter', 'Дата обновления'),
			'active'		 => Yii::t('letter', 'Активен'),
			'deleted'		 => Yii::t('letter', 'Удален'),
			'sort'			 => Yii::t('letter', 'Сортировка'),
		);
	}

	/**
	 * Именованная группа условий
	 * @return array
	 */
	public function scopes()
	{
		return array(
			'active'	 => array(
				'condition'	 => 'active = :active',
				'params'	 => array( ':active' => self::ACTIVE ),
			),
			'notactive'	 => array(
				'condition'	 => 'active = :active',
				'params'	 => array( ':active' => self::NOT_ACTIVE ),
			),
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
		$criteria->compare('title', $this->title, true);
		$criteria->compare('create_date', $this->create_date);
		$criteria->compare('update_date', $this->update_date);
		$criteria->compare('active', $this->active);
		$criteria->compare('deleted', $this->deleted);

		return new CActiveDataProvider($this,
			array(
			'criteria'	 => $criteria,
			'sort'		 => array(
				'defaultOrder' => 'id DESC',
			),
		));
	}
	
	/**
	 * Получение списка категорий
	 * @return array
	 */
	public function getCategoryList()
	{
		$models = self::model()->findAll();
		return CHtml::listData($models, 'id', 'title');
	}
	
	/**
	 * Получение списка статусов активности
	 * @return array
	 */
	public function getActiveStatusList()
	{
		return array(
			self::ACTIVE	 => Yii::t('letter', 'Да'),
			self::NOT_ACTIVE => Yii::t('letter', 'Нет'),
		);
	}

	/**
	 * Получение статуса активности
	 * @return string
	 */
	public function getActiveStatus()
	{
		$data = $this->activeStatusList;
		return (isset($data[$this->active])) ? $data[$this->active] : Yii::t('letter', '*неизвестно*');
	}

	/**
	 * Возвращает статическую модель класса ActivRecord
	 * @param string $className
	 * @return LetterCategoryTemplate статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

