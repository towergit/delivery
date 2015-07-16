<?php

/**
 * Управление категориями шаблонов
 *
 * @category Model
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{category_email}}':
 * @property integer $id
 * @property string $title
 * @property integer $active
 * @property integer $deleted
 * @property integer $sort
 */
class CategoryTemplate extends CActiveRecord
{

	const ACTIVE		 = 1;
	const NOTACTIVE		 = 0;
	const DELETED		 = 1;
	const NOTDELETED	 = 0;

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
			array( 'active, deleted, sort', 'numerical', 'integerOnly' => true ),
			array( 'title', 'length', 'max' => 255 ),
			array( 'id, title, active, deleted, sort', 'safe', 'on' => 'search' ),
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
			'id'		 => LetterModule::t('ID'),
			'title'		 => LetterModule::t('Название'),
			'active'	 => LetterModule::t('Активен'),
			'deleted'	 => LetterModule::t('Удален'),
			'sort'		 => LetterModule::t('Сортировка'),
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
				'condition' => 'active = ' . self::ACTIVE,
			),
			'notactive'	 => array(
				'condition' => 'active = ' . self::NOTACTIVE,
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
		$criteria->compare('active', $this->active);
		$criteria->compare('deleted', '0');
		$criteria->compare('sort', $this->sort);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * Получение всех активных категорий
	 * @return array
	 */
	public static function getAllCategories()
	{
		$model = self::model()->active()->findAll();
		return CHtml::listData($model, 'id', 'title');
	}

	/**
	 * Возвращает статическую модель класса ActivRecord
	 * @param string $className
	 * @return CategoryTemplate статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

