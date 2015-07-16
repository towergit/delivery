<?php

/**
 * Блок контента
 *
 * @category Widget
 * @package  Module.Contentblock
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ContentBlockWidget extends CWidget
{

    /**
     * @var string уникальный код
     */
    public $code;

    /**
     * Запуск виджета
     */
    public function run()
    {
        if (!$this->code)
            return false;

        $criteria            = new CDbCriteria;
        $criteria->condition = 'code = :code AND status = :status';
        $criteria->params    = array( ':code' => $this->code, ':status' => ContentBlock::STATUS_ACTIVE );

        $model = ContentBlock::model()->find($criteria);

        if ($model === null)
            return false;

        switch($model->type)
        {
            case ContentBlock::SIMPLE_TEXT:
                $output = CHtml::encode($model->content);
                break;
            case ContentBlock::PHP_CODE:
                $output = eval($model->content);
                break;
            case ContentBlock::HTML_TEXT:
                $output = $model->content;
                break;
        }
        
        $this->render('contentblock', array(
            'output' => $output,
        ));
    }

}

