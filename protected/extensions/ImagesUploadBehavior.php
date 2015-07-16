<?php

/**
 * Загрузка изображений
 *
 * @category Behavior
 * @package  Behaviors
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class ImagesUploadBehavior extends CActiveRecordBehavior {

    /**
     * @var string путь к папке загрузки
     */
    public $uploadPath;

    /**
     * Для загрузок иконок
     * 
     * @var type 
     */
    public $singlePic;

    /**
     * @var string название поля файла
     */
    public $fileField = 'file';

    /**
     * @var string типы файлов
     */
    public $types = 'jpg, jpeg, png';

    /**
     * @var string изображение 
     */
    private $_file;

    /**
     * @var string старое изображение
     */
    private $_old_file;

    /**
     * Прикрепление валидации
     * @param type $owner
     */
//	public function attach($owner)
//	{
//		parent::attach($owner);
//
//		$validators	 = $this->owner->getValidatorList();
//		$validator	 = CValidator::createValidator('file', $this->owner, $this->fileField, array(
//			'types'		 => $this->types,
//			'allowEmpty' => true
//		));
//		$validators->add($validator);
//	}

    /**
     * Действие после поиска
     * @param type $event
     */
//	public function afterFind($event)
//    {
//        $this->_old_file = $this->owner->{$this->fileField};
//    }

    /**
     * Действие до сохранения
     * @param type $event
     */
    public function beforeSave($event) {

        $event->isValid = true;
    }

    /**
     * Действие после сохранения
     * @param type $event
     */
    public function afterSave($event) {

        $this->_file = CUploadedFile::getInstancesByName($this->fileField);

        if (isset($this->_file) && count($this->_file) > 0) {
            foreach ($this->_file as $file) {
                $fileName = $this->getFileName($file) . '.' . $file->getExtensionName();

                $model = new UploadFile;

                if ($this->uploadPath)
                    $model->owner_name = $this->uploadPath;
                else
                    $model->owner_name = Yii::app()->controller->module->id;

                $model->owner_id = $this->owner->id;
                $model->file = $fileName;
                $model->save(false);
            }
        }

        $this->createFolder();

        if (isset($this->_file) && count($this->_file) > 0) {
            
            if($this->singlePic)
                $this->_iconUpload ($this->_file);
            else
                $this->_galleryUpload ($this->_file);
                
        }
    }

    /**
     * Удаление файла
     */
    public function deleteFile($id, UploadFile $object = null) {

        if ($id)
            $model = UploadFile::model()->findByPk($id);
        else
            $model = $object;

        $owner_name = $model->owner_name;
        $filename = $model->file;
        $success = true;

        if ($model->delete()) {//) {
            try {
                $fileFolders = array(
                    'folder' => Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR . $owner_name . '/' . $filename,
                    'folderFullPic' => Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR . $owner_name . '/' . '_full' . '/' . $filename,
                    'folderThumbPic' => Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR . $owner_name . '/_thumbs' . '/' . $filename,
                );

                foreach ($fileFolders as $file) {

                    if (file_exists($file) && !is_dir($file)) {
                        unlink($file);
                    }
                }
            } catch (Exception $e) {
                $success = false;
                return $success;
            }
        }

        return $success;
    }

    /**
     * Создание папки
     */
    public function createFolder() {

        $folders = array(
            'folder' => $this->getUploadPath(),
            'folderFull' => $this->getUploadPath() . '/_full',
            'foldeThumbs' => $this->getUploadPath() . '/_thumbs'
        );

        foreach ($folders as $folder) {
            if (is_dir($folder) == false)
                mkdir($folder, 0755, true);
        }
    }

    /**
     * Получение пути загрузки файла
     * @return string
     */
    public function getUploadPath() {
        return Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR . $this->uploadPath;
    }

    /**
     * Получение пути для загрузки полноразмерных файлов файла
     * @return string
     */
    public function getUploadPathFullPic() {
        return Yii::getPathOfAlias('webroot.uploads') . DIRECTORY_SEPARATOR . $this->uploadPath . '/_full';
    }

    /**
     * Получение названия файла
     * @param object $file файл
     * @return string
     */
    public function getFileName($file) {
        return md5($file->name . Yii::app()->user->id);
    }

    /**
     * Получение url файла
     * @return string
     */
    public function getFileUrl($fileName) {
        return DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $this->uploadPath . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Получение url файла
     * @return string
     */
    public function getThumbFileUrl($fileName) {
        return DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $this->uploadPath . DIRECTORY_SEPARATOR . '_thumbs' . DIRECTORY_SEPARATOR . $fileName;
    }

    protected function _galleryUpload($files) {

        foreach ($files as $file) {

            $folder = $this->getUploadPath();
            $folderFullPic = $this->getUploadPathFullPic();
            $fileName = $this->getFileName($file) . '.' . $file->getExtensionName();

            $path = $folder . '/' . $this->getFileName($file) . '.' . $file->getExtensionName();

            $pathFullPic = $folderFullPic . '/' . $fileName;
            $path_thumbs = $folder . '/_thumbs' . '/' . $fileName;

            $file->saveAs($pathFullPic);

            $image = Yii::app()->image->load($pathFullPic);
            $thumdImage = clone $image;

            $image->resize(850, null);
            $image->crop(850, 355, 'top');
            $image->save($path);

            $thumdImage->resize(500, null);
            $thumdImage->crop(350, 240, 'top', 'center');
            $thumdImage->save($path_thumbs);
        }
    }

    protected function _iconUpload($files) {
        foreach ($files as $file) {
            
            $folder = $this->getUploadPath();

            $path = $folder . '/' . $this->getFileName($file) . '.' . $file->getExtensionName();
            
            $file->saveAs($path);
            $image = Yii::app()->image->load($path);
            
            if($image->width > 200 || $image->height > 200)
                $image->resize(200, null);
            
            $image->save($path);
        }
    }

}
