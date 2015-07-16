<?php

/**
 * Управление шаблонами писем
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
 * @property string $subject
 * @property string $text
 * @property integer $active
 * @property integer $deleted
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property CategoryTemplate[] $category
 */
class EmailTemplate extends CActiveRecord
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
		return '{{email_template}}';
	}

	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'title, code, subject', 'required' ),
			array( 'code', 'unique', 'caseSensitive' => false ),
			array( 'active, deleted, sort', 'numerical', 'integerOnly' => true ),
			array( 'title, code', 'length', 'max' => 255 ),
			array( 'text', 'safe' ),
			array( 'id, category_id, title, code, subject, text, active, deleted, sort', 'safe', 'on' => 'search' ),
		);
	}

	/**
	 * Правила связей с таблицами базы данных
	 * @return array
	 */
	public function relations()
	{
		return array(
			'category' => array( self::BELONGS_TO, 'CategoryTemplate', 'category_id' ),
		);
	}

	/**
	 * Индивидуальные метки атрибутов
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id'			 => LetterModule::t('ID'),
			'category_id'	 => LetterModule::t('Категория'),
			'title'			 => LetterModule::t('Название'),
			'code'			 => LetterModule::t('Код'),
			'subject'		 => LetterModule::t('Тема'),
			'text'			 => LetterModule::t('Текст'),
			'active'		 => LetterModule::t('Активен'),
			'deleted'		 => LetterModule::t('Удален'),
			'sort'			 => LetterModule::t('Сортировка'),
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
		$criteria->compare('code', $this->code, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('deleted', $this->deleted);
		$criteria->compare('sort', $this->sort);
		$criteria->with		 = array( 'category' );
		$criteria->together	 = true;

		$criteria->compare('category.title', $this->category_id, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * Получение шаблона по коду
	 * @param string $code
	 * @return object
	 * @throws CHttpException
	 */
	public static function getTemplate($code)
	{
		$model = self::model()->active()->findByAttributes(array( 'code' => $code ));

		if ($model === null)
			throw new CHttpException(404, LetterModule::t('Искомый шаблон не найден.'));

		return $model;
	}
	
	/**
	 * Получение количества аттрибутов шаблона
	 * @param string $text
	 * @return integer
	 */
	public static function getCountTemplateAttributes($text)
	{
		preg_match_all('/%[a-z0-9]+%/i', $text, $matches);
		$array = array();

		if (count($matches[0]) > 1)
		{
			foreach($matches[0] as $string)
				$array[] = str_replace('%', '', $string);
		}
		
		return count($array);
	}
	
	/**
	 * Получение аттрибутов шаблона
	 * @param string $text
	 * @return array
	 */
	public static function getTemplateAttributes($text)
	{
		preg_match_all('/%[a-z0-9]+%/i', $text, $matches);
		$array = array();

		if (count($matches[0]) > 1)
		{
			foreach($matches[0] as $string)
				$array[] = str_replace('%', '', $string);
		}
		else
			$array[] = str_replace('%', '', $matches[0][0]);

		return $array;
	}

	/**
	 * Возвращает статическую модель класса ActivRecord
	 * @param string $className
	 * @return EmailTemplate статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

