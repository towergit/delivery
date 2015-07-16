<?php
Yii::import('admin.controllers.action.GeneralAction');

/**
 * Удаление записи
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class DeleteAction extends GeneralAction
{

    /**
     * @var string название аттрибута 
     */
    public $attributeName = 'id';

    /**
     * @var string информационное уведомление
     */
    public $info;

    /**
     * @var string уведомление об успехе
     */
    public $success;

    /**
     * @var string уведомление об ошибке
     */
    public $error;

    /**
     * @var array перенаправление
     */
    public $redirectTo = array( 'index' );

    /**
     * @var string текст исключения 
     */
    public $exception;

    /**
     * Запуск действия
     * @param integer $id
     */
    public function run($id)
    {
        if (empty($this->exception))
            $this->exception = Yii::t('general', 'Не найдено');
        
        if (gettype($id) == 'integer')
            $model = CActiveRecord::model($this->modelName)->findByPk($id);
        else
            $model = CActiveRecord::model($this->modelName)->findByAttributes(array( $this->attributeName => $id ));

        if ($model === null)
            $this->flashMessage(self::TYPE_ERROR, $this->exception);

        if ($model->delete())
            $this->flashMessage(self::TYPE_SUCCESS, $this->success);
        else
            $this->flashMessage(self::TYPE_ERROR, $this->error);

        if (Yii::app()->getRequest()->getIsAjaxRequest())
            Yii::app()->end(200, true);
        else
            $this->getController()->redirect($this->redirectTo);
    }

}

