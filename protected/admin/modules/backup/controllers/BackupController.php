<?php

/**
 * Резервные копии
 *
 * @category Controller
 * @package  Module.Backup
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class BackupController extends BackendController
{
    /**
     * Правила доступа к экшенам
     * @return array
     */
    public function accessRules()
    {
        return array(
            array( 'allow',
                'actions' => array( 'index' ),
                'roles'   => array( 'showBackup' ),
            ),
            array( 'allow',
                'actions' => array( 'create' ),
                'roles'   => array( 'createBackup' ),
            ),
            array( 'allow',
                'actions' => array( 'download' ),
                'roles'   => array( 'downloadBackup' ),
            ),
            array( 'allow',
                'actions' => array( 'restore' ),
                'roles'   => array( 'restoreBackup' ),
            ),
            array( 'allow',
                'actions' => array( 'delete' ),
                'roles'   => array( 'deleteBackup' ),
            ),
            array( 'allow',
                'actions' => array( 'remove' ),
                'roles'   => array( 'removeBackup' ),
            ),
            array( 'allow',
                'actions' => array( 'truncate' ),
                'roles'   => array( 'truncateBackupDataBase' ),
            ),
            array( 'deny',
                'users' => array( '*' ),
            ),
        );
    }

    /**
     * Список резервных копий базы данных
     */
    public function actionIndex()
    {
        $backup = new BackupDatabase();
        $array  = array();

        foreach(glob($backup->path . DIRECTORY_SEPARATOR . '*') as $key => $filename)
        {
            $key++;
            $array[$key]['id']       = $key;
            $array[$key]['basename'] = basename($filename);
            $array[$key]['size']     = floor(filesize($filename) / 1024) . ' KB';
            $array[$key]['created']  = filectime($filename);
        }

        $sort               = new CSort;
        $sort->defaultOrder = 'id DESC';
        $sort->attributes   = array( 'created' );

        $dataProvider = new CArrayDataProvider($array,
            array(
            'pagination' => array( 'pageSize' => 10 ),
            'sort'       => $sort
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Создание резервной копии базы данных
     */
    public function actionCreate()
    {
        $backup = new BackupDatabase();
        $flag   = $backup->createBackup();

        if ($flag)
            Yii::app()->user->setFlash('success', Yii::t('backup', 'Резервная копия успешно создана'));
        else
            Yii::app()->user->setFlash('error', Yii::t('backup', 'Ошибка при создании резервной копии'));

        $this->redirect(array( 'index' ));
    }

    /**
     * Скачивание резервной копии базы данных
     * @param string $file название файла
     */
    public function actionDownload($file)
    {
        $backup   = new BackupDatabase();
        $path     = $backup->path;
        $fileName = $path . DIRECTORY_SEPARATOR . $file;

        if (file_exists($fileName))
            Yii::app()->request->sendFile($file, file_get_contents($fileName));
        else
            Yii::app()->user->setFlash('error', Yii::t('backup', 'Файл не найден'));

        $this->redirect(array( 'index' ));
    }

    /**
     * Восстановление резервной копии базы данных
     * @param string $file название файла
     */
    public function actionRestore($file)
    {
        $backup = new BackupDatabase;

        if ($backup->restore($file))
            Yii::app()->user->setFlash('success', Yii::t('backup', 'Резервная копия успешно востановлена'));
        else
            Yii::app()->user->setFlash('error', Yii::t('backup', 'Ошибка при востоновлении резервной копии'));

        $this->redirect(array( 'index' ));
    }

    /**
     * Удаление резервной копии базы данных
     * @param string $file название файла
     */
    public function actionDelete($file)
    {
        $backup = new BackupDatabase();

        if ($backup->removeFile($file))
            Yii::app()->user->setFlash('success', Yii::t('backup', 'Резервная копия успешно удалена'));
        else
            Yii::app()->user->setFlash('error', Yii::t('backup', 'Ошибка при удалении резервной копии'));

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
                    'index' ));

        $this->redirect(array( 'index' ));
    }

    /**
     * Удаление всех резервных копий
     */
    public function actionRemove()
    {
        $backup = new BackupDatabase();
        $flag   = false;

        foreach(glob($backup->path . DIRECTORY_SEPARATOR . '*') as $key => $filename)
        {
            if (unlink($filename))
                $flag = true;
        }

        if ($flag)
            Yii::app()->user->setFlash('success', Yii::t('backup', 'Резервные копии успешно удалены'));
        else
            Yii::app()->user->setFlash('info', Yii::t('backup', 'Нет ни одной резервной копии!'));

        $this->redirect(array( 'index' ));
    }

    /**
     * Очистка таблиц базы данных
     */
    public function actionTruncate()
    {
        $backup = new BackupDatabase();

        if ($backup->clean())
            Yii::app()->user->setFlash('success', Yii::t('backup', 'Все таблицы базы данных успешно очищены'));
        else
            Yii::app()->user->setFlash('error', Yii::t('backup', 'Ошибка при очищении таблиц базы данных'));

        $this->redirect(array( 'index' ));
    }

}

