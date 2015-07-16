<?php

/**
 * Платежная система Qiwi
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class QiwiController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'PaymentLecture';

    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Отправка данных
     * @param string $data
     */
    public function actionIndex($data)
    {
        $data  = CJSON::decode($data);
        $model = new $this->defaultModel;

        foreach($data as $key => $value)
            $model->$key = $value;

        if ($model->save())
            $this->redirect('http://1uom.com/page/sellconference/1');
        else
            $this->redirect('http://1uom.com/page/sellconference/0');
    }

}

