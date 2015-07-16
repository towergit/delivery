<?php

/**
 * Рабочий стол
 *
 * @category Controller
 * @package  Module.Dashboard
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class DashboardController extends BackendController
{
    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showDashboard' ),
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

