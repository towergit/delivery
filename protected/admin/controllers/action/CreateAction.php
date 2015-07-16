<?php
Yii::import('admin.controllers.action.GeneralAction');

/**
 * Создание записи
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CreateAction extends GeneralAction
{

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
     * @var string вид
     */
    public $view = 'create';
    
    /**
     *Дополнительный адрес преадрисации
     * 
     * @var string
     */
    public $aditional_url = false;


    /**
     * Запуск действия
     */
    public function run()
    {
        $model = new $this->modelName;

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
                
                if($this->aditional_url){

                    $this->getController()->redirect($this->aditional_url.$model->id);  
                }
                    
            }
            else
            {
                
                if ($this->error)
                    $this->flashMessage(self::TYPE_ERROR, $this->error);
            }
                
            if ($this->redirectTo)
                $this->getController()->redirect($this->redirectTo);
            else
                $this->redirect();
        }

        $this->controller->render($this->view, CMap::mergeArray(array(
            'model' => $model,
        ), $this->renderData));
    }

}

