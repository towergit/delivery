<?php
Yii::import('admin.controllers.action.GeneralAction');

/**
 * Обновление записи
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class UpdateAction extends GeneralAction
{

    /**
     * @var string вид
     */
    public $view = 'update';

    /**
     * @var string сценарий 
     */
    public $scenario;

    /**
     * @var string уведомление об успехе
     */
    public $success;

    /**
     * @var string уведомление об ошибке
     */
    public $error;

    /**
     * @var array перенаправление
     */
    public $redirectTo;

    /**
     * @var string название аттрибута 
     */
    public $attributeName = 'id';

    /**
     * @var string текст исключения 
     */
    public $exception;

    /**
     * Запуск действия
     * @param mixed $id
     */
    public function run($id)
    {
        if (empty($this->exception))
            $this->exception = Yii::t('general', 'Не найдено');
        
        if (gettype($id) == 'integer')
            $model = CActiveRecord::model($this->modelName)->findByPk($id);
        else
            $model = CActiveRecord::model($this->modelName)->findByAttributes(array( $this->attributeName => $id ));

        if ($model === null)
            $this->flashMessage(self::TYPE_ERROR, $this->exception);
        
        if ($this->scenario)
            $model->setScenario($this->scenario);

        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->modelName) . '-form')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST[$this->modelName]))
        {
            $model->attributes = $_POST[$this->modelName];

            if ($model->save())
            {
                if ($this->success)
                    $this->flashMessage(self::TYPE_SUCCESS, $this->success);
            }
            else
            {
                if ($this->error)
                    $this->flashMessage(self::TYPE_ERROR, $this->error);
            }
            
            if ($this->redirectTo)
                $this->getController()->redirect($this->redirectTo);
            else
                $this->getController()->refresh();
        }

        $this->controller->render($this->view, CMap::mergeArray(array(
            'model' => $model,
        ), $this->renderData));
    }

}

