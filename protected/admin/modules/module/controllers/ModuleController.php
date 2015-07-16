<?php

/**
 * Модули
 *
 * @category Controller
 * @package  Module.Module
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ModuleController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Module';

    /**
     * Правила доступа к экшенам
     * @return array
     
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showModule' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }*/

    /**
     * Вывод всех модулей
     */
    public function actionIndex()
    {
//        $i       = 0;
//        $array   = array();
//        $modules = Yii::app()->getModules();
//
//        foreach($modules as $key => $value)
//        {
//            if ($key != 'module')
//            {
//                $module = Yii::app()->getModule($key);
//
//                $class = '';
//
//                if (preg_match('/^Beta/', $module->version))
//                    $class = 'label-info';
//                elseif (preg_match('/^Alpha/', $module->version))
//                    $class = 'label-warning';
//                else
//                    $class = 'label-success';
//
//                $array[] = array(
//                    'id'          => ++$i,
//                    'name'        => $module->name,
//                    'description' => $module->description,
//                    'version'     => '<span class="label ' . $class . '">' . $module->version . '</span>',
//                    'author'      => $module->author,
//                    'url'         => $module->url,
//                );
//            }
//        }
//
//        $sort               = new CSort;
//        $sort->defaultOrder = 'id DESC';
//
//        $dataProvider = new CArrayDataProvider($array, array(
//            'sort' => $sort,
//        ));
        
        $model = new $this->defaultModel;
        $model->unsetAttributes();

        if (isset($_GET[$this->defaultModel]))
            $model->attributes = $_GET[$this->defaultModel];
        
        $this->render('index', array(
            'model' => $model,
        ));
    }

}

