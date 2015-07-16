<?php

/**
 * Контроллер по умолчанию
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class DefaultController extends BackendController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}

