<?php
Yii::import('admin.modules.log.models.Log');

/**
 * Работа с журналом событий
 *
 * @category Behavior
 * @package  Behaviors
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class EventLogBehavior extends CActiveRecordBehavior
{

	/**
	 * @var string название поля удаления
	 */
	public $deleteField = 'deleted';

	/**
	 * @var string название атрибута
	 */
	public $attributeName;

	/**
	 * @var string название операции 
	 */
	private $_operation;

	/**
	 * @var string параметры
	 */
	private $_params;

	/**
	 * Действие до сохранения
	 * @param type $event
	 */
	public function beforeSave($event)
	{
		if (!$this->owner->isNewRecord)
		{
			$oldParams		 = $this->getInitialAttributes();
			$newParams		 = $this->owner->attributes;
			$this->_params	 = $this->getResultComparisonParameters($oldParams, $newParams);

			if ($this->_params === null)
				return false;

			if ($this->_operation === null)
				$this->_operation = 'update';
		}
		else
			$this->_operation = 'create';

		$this->addItem();
	}

	/**
	 * Действие до удаления
	 * @param type $event
	 */
	public function beforeDelete($event)
	{
		$this->_operation = 'delete';
		$this->addItem();
	}

	/**
	 * Получение первоначальных аттрибутов
	 * @return array
	 */
	private function getInitialAttributes()
	{
		$model = $this->getOwner()->findByPk($this->owner->getPrimaryKey());
		return $model->getAttributes();
	}

	/**
	 * Получение результата сравнивания параметров
	 * @param array $oldParams старые параметры
	 * @param array $newParams новые параметры
	 * @return string
	 * @throws CHttpException
	 */
	private function getResultComparisonParameters($oldParams, $newParams)
	{
		$array	 = array();
		$params	 = null;

		if (!$oldParams || !$newParams)
			throw new CHttpException(400, 'Нет параметров для сравнения');

		foreach($oldParams as $key => $value)
		{
			if ($newParams[$key] != $value)
			{
				if ($key == $this->deleteField)
				{
					if ($newParams[$key] != 0)
						$this->_operation	 = 'trash';
					else
						$this->_operation	 = 'restore';
				}

				$array[$key] = array( $value, $newParams[$key] );
			}
		}

		if (count($array) > 0)
			$params = CJSON::encode($array);

		return $params;
	}

	/**
	 * Добавление нового поля
	 */
	private function addItem()
	{
		if (!$this->attributeName)
			$this->attributeName = 'id';

		$model				 = new Log;
		$model->module		 = Yii::app()->controller->module->id;
		$model->table		 = $this->owner->tableSchema->name;
		$model->model		 = get_class($this->getOwner());
		$model->user_id		 = Yii::app()->user->id;
		$model->operation	 = $this->_operation;
		$model->attribute	 = $this->attributeName;
		$model->value		 = $this->owner->{$this->attributeName};
		$model->params		 = $this->_params;
		$model->save();
	}

}

