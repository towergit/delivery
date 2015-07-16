<?php

/**
 * Почта
 *
 * @category Controller
 * @package  Module.Email
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class EmailController extends BackendController
{
    
    /**
     * @var string шаблон
     */
    public $layout = '//layouts/column-3';
    
    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showEmail', 'superadministrator' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

}

