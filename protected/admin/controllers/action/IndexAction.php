<?php
Yii::import('admin.controllers.action.GeneralAction');

/**
 * Просмотр записи
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class IndexAction extends GeneralAction
{

    /**
     * @var string сценарий 
     */
    public $scenario;

    /**
     * @var string вид
     */
    public $view = 'index';
    
    /**
     * Запуск действия
     */
    public function run()
    {
        if (isset($_GET['pageCount']))
            Yii::app()->session['pageCount'] = $_GET['pageCount'];
        
        $model = new $this->modelName;

        if ($this->scenario)
            $model->scenario = $this->scenario;

        $model->unsetAttributes();

        if (isset($_GET[$this->modelName]))
            $model->attributes = $_GET[$this->modelName];

        $this->controller->render($this->view, CMap::mergeArray(array(
            'model' => $model,
        ), $this->renderData));
    }

}

