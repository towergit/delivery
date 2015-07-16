<?php

/**
 * Поиск
 *
 * @category Controller
 * @package  Module.Search
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class SearchController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'SearchForm';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'users'   => array( '@' ),
            ),
        );
    }

    /**
     * Поиск
     */
    public function actionIndex()
    {
        $result = '';
        $string = Yii::app()->getRequest()->getPost('string');

        if (isset($string))
        {
            
        }

        $this->renderPartial('index', array(
            'result' => $result,
        ));
    }

}

