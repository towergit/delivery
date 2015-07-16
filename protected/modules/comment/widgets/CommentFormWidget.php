<?php

/**
 * Оставить комментарий
 *
 * @category Widget
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CommentFormWidget extends CWidget
{

    /**
     * @var string модель     
     */
    public $ownerName;

    /**
     * @var integer ID контента 
     */
    public $ownerId;

    /**
     * @var string переадресация на 
     */
    public $redirectTo;

    /**
     * Инициализация виджета
     */
    public function init()
    {
        if (!$this->ownerName || !$this->ownerId)
            return false;
        
        $this->ownerName = is_object($this->ownerName) ? get_class($this->ownerName) : $this->ownerName;
        $this->ownerId   = (int) $this->ownerId;
    }

    /**
     * Запуск виджета
     */
    public function run()
    {
        $model = new Comment;

        $model->setAttributes(array(
            'owner_name' => $this->ownerName,
            'owner_id'   => $this->ownerId,
        ));

        $this->render('commentform', array(
            'model'      => $model,
            'redirectTo' => $this->redirectTo,
        ));
    }

}

