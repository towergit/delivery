<?php

/**
 * Контроллер по умолчанию
 *
 * @category Controller
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class DefaultController extends FrontendController {

    public $showHeadering = false;

    /**
     * Загрузка стилей и скриптов
     */
    public function registerCommonScripts() {
        parent::registerCommonScripts();

        $cs = Yii::app()->getClientScript();

        // Custom
        $cs->registerScriptFile($this->getAssetsBase() . '/js/scripts.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->getAssetsBase() .  '/js/jquery.maskedinput.min.js', CClientScript::POS_END);     
        $cs->registerCssFile($this->getAssetsBase() . '/css/style.css');
    }

    /**
     * Главная страница
     */
    public function actionIndex() {
        
        $cs = Yii::app()->getClientScript();

        // Owl-carousel
        $cs->registerScriptFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.carousel.js' : 'owl.carousel.min.js'), CClientScript::POS_END);
        $cs->registerCssFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.carousel.css' : 'owl.carousel.min.css'));
        $cs->registerCssFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.theme.css' : 'owl.theme.min.css'));

        $this->layout = '//layouts/home';

        $ip = Yii::app()->request->userHostAddress;

        #if (!in_array($ip, $this->availableIp))
        #    $this->redirect('/comingsoon');

        $this->render('index');
    }

    /**
     * О фонде
     */
    public function actionAbout_fund() {
        $model = Material::model()->findByAttributes(array('alias' => 'o-fonde'));

        $this->render('about_fund', array(
            'model' => $model,
        ));
    }

    /**
     * Блог
     */
    public function actionBlog() {
        $category = MaterialCategory::model()->findByAttributes(array('alias' => 'blog'));

        $criteria = new CDbCriteria;
        $criteria->condition = 'parent_id = :parent_id OR id = :id';
        $criteria->params = array(':parent_id' => (int) $category->id, ':id' => (int) $category->id);
        $criteria->order = 'sort';

        $categories = MaterialCategory::model()->findAll($criteria);
        $categories = CHtml::listData($categories, 'id', 'id');

        $criteria2 = new CDbCriteria;
        $criteria2->compare('status', Material::STATUS_ACTIVE);
        $criteria2->addInCondition('category_id', $categories);
        $criteria2->order = 'publish_date DESC';

        $dataProvider = new CActiveDataProvider('Material', array(
            'criteria' => $criteria2,
            'pagination' => array(
                'pageSize' => 3,
            )
        ));

        $this->render('blog', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Просмотр статьи блога
     * @param string $alias алиас
     */
    public function actionItem_blog($alias) {
        $model = Material::model()->active()->findByAttributes(array('alias' => $alias));

        if ($model === null)
            return false;

        $this->render('item_blog', array(
            'model' => $model,
        ));
    }

    /**
     * Категория блога
     * @param string $alias алиас
     */
    public function actionBlog_category($alias) {
        $category = MaterialCategory::model()->findByAttributes(array('alias' => $alias));

        $criteria = new CDbCriteria;
        $criteria->compare('status', Material::STATUS_ACTIVE);
        $criteria->compare('category_id', $category->id);
        $criteria->order = 'publish_date DESC';

        $dataProvider = new CActiveDataProvider('Material', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 3,
            )
        ));

        $this->render('blog_category', array(
            'category' => $category,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Архив блога
     * @param integer $year год
     */
    public function actionBlog_archive($year) {
        $this->actionMaintenance();
        exit();
    }

    /**
     * Проекты
     */
    public function actionProjects($params = null) {
        $cs = Yii::app()->getClientScript();

        // Owl-carousel
        $cs->registerScriptFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.carousel.js' : 'owl.carousel.min.js'), CClientScript::POS_END);
        $cs->registerCssFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.carousel.css' : 'owl.carousel.min.css'));
        $cs->registerCssFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.theme.css' : 'owl.theme.min.css'));


        $alias = Yii::app()->request->getQuery('alias');

        $criteria = new CDbCriteria;
        $criteria->compare('status', ObjectHelp::STATUS_ACTIVE);
        $criteria->order = 't.sort';

        if ($params && is_array($params))
            $criteria->compare($params['item'], $params['value']);

        $dataProvider = new CActiveDataProvider('ObjectHelp', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 9,
            )
        ));

        $this->render('projects', array(
            'dataProvider' => $dataProvider,
            'alias' => $alias,
        ));
    }

    public function actionSelect_objects() {

        if ($_POST) {
            var_dump($_POST);
            exit();
        }

        $criteria = new CDbCriteria;
        $criteria->compare('status', ObjectHelp::STATUS_ACTIVE);
        $criteria->order = 't.sort';

        $models = ObjectHelp::model()->findAll($criteria);

        $this->render('select_objects', array(
            'objects' => $models,
        ));
    }

    /**
     * Категория проектов
     * @param string $alias
     */
    public function actionProjects_category($alias) {
        $model = ObjectCategory::model()->findByAttributes(array('alias' => $alias));

        if ($model)
            $this->actionProjects(array('item' => 'category_id', 'value' => $model->id));
        else {
            if ($alias == 'all')
                $this->actionProjects();
            else
                $this->actionProjects(array('item' => 'status', 'value' => ObjectHelp::STATUS_EXECUTED));
        }
    }

    /**
     * Просмотр проекта
     * @param string $alias алиас
     */
    public function actionItem_project($alias) {

        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.carousel.js' : 'owl.carousel.min.js'), CClientScript::POS_END);
        $cs->registerCssFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.carousel.css' : 'owl.carousel.min.css'));
        $cs->registerCssFile($this->getAssetsBase() . '/js/owl-carousel/' . (YII_DEBUG ? 'owl.theme.css' : 'owl.theme.min.css'));


        $model = ObjectHelp::model()->active()->findByAttributes(array('alias' => $alias));

        $this->render('item_project', array(
            'model' => $model,
        ));
    }

    /**
     * Команда
     */
    public function actionTeam() {
        /*
         * work:
         * 1)Управляющий фондом
         * 2)Попечительский совет
         * 3)Координаторы
         */
        $work = array(1 => 'Управляющий фондом', 2 => 'Попечительский совет', 3 => 'Координаторы');
        $team = array(
            array(
                'name' => 'Григорий Павлиоти',
                'img' => '/images/manager/1.png',
                'work' => '1',
                'soc' => array(
                    'fb' => '',
                    'tw' => '',
                    'gp' => '',
                ),
            ),
            array(
                'name' => 'Андрей Агафонов',
                'img' => '/images/manager/2.jpg',
                'work' => '2',
                'soc' => array(
                    'fb' => '#1',
                    'gp' => '#3',
                ),
            ),
            array(
                'name' => 'Марина Фрейман',
                'img' => '/images/manager/3.jpg',
                'work' => '2',
                'soc' => array(
                    'fb' => '#1',
                    'tw' => '#2',
                ),
            ),
            array(
                'name' => 'Антон Путилин',
                'img' => '/images/manager/4.jpg',
                'work' => '2',
                'soc' => array(
                    'fb' => '#1',
                    'tw' => '#2',
                ),
            ),
            array(
                'name' => 'Ольга Косинова',
                'img' => '/images/manager/5.jpg',
                'work' => '3',
                'soc' => array(
                    'fb' => '#1',
                    'tw' => '#2',
                ),
            ),
        );
        $this->render('team', array('team' => $team, 'work' => $work));
    }

    public function actionSwift() {

        $this->render('swift');
    }

    /**
     * Партнеры
     */
    public function actionPartners() {
        $partners = array(
            array(
                'name' => 'University of Millionaires',
                'img' => '/images/patron/uom.jpg',
                'url' => 'https://1uom.com',
                'text' => '',
            ),
            array(
                'name' => 'Global Education Platform',
                'img' => '/images/patron/global_education_platform.jpg',
                'url' => 'https://global-ep.com/',
                'text' => '',
            ),
            array(
                'name' => 'Tower Investment Fund',
                'img' => '/images/patron/tower_investment_fund.jpg',
                'url' => 'https://tower-invest.net',
                'text' => '',
            ),
            array(
                'name' => 'Royal Investment club',
                'img' => '/images/patron/royal_investment_club.jpg',
                'url' => 'https://royalinvestmentclub.com',
                'text' => '',
            ),
            array(
                'name' => 'Crystal-IT simple solutions',
                'img' => '/images/patron/crystal-it.jpg',
                'url' => 'http://crystal-it.biz',
                'text' => '',
            ),
            array(
                'name' => 'Luxe-Сhange',
                'img' => '/images/patron/luxe.jpg',
                'url' => 'https://luxe-change.ru',
                'text' => '',
            ),
            array(
                'name' => 'Инвестиционная игра',
                'img' => '/images/patron/investgame.jpg',
                'url' => 'https://ingogame.com',
                'text' => '',
            ),
        );

        $partners2 = array(
            array(
                'name' => 'GENETIC-TEST',
                'img' => '/images/patron/genetic.jpg',
                'url' => 'http://otvetvgenah.ru',
                'text' => '',
            )
        );
        $this->render('partners', array('partners' => $partners, 'partners2' => $partners2));
    }

    /**
     * FAQ
     */
    public function actionFaq() {
        $models = FaqCategory::model()->with('faqs')->active()->findAll();

        $this->render('faq', array(
            'models' => $models,
        ));
    }

    /**
     * Отчеты
     */
    public function actionReports() {

        $this->render('reports');
    }

    /**
     * Контакты
     */
    public function actionContacts() {
        $model = new ContactForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contact') {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['ContactForm'])) {

            //е-мейлы для отправления и дублирования
            $servicesEmails = array('info@blago-vest.org', '24priest@gmail.com');
            $success = true;

            $model->attributes = $_POST['ContactForm'];
            $body = 'Имя: ' . $model->name . '\n';
            $body .= 'Email: ' . $model->email . '\n';
            $body .= 'Сообщение: ' . $model->body;

            $mail_list = new AdditionEmailList;

            $mail_list->name = $model->name;
            $mail_list->email = $model->email;
            $mail_list->save();

            $mail = new Mailer;
            $mail->from('info@blago-vest.org');

            foreach ($servicesEmails as $email) {

                $mail->to($email);
                $mail->subject($model->subject);
                $mail->message($body);

                if (!$mail->send())
                    $success = false;
            }

            if ($success)
                Yii::app()->user->setFlash('notify', Yii::t('main', 'Ваш запрос отправлен, он будет рассмотрен администратором фонда, при необходимости с Вами свяжутся'));
            else
                Yii::app()->user->setFlash('error', Yii::t('main', 'Ваш запрос не отправлен, повторите попытку'));

            $this->refresh();
        }

        $this->render('contacts', array(
            'model' => $model,
        ));
    }

    /**
     * Авторизация
     */
    public function actionAuthorization() {
        $this->login();
        $this->render('authorization');
    }

    /**
     * Вход
     */
    protected function login() {
        $model = new LoginForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'signin') {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate())
                $this->redirect(array('/default/index'));
        }
    }

    /**
     * Оставить комментарий
     * @param string $redirectTo адрес переадресации
     */
    public function actionComment($redirectTo) {
        $model = new Comment;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment') {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];

            if ($model->save(false))
                Yii::app()->user->setFlash('success', Yii::t('main', 'Ваш комментарий отправлен на модерацию'));
            else
                Yii::app()->user->setFlash('error', Yii::t('main', 'Ваш комментарий не отправлен, повторите попытку'));

            $this->redirect($redirectTo);
        }
    }

    /**
     * Подписка
     */
    public function actionSubscribe() {
        $model = new Subscribe;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subscribe') {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Subscribe'])) {
            $model->attributes = $_POST['Subscribe'];

            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('main', 'Вы успешно подписались на новости и события портала Blago-Vest'));
            else
                Yii::app()->user->setFlash('error', Yii::t('main', 'Подписка не произошла, проверьте пожалуйста правильность ввода e-mail адреса'));

            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * Оплата
     */
    public function actionPayment() {
        // Если в корзине нету объектов помощи - переадресация назад на объекты
        $basket = Basket::model()->findByPk(Yii::app()->session->itemAt('basket_id'));

        if (!$basket && Yii::app()->request->getQuery('step') == 2) {

            Yii::app()->user->setFlash('error', Yii::t('main', 'Вы не выбрали ни одного объекта помощи!'));
            $this->redirect(array('projects'));
        }

        if (Yii::app()->request->getQuery('step')) {

            $step = Yii::app()->request->getQuery('step');

            // Если это гость то переходим на первый шаг, если это авторизованный пользователь переходим на второй шаг
            if (Yii::app()->user->isGuest && Yii::app()->request->getQuery('auth') != 'anonim' && ($step == 1 || $step == 2))
                $step = 2;
            elseif (!Yii::app()->user->isGuest && $step == 1)
                $step = 2;

            if ($step == 3 && Yii::app()->request->getQuery('status'))
                $step = 3;
        }else {
            $step = 2;
        }

        if (Yii::app()->request->getQuery('step') == 3)
            $step = 3;

        // Отпарвка формы оплаты
        $model = new Payment;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment') {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Payment'])) {

            $model->basket = $basket;
            $model->attributes = $_POST['Payment'];
            $model->basket_id = $model->basket->id;
            $model->additionalParams = $_POST['Payment'];

            if ($model->save()) {
                
                Yii::app()->session->remove('basket_id');
                $this->redirect($this->createUrl("/payment/{$model->system}/index", array('code' => $model->code, 'user' => $_POST['Payment'])));
                //return true;
            }
        }

        $this->render('payment', array(
            'step' => $step,
        ));
    }

    /**
     * Корзина
     * @param mixed $id
     */
    public function actionBasket($id) {
        $model = new Basket();
        $model->item = $id;

        //временно анонимная оплата
        $this->redirect(array('/payment/step/2?auth=anonim'));

        //if (Yii::app()->request->getQuery('auth') == 'anonim')
        //    $this->redirect(array('/payment/step/2?auth=anonim'));
        //else
        //    $this->redirect(array('/default/payment'));
    }

    public function actionHelp() {
        $this->render('help');
    }

    public function actionVolonter() {
        $this->render('volonter');
    }

    public function actionQiwi() {
        $this->render('qiwi');
    }

    public function actionWebmoney() {
        $this->render('webmoney');
    }

    /**
     * Контент в разработке
     */
    public function actionMaintenance() {
        $this->render('maintenance');
    }

    public function actionMail() {
        Yii::import('application.modules.letter.models.EmailTemplate');

        $temp = EmailTemplate::getTemplate('first');
//dudina.olesya.nikol@gmail.com

//lotysh.vm@gmail.com

        if ($temp !== null) {
            $mail = new Mailer;
            $mail->to('dudina.olesya.nikol@gmail.com');
            $mail->from('info@blago-vest.org','BLAGOVEST');
            $mail->subject('test');
            $mail->templateMessage($temp->text, array());
echo "lotysh.vm@gmail.com";
            var_dump($mail->send());
            exit();
        }
    }

    /**
     * Получение доступных IP
     * @return array
     */
    protected function getAvailableIP() {
        return array(
            '127.0.0.1',
            '77.47.225.88',
            '46.219.23.82',
            '46.219.23.77',
            '91.214.84.194',
            '178.140.85.203',
            '85.10.200.59',
            '162.168.1.66',
            '188.32.22.58',
            '77.47.232.147',
        );
    }

}
