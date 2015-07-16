<?php

/**
 * Переключатель
 *
 * @category Action
 * @package  Controllers
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ToggleAction extends CAction
{

    /**
     * @var string название модели 
     */
    public $modelName;

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
     * @param integer $id идентификатор
     * @param array $attribute аттрибуты
     */
    public function run($id, $attribute)
    {

        if (empty($this->exception))
            $this->exception = Yii::t('general', 'Не найдено');

        $model = CActiveRecord::model($this->modelName)->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, $this->exception);

        $model->$attribute = $model->$attribute ? 0 : 1;
        $model->save(false);

        if (!Yii::app()->request->isAjaxRequest)
            $this->getController()->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $this->redirectTo);
    }

}

