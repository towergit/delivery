<?php

/**
 * Журнал событий
 *
 * @category Controller
 * @package  Module.Cron
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LogController extends BackendController
{

	/**
	 * @var string модель по умолчанию
	 */
	public $defaultModel = 'Log';

	/**
	 * Правила доступа к экшенам
	 * @return array
	 */
	public function accessRules()
	{
		return array(
			array( 'allow',
				'actions'	 => array( 'index' ),
				'roles'		 => array( 'showLog', ),
			),
			array( 'allow',
				'actions'	 => array( 'view' ),
				'roles'		 => array( 'viewLog' ),
			),
			array( 'allow',
				'actions'	 => array( 'delete' ),
				'roles'		 => array( 'deleteLog' ),
			),
			array( 'allow',
				'actions'	 => array( 'clean' ),
				'roles'		 => array( 'cleanLog' ),
			),
			array( 'deny',
				'users' => array( '*' ),
			),
		);
	}

	/**
	 * Список событий
	 */
	public function actionIndex()
	{
		// название страницы
		$this->pageTitle = 'Журнал событий';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Журнал событий' => array( 'index' ),
		);

		$model = new $this->defaultModel('search');
		$model->unsetAttributes();

		if (isset($_GET[$this->defaultModel]))
			$model->attributes = $_GET[$this->defaultModel];

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Детальный простмотр события
	 * @param integer $id ID события
	 */
	public function actionView($id)
	{
		// название страницы
		$this->pageTitle = 'Просмотр события';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Журнал событий' => array( 'index' ),
			'Просмотр события' => $this->createUrl('view', array( 'id' => $id )),
		);
		
		$model = $this->loadModel($id);
		
		$this->render('view', array(
			'model' => $model,
		));
	}
	
	/**
	 * Удаление события
	 * @param integer $id ID события
	 */
	public function actionDelete($id)
	{
		if (!$this->loadModel($id)->delete())
			Yii::app()->user->setFlash('error', 'Ошибка при удалении события');
		else
			Yii::app()->user->setFlash('success', 'Удаление события успешно выполнено');
		
		$this->redirect(array( 'index' ));
	}
	
	/**
	 * Очистка событий
	 */
	public function actionClean()
	{
		$table = CActiveRecord::model($this->defaultModel)->tableName();
		Yii::app()->db->createCommand()->truncateTable($table);
		
		Yii::app()->user->setFlash('success', 'События успешно очищены');
		
		$this->redirect(array( 'index' ));
	}
	
	/**
	 * Получение события
	 * @param string $id ID события
	 * @return object
	 */
	public function loadModel($id)
	{
		$model = CActiveRecord::model($this->defaultModel)->findByPk($id);

		if ($model === null)
		{
			Yii::app()->user->setFlash('error', 'Искомое событие не найдено');
			$this->redirect(array( 'index' ));
		}

		return $model;
	}

}

