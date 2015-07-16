<?php

/**
 * Список комментариев
 *
 * @category Widget
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class CommentListWidget extends CWidget
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
        $criteria            = new CDbCriteria;
        $criteria->with      = array( 'author' );
        $criteria->condition = 't.owner_name = :ownerName AND t.owner_id = :ownerId AND t.status = :status';
        $criteria->params    = array(
            ':ownerName' => $this->ownerName,
            ':ownerId'   => $this->ownerId,
            ':status'    => Comment::STATUS_APPROVED,
        );
        $criteria->order     = 't.id';

        $models = Comment::model()->findAll($criteria);

        $this->render('commentlist', array(
            'models' => $models,
        ));
    }

}

