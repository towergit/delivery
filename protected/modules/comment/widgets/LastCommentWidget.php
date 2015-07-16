<?php

/**
 * Последние комментарии
 *
 * @category Widget
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LastCommentWidget extends CWidget
{

    /**
     * @var string модель     
     */
    public $ownerName;

    /**
     * @var integer статус комментариев
     */
    public $commentStatus;

    /**
     * @var integer лимиты
     */
    public $limit = 10;

    /**
     * Инициализация виджета
     */
    public function init()
    {
        if ($this->ownerName)
            $this->ownerName = is_object($this->ownerName) ? get_class($this->ownerName) : $this->ownerName;

        $this->commentStatus || ($this->commentStatus = Comment::STATUS_APPROVED);
    }

    /**
     * Запуск виджета
     */
    public function run()
    {
        $criteria            = new CDbCriteria;
        $criteria->condition = 't.status = :status';
        $criteria->params    = array( ':status' => Comment::STATUS_APPROVED );
        $criteria->limit     = $this->limit;
        $criteria->order     = 't.id DESC';

        if ($this->ownerName)
        {
            $criteria->addCondition('owner_name = :ownerName');
            $criteria->params[':ownerName'] = $this->ownerName;
        }

        $models = Comment::model()->findAll($criteria);

        $this->render('commentlist', array(
            'models' => $models,
        ));
    }

}

