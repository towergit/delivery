<?php

/**
 * Оплата лекций
 *
 * @category Controller
 * @package  Module.Payment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LectureController extends BackendController
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
                'actions' => array( 'index' ),
                'roles'   => array( 'showPaymentLecture' ),
            ),
            array( 'allow',
                'actions' => array( 'toggle', 'update' ),
                'roles'   => array( 'updatePaymentLecture' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deletePaymentLecture' ),
            ),
            array( 'allow',
                'actions' => array( 'payment' ),
                'users'   => array( '*' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Получение списка оплат лекций
     */
    public function actionIndex()
    {
        // название страницы
        $this->pageTitle = 'Оплаты лекций';

        // хлебные крошки
        $this->breadcrumbs = array(
            'Платежи',
            'Оплаты лекций' => array( 'index' ),
        );

        $model  = new $this->defaultModel('search');
        $system = new PaymentSystem;
        $model->unsetAttributes();

        if (isset($_GET[$this->defaultModel]))
            $model->attributes = $_GET[$this->defaultModel];

        $this->render('index', array(
            'model'  => $model,
            'system' => $system,
        ));
    }

    /**
     * Переключатель
     * @param integer $pk
     * @param string $attribute
     */
    public function actionToggle($pk, $attribute)
    {
        $model             = $this->loadModel($pk);
        $model->$attribute = $model->$attribute ? 0 : 1;
        $model->save();

        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'index' ));
    }

    /**
     * Редактирование оплаты лекции
     * @param integer $id ID оплаты лекции
     */
    public function actionUpdate($id)
    {
        // название страницы
        $this->pageTitle = 'Редактирование оплаты лекции';

        // хлебные крошки
        $this->breadcrumbs = array(
            'Платежи',
            'Оплаты лекций'         => array( 'index' ),
            'Редактирование оплаты' => $this->createUrl('update', array( 'id' => $id )),
        );

        $model  = $this->loadModel($id);
        $system = new PaymentSystem;

        // Ajax валидация
        $this->performAjaxValidation($model);

        if (isset($_POST[$this->defaultModel]))
        {
            $model->attributes = $_POST[$this->defaultModel];

            if ($model->save())
            {
                if ($model->confirmed == 1 && $model->status == 'success')
                {
                    $template = LetterTemplate::model()->findByCode('lecture');

                    if ($template !== null)
                    {
                        switch($model->lecture)
                        {
                            case 'special_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=qQ0J3RXmUjU&list=PLolz27Cd89ZthhRvQZJBz1Y1coL54T6qW';
                                break;
                            case 'special_s1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=qQ0J3RXmUjU&list=PLolz27Cd89ZthhRvQZJBz1Y1coL54T6qW';
                                break;
                            case 'special_2': 
                                $params['link'] = 'https://www.youtube.com/watch?v=qQ0J3RXmUjU&list=PLolz27Cd89ZuZzyxGZXWKNza7Tyv-lJ-a';
                                break;
                            case 'special_s2': 
                                $params['link'] = 'https://www.youtube.com/watch?v=qQ0J3RXmUjU&list=PLolz27Cd89ZuZzyxGZXWKNza7Tyv-lJ-a';
                                break;
                            case 'special_3': 
                                $params['link'] = 'https://www.youtube.com/watch?v=RmiotrQ9HgY&list=PLolz27Cd89ZvbG8egg6AduL0H_njQAOq-';
                                break;
                            case 'special_s3': 
                                $params['link'] = 'https://www.youtube.com/watch?v=RmiotrQ9HgY&list=PLolz27Cd89ZvbG8egg6AduL0H_njQAOq-';
                                break;
                            case 'anna_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=VujtOP0DW_U&list=PLolz27Cd89Zu8MvjmGIsfL3B5tw-dq5hs';
                                break;
                            case 'igor_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=TMTnfi5KDzE&list=PLolz27Cd89Zs0eSHDZ_a4dNuBM2AqdBPa';
                                break;
                            case 'roma_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=1mO_jCUHu9w&list=PLolz27Cd89ZtQgGQG_jQ7VQnq_buTr8x1';
                                break;
                            case 'roma_2': 
                                $params['link'] = 'https://www.youtube.com/watch?v=F_AT543cujc&list=PLolz27Cd89Zv_-51CViH4cV1IHG2PLjhS';
                                break;
                            case 'ivan_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=68UQzITVnkg&list=PLolz27Cd89Zs4UXhpuNsc_MtWs9PcTrZc';
                                break;
                            case 'ivan_2': 
                                $params['link'] = 'https://www.youtube.com/watch?v=ZiilR4elV7E&list=PLolz27Cd89ZtPfhamQxHYuGmAwDskEXDh';
                                break;
                            case 'muhtar_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=4-0HdmQRGBU&list=PLolz27Cd89ZvG9yIpjtxwXbl08wD8Z1nl';
                                break;
                            case 'alex_1': 
                                $params['link'] = 'https://www.youtube.com/watch?v=RmiotrQ9HgY&list=PLolz27Cd89Zuw1ToMnoYIXyBeI6bU2MHm';
                                break;
                            case 'igor_2': 
                                $params['link'] = 'https://www.youtube.com/watch?v=hGsZ2R-d64E&list=PLolz27Cd89Zu4hQDjNBTTnMSU36sUVmWY';
                                break;
                        }
                        
                        if (isset($params['link']))
                        {
                            $mailer = new Mailer;
                            $mailer->to($model->email);
                            $mailer->from('1uom.com');
                            $mailer->subject($template->title);
                            $mailer->templateMessage($template->text, $params);
                            $mailer->send();
                        }
                    }
                }

                Yii::app()->user->setFlash('success', 'Оплата лекции успешно отредактирована');
            }
            else
                Yii::app()->user->setFlash('error', 'Ошибка при редактировании оплаты лекции');

            $this->redirect(array( 'index' ));
        }

        $this->render('update', array(
            'model'  => $model,
            'system' => $system,
        ));
    }

    /**
     * Удаление оплаты лекции
     * @param integer $id ID оплаты лекции
     */
    public function actionDelete($id)
    {
        if ($this->loadModel($id)->delete())
            Yii::app()->user->setFlash('success', 'Оплата лекции успешно удалена');
        else
            Yii::app()->user->setFlash('error', 'Ошибка при удалении оплаты лекции');

        $this->redirect(array( 'index' ));
    }

    /**
     * Оплата лекции
     */
    public function actionPayment()
    {
        $system   = Yii::app()->getRequest()->getPost('paymentSystem');
        $sum      = Yii::app()->getRequest()->getPost('sumPayment');
        $currency = Yii::app()->getRequest()->getPost('valuta');
        $lecture  = Yii::app()->getRequest()->getPost('lecture_name');
        $email    = Yii::app()->getRequest()->getPost('email');

        if (isset($system, $sum, $currency, $lecture, $email))
        {
            $system = PaymentSystem::model()->findByCode($system);

            if ($system === null)
                $this->redirect(Yii::app()->request->urlReferrer);

            $array = array();

            if (!empty($_POST['userName']))
                $array['firstname'] = $_POST['userName'];

            if (!empty($_POST['userSurname']))
                $array['lastname'] = $_POST['userSurname'];

            if (!empty($_POST['userPatronymic']))
                $array['patronymic'] = $_POST['userPatronymic'];

            if (!empty($_POST['phoneNumber']))
                $array['phone'] = $_POST['phoneNumber'];

            if (!empty($_POST['discountCode']))
                $array['discount'] = $_POST['discountCode'];

            if (!empty($_POST['pursePayment']))
                $array['purse'] = $_POST['pursePayment'];

            if (!empty($_POST['note']))
                $array['note'] = $_POST['note'];

            if (count($array) > 0)
                $data = CJSON::encode($array);
            else
                $data = null;

            $dataJson = CJSON::encode(array(
                    'system_id' => $system->id,
                    'sum'       => intval($sum),
                    'currency'  => $currency,
                    'lecture'   => $lecture,
                    'email'     => $email,
                    'data'      => $data
            ));

            $contoller = preg_replace('#-?#', '', $system->code);
            $url       = Yii::app()->createUrl('/payment/' . $contoller . '/index', array( 'data' => $dataJson ));

            $this->redirect($url);
        }
        else
        {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * Получение оплаты лекции
     * @param string $id ID оплаты лекции
     * @return object
     */
    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->defaultModel)->findByPk($id);

        if ($model === null)
        {
            Yii::app()->user->setFlash('error', 'Искомая оплата лекции не найдена');
            $this->redirect(array( 'index' ));
        }

        return $model;
    }

    /**
     * Валидация Ajax
     * @param object $model
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-lecture-form')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

