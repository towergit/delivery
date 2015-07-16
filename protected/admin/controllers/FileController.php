<?php

/**
 * Контроллер по умолчанию
 *
 * @category Controller
 * @package  Controllers
 * @author   Vlad Lotysh <timkovsky.alexandr@gmail.com>
 */
class FileController extends BackendController
{
    public function actionDelete()
    {

        $id =  Yii::app()->request->getQuery('id');
        $ownerName =  Yii::app()->request->getQuery('owner_name') ? Yii::app()->request->getQuery('owner_name') : 'image';
        $ownerId = Yii::app()->request->getQuery('owner_id');
        $redirectUrl = Yii::app()->request->getQuery('redirect_url');
        
        $model = Material::model();
        $result = $model->imagesUpload->deleteFile($id,$ownerId);

        if ($result) {
            Yii::app()->user->setFlash('success', Yii::t($ownerName, 'Фото удалено успешно!'));
        } else {
            Yii::app()->user->setFlash('error', Yii::t($ownerName, 'Фото не удалено!'));
        }

        $this->redirect($redirectUrl);
      
    }
}

