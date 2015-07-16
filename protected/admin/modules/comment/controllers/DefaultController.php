<?php

/**
 * Комментарии
 *
 * @category Controller
 * @package  Module.Comment
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class DefaultController extends BackendController
{

    /**
     * @var string модель по умолчанию
     */
    public $defaultModel = 'Comment';

    /**
     * Фильтр доступа
     * @return array
     */
    public function filters()
    {
        return array();
    }

    /**
     * Добавление комментария
     */
    public function addAction()
    {
        $model = new $this->defaultModel;

        if (isset($_POST['ajax']) && $_POST['ajax'] === strtolower($this->modelName) . '-form')
        {
            echo BsActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST[$this->defaultModel]))
        {
            $model->attributes = $_POST[$this->defaultModel];
            $model->status     = Comment::STATUS_NEED_CHECK;
            
            $redirect = isset($_POST['redirectTo']) ? $_POST['redirectTo'] : Yii::app()->user->returnUrl;

            if (!Yii::app()->user->isGuest)
            {
                $model->setAttributes(array(
                    'user_id' => Yii::app()->user->id,
                    'name'    => Yii::app()->user->username,
                    'email'   => Yii::app()->user->email,
                ));
                
                $model->status = Comment::STATUS_APPROVED;
            }
            
            if ($model->save())
            {
                $message = $comment->status !== Comment::STATUS_APPROVED
                    ? Yii::t('comment', 'Спасибо, Ваш комментарий добавлен и ожидает проверки!')
                    : Yii::t('comment', 'Спасибо, Ваш комментарий добавлен!');
                
                Yii::app()->user->setFlash('success', $message);
            }
            else
                Yii::app()->user->setFlash('success', Yii::t('comment', 'Комментарий не добавлен!'));
            
            $this->redirect($redirect);
        }
    }

}

