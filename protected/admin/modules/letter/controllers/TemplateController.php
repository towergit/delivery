<?php

/**
 * Шаблоны
 *
 * @category Controller
 * @package  Module.Letter
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TemplateController extends BackendController
{

	/**
	 * @var string модель по умолчанию
	 */
	public $defaultModel = 'LetterTemplate';

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
	 * Получение списка шаблонов
	 */
	public function actionIndex()
	{
		// название страницы
		$this->pageTitle = 'Шаблоны';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Рассылка',
			'Шаблоны' => array( 'index' ),
		);

		$model		 = new $this->defaultModel('search');
		$category	 = new LetterCategoryTemplate;
		$model->unsetAttributes();

		if (isset($_GET[$this->defaultModel]))
			$model->attributes = $_GET[$this->defaultModel];

		$this->render('index', array(
			'model'		 => $model,
			'category'	 => $category,
		));
	}

	/**
	 * Создание шаблона
	 */
	public function actionCreate()
	{
		// название страницы
		$this->pageTitle = 'Создание шаблона';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Рассылка',
			'Шаблоны'			 => array( 'index' ),
			'Создание шаблона'	 => array( 'create' ),
		);

		$model		 = new $this->defaultModel('create');
		$category	 = new LetterCategoryTemplate;

		// Ajax валидация
		$this->performAjaxValidation($model);

		if (isset($_POST[$this->defaultModel]))
		{
			$model->attributes = $_POST[$this->defaultModel];

			if ($model->save(false))
				Yii::app()->user->setFlash('success', 'Шаблон успешно создан');
			else
				Yii::app()->user->setFlash('error', 'Ошибка при создании шаблона');

			if (Yii::app()->request->getPost('button'))
				$this->redirect(array( Yii::app()->request->getPost('button') ));
			else
				$this->redirect(array( 'index' ));
		}

		$this->render('create', array(
			'model'		 => $model,
			'category'	 => $category,
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
	 * Редактирование шаблона
	 * @param integer $id ID шаблона
	 */
	public function actionUpdate($id)
	{
		// название страницы
		$this->pageTitle = 'Редактирование шаблона';

		// хлебные крошки
		$this->breadcrumbs = array(
			'Рассылка',
			'Шаблоны'				 => array( 'index' ),
			'Редактирование шаблона' => $this->createUrl('update', array( 'id' => $id )),
		);

		$model		 = $this->loadModel($id);
		$category	 = new LetterCategoryTemplate;

		// Ajax валидация
		$this->performAjaxValidation($model);

		if (isset($_POST[$this->defaultModel]))
		{
			$model->attributes = $_POST[$this->defaultModel];

			if ($model->save(false))
				Yii::app()->user->setFlash('success', 'Шаблон успешно отредактирован');
			else
				Yii::app()->user->setFlash('error', 'Ошибка при редактировании шаблона');

			if (Yii::app()->request->getPost('button'))
				$this->redirect(array( Yii::app()->request->getPost('button') ));
			else
				$this->redirect(array( 'index' ));
		}

		$this->render('update', array(
			'model'		 => $model,
			'category'	 => $category,
		));
	}

	/**
	 * Удаление шаблона
	 * @param integer $id ID шаблона
	 */
	public function actionDelete($id)
	{
		if ($this->loadModel($id)->delete())
			Yii::app()->user->setFlash('success', 'Шаблон успешно удалена');
		else
			Yii::app()->user->setFlash('error', 'Ошибка при удалении шаблона');

		$this->redirect(array( 'index' ));
	}

	/**
	 * Получение шаблона
	 * @param integer $id ID шаблона
	 * @return object
	 */
	public function loadModel($id)
	{
		$model = CActiveRecord::model($this->defaultModel)->findByPk($id);

		if ($model === null)
		{
			Yii::app()->user->setFlash('error', 'Искомый шаблон не найден');
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
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'template-form')
		{
			echo BsActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}

