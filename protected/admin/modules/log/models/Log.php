<?php
Yii::import('admin.modules.user.models.User');

/**
 * Журнал событий
 *
 * @category Model
 * @package  Module.Log
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{log}}':
 * @property integer $id
 * @property string $module
 * @property string $model
 * @property string $table
 * @property integer $user_id
 * @property string $operation
 * @property string $attribute
 * @property string $value
 * @property string $params
 * @property timestamp $created
 */
class Log extends CActiveRecord
{

	/**
	 * @var string событие
	 */
	public $item;

	/**
	 * Название таблицы в базе данных
	 * @return string
	 */
	public function tableName()
	{
		return '{{log}}';
	}

	/**
	 * Правила проверки для атрибутов модели
	 * @return array
	 */
	public function rules()
	{
		return array(
			array( 'module, model, table, user_id, operation, attribute, value', 'required' ),
			array( 'params', 'safe' ),
			array( 'id, module, model, table, user_id, operation, attribute, value, params, created', 'safe', 'on' => 'search' ),
		);
	}

	/**
	 * Правила связей с таблицами базы данных
	 * @return array
	 */
	public function relations()
	{
		return array(
			'user' => array( self::BELONGS_TO, 'User', 'user_id' ),
		);
	}

	/**
	 * Индивидуальные метки атрибутов
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'id'		 => 'ID',
			'module'	 => 'Модуль',
			'table'		 => 'Таблица',
			'model'		 => 'Модель',
			'user_id'	 => 'Пользователь',
			'operation'	 => 'Операция',
			'attribute'	 => 'Атрибут',
			'value'		 => 'Значение',
			'params'	 => 'Параметры',
			'created'	 => 'Дата создания',
			'item'		 => 'Событие',
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
		$criteria->compare('module', $this->module);
		$criteria->compare('table', $this->table, true);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('operation', $this->operation);
		$criteria->compare('created', $this->created);

		return new CActiveDataProvider($this,
			array(
			'criteria'	 => $criteria,
			'sort'		 => array(
				'defaultOrder' => 'id DESC',
			),
		));
	}

	/**
	 * Получение события
	 * @return string
	 */
	public function getEvent()
	{
		$modelName = ucfirst($this->model);

		Yii::import('admin.modules.' . $this->module . '.models.' . $modelName);

		$model		 = new $modelName;
		$attribute	 = $model->getAttributeLabel($this->attribute);

		return self::model()->getOperation($this->operation, $model->getName(), $attribute, $this->value);
	}

	public function getParam($param)
	{
		$modelName = ucfirst($this->model);
		Yii::import('admin.modules.' . $this->module . '.models.' . $modelName);

		$model	 = new $modelName;
		$param	 = $model->getAttributeLabel($param);
		return $param;
	}

	/**
	 * Получение всех операций
	 * @return array
	 */
	public static function getOperations()
	{
		return array(
			'create'	 => 'Создание записи в таблице %class%, где поле %attribute% равно %value%',
			'update'	 => 'Редактирование записи в таблице %class%, где поле %attribute% равно %value%',
			'trash'		 => 'Перемещение записи из таблицы %class% в корзину, где поле %attribute% равно %value%',
			'restore'	 => 'Восстановление записи из таблицы %class% из корзины, где поле %attribute% равно %value%',
			'delete'	 => 'Удаление записи из таблицы %class%, где поле %attribute% равно %value%',
		);
	}

	/**
	 * Получение операции
	 * @param string $operation название операции
	 * @param string $model название класса
	 * @param string $pk первичный ключ записи 
	 * @return string
	 */
	public function getOperation($operation, $model, $attribute, $value)
	{
		$array	 = self::getOperations();
		$string	 = $array[$operation];

		$string	 = str_replace('%class%', '<em>' . $model . '</em>', $string);
		$string	 = str_replace('%attribute%', '<em>' . $attribute . '</em>', $string);
		$string	 = str_replace('%value%', '<em>' . $value . '</em>', $string);
		return $string;
	}

	/**
	 * Возвращает статическую модель класса ActivRecord
	 * @param string $className
	 * @return Log статический метод класса
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

}

