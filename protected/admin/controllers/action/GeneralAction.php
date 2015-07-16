<?php

/**
 * Общие методы экшенов
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class GeneralAction extends CAction
{

    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR   = 'error';
    const TYPE_INFO    = 'info';
    const TYPE_NOTICE  = 'notice';
    
    const SUBMIT_NAME  = 'submit-type';

    /**
     * @var string название модели 
     */
    public $modelName;
    
    /**
     * @var array данные
     */
    public $renderData = array();

    /**
     * Всплывающие сообщения
     * @param string $type тип
     * @param string $message сообщение
     */
    protected function flashMessage($type, $message)
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->user->setFlash($type, $message);
    }
    
    /**
     * Редирект при отправке формы
     */
    protected function redirect()
    {
        $submit = Yii::app()->request->getPost(self::SUBMIT_NAME);

        if (isset($submit))
            if ($submit !== 'refresh')
                $this->getController()->redirect(array( $submit ));
            else
                $this->getController()->refresh();
        else
            $this->getController()->redirect(array( 'index' ));
    }

}

