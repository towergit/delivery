<?php

/**
 * Вывод уведомлений
 *
 * @category Widget
 * @package  Component
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class FlashMessagesWidget extends CWidget
{

    const INFO_MESSAGE    = 'info';
    const NOTICE_MESSAGE  = 'notice';
    const SUCCESS_MESSAGE = 'success';
    const ERROR_MESSAGE   = 'error';

    /**
     * @var string название класс
     */
    public $className = 'alert';

    /**
     * @var boolean автоматическое скрытие
     */
    public $autoHide = true;

    /**
     * @var integer время исчезновения
     */
    public $autoHideSeconds = 3600;

    /**
     * Запуск виджета
     */
    public function run()
    {
        if (count(Yii::app()->user->getFlashes(false)))
        {
            if ($this->autoHide)
            {
                $this->autoHideSeconds = (int) $this->autoHideSeconds;

                Yii::app()->getClientScript()->registerCoreScript('jquery');
                Yii::app()->getClientScript()->registerScript(md5($this->id),
                    "
                    setTimeout(function() {
                            $('.{$this->className}').addClass('zoomOutRight');
                    }, {$this->autoHideSeconds});
                    ", CClientScript::POS_END);
            }
        }

        $this->render('flashmessages');
    }

}

