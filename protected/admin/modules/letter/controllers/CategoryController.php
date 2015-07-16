<?php

/**
 * Категории шаблонов
 *
 * @category Controller
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CategoryController extends BackendController
{

	/**
	 * @var string модель по умолчанию
	 */
	public $defaultModel = 'LetterCategoryTemplate';

	/**
	 * Правила доступа к экшенам
	 * @return array
	 */
	public function accessRules()
	{
		return array(
			array( 'allow',
				'actions'	 => array( 'index' ),
				'roles'		 => array( 'administrator' ),
			),
			array( 'allow',
				'actions'	 => array( 'create' ),
				'roles'		 => array( 'administrator' ),
			),
			array( 'allow',
				'actions'	 => array( 'toggle', 'update' ),
				'roles'		 => array( 'administrator' ),
			),
			array( 'allow',
				'actions'	 => array( 'delete' ),
				'roles'		 => array( 'administrator' ),
			),
			array( 'deny',
				'users' => array( '*' ),
			),
		);
	}

	/**
	 * Получение списка категорий шаблонов
	 */
	public function actionIndex()
	{
		// название страницы
		$this->pageTitle = 'Категории шаблонов';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Рассылка',
			'Категории шаблонов' => array( 'index' ),
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
	 * Создание категории шаблона
	 */
	public function actionCreate()
	{
		// название страницы
		$this->pageTitle = 'Создание категории';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Рассылка',
			'Категории шаблонов' => array( 'index' ),
			'Создание категории' => array( 'create' ),
		);

		$model = new $this->defaultModel('create');

		// Ajax валидация
		$this->performAjaxValidation($model);

		if (isset($_POST[$this->defaultModel]))
		{
			$model->attributes = $_POST[$this->defaultModel];

			if ($model->save(false))
				Yii::app()->user->setFlash('success', 'Категория успешно создан');
			else
				Yii::app()->user->setFlash('error', 'Ошибка при создании категории');

			if (Yii::app()->request->getPost('button'))
				$this->redirect(array( Yii::app()->request->getPost('button') ));
			else
				$this->redirect(array( 'index' ));
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Переключатель
	 * @param integer $pk
	 * @param string $attribute
	 */
	public function actionToggle($pk, $attribute)
	{
		$model				 = $this->loadModel($pk);
		$model->$attribute	 = $model->$attribute ? 0 : 1;
		$model->save();

		if (!Yii::app()->request->isAjaxRequest)
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'index' ));
	}

	/**
	 * Редактирование категории шаблона
	 * @param integer $id ID категории
	 */
	public function actionUpdate($id)
	{
		// название страницы
		$this->pageTitle = 'Редактирование категории';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Рассылка',
			'Категории шаблонов'		 => array( 'index' ),
			'Редактирование категории'	 => $this->createUrl('update', array( 'id' => $id )),
		);

		$model = $this->loadModel($id);

		// Ajax валидация
		$this->performAjaxValidation($model);

		if (isset($_POST[$this->defaultModel]))
		{
			$model->attributes = $_POST[$this->defaultModel];

			if ($model->save(false))
				Yii::app()->user->setFlash('success', 'Категория успешно отредактирован');
			else
				Yii::app()->user->setFlash('error', 'Ошибка при редактировании категории');

			if (Yii::app()->request->getPost('button'))
				$this->redirect(array( Yii::app()->request->getPost('button') ));
			else
				$this->redirect(array( 'index' ));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Удаление категории шаблонв
	 * @param integer $id ID категори
	 */
	public function actionDelete($id)
	{
		if ($this->loadModel($id)->delete())
			Yii::app()->user->setFlash('success', 'Категория успешно удалена');
		else
			Yii::app()->user->setFlash('error', 'Ошибка при удалении категории');

		$this->redirect(array( 'index' ));
	}

	/**
	 * Получение категории
	 * @param integer $id ID категории
	 * @return object
	 */
	public function loadModel($id)
	{
		$model = CActiveRecord::model($this->defaultModel)->findByPk($id);

		if ($model === null)
		{
			Yii::app()->user->setFlash('error', 'Искомая категория не найдена');
			$this->redirect(array( 'index' ));
		}

		return $model;
	}

	/**
	 * Валидация Ajax
	 * @param object $model
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form')
		{
			echo BsActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}

