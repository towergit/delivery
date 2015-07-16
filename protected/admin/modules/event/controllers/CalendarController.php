<?php

/**
 * Календарь событий
 *
 * @category Controller
 * @package  Module.Event
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CalendarController extends BackendController
{
    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index', 'demo' ),
                'roles'   => array( 'showEvent' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    public function actionIndex()
    {
        $models = EventCategory::model()->active()->findAll();
        
        $this->render('index', array(
            'models' => $models,
        ));
    }

    public function actionDemo()
    {
        $models = Event::model()->findAll();
        
        if ($models === null)
            return false;
        
        $item = array();
        
        foreach ($models as $key => $model)
        {
            $item[$key] = array(
                'title' => $model->title,
                'start' => $model->start_date,
                'color' => $model->category->color
            );
            
            if ($model->end_date)
                $item[$key] = array_merge($item[$key], array( 'end' => $model->end_date ));
        }
        
        echo CJSON::encode($item);
        Yii::app()->end();
    }

}

