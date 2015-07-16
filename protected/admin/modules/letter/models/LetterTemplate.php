<?php

/**
 * Шаблоны
 *
 * @category Model
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{email_template}}':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $code
 * @property string $text
 * @property timestamp $create_date
 * @property timestamp $update_date
 * @property integer $active
 * @property integer $deleted
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property LetterCategoryTemplate[] $category
 */
class LetterTemplate extends CActiveRecord
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
		return '{{email_template}}';
	}

	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'category_id, title, code, text', 'required' ),
			array( 'title, code', 'length', 'max' => 255 ),
			array( 'code', 'unique', 'caseSensitive' => true ),
			array( 'code', 'match', 'pattern' => '/^([a-z_])+$/i' ),
			array( 'category_id, active, deleted, sort', 'numerical', 'integerOnly' => true ),
			array( 'active', 'in', 'range' => array_keys($this->activeStatusList) ),
			array( 'update_date', 'safe' ),
			array( 'id, category_id, title, code, text, update_date, active, deleted, sort', 'safe', 'on' => 'search' ),
		);
	}

	/**
	 * Правила связей с таблицами базы данных
	 * @return array
	 */
	public function relations()
	{
		return array(
			'category' => array( self::BELONGS_TO, 'LetterCategoryTemplate', 'category_id' ),
		);
	}

	/**
	 * Индивидуальные метки атрибутов
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id'			 => Yii::t('letter', 'ID'),
			'category_id'	 => Yii::t('letter', 'Категория'),
			'title'			 => Yii::t('letter', 'Название'),
			'code'			 => Yii::t('letter', 'Код'),
			'text'			 => Yii::t('letter', 'Текст'),
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

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.title', $this->title, true);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('t.create_date', $this->create_date);
		$criteria->compare('t.update_date', $this->update_date);
		$criteria->compare('t.active', $this->active);
		$criteria->compare('t.deleted', $this->deleted);
		$criteria->with = array( 'category' );
		$criteria->compare('category.title', $this->category_id);

		return new CActiveDataProvider($this,
			array(
			'criteria'	 => $criteria,
			'sort'		 => array(
				'defaultOrder' => 't.id DESC',
			),
		));
	}
	
	/**
	 * Найти по коду
	 * @param string $code код
	 * @return object
	 */
	public function findByCode($code)
	{
		return self::model()->findByAttributes(array( 'code' => $code ));
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
	 * @return LetterTemplate статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

