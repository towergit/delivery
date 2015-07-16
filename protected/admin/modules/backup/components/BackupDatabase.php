<?php

/**
 * Резервное копирование базы данных
 * Востановление резервной копии базы данных
 * Удаление файла
 *
 * @category Component
 * @package  Module.Backup
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class BackupDatabase extends CApplicationComponent
{

    /**
     * @var string путь
     */
    public $path;

    /**
     * @var string имя файла
     */
    public $fileName;

    /**
     * @var boolean cжатие файла
     */
    public $gzEncode = false;

    /**
     * Конструктор
     */
    public function __construct()
    {
        if (!$this->path)
            $this->path = $this->getPath();
    }

    /**
     * Создвание резервной копии базы данных
     * @return boolean
     */
    public function createBackup()
    {
        if (!$this->fileName)
            $this->fileName = 'dump_' . time();

        if ($this->gzEncode && function_exists('gzencode'))
            $file = file_put_contents($this->path . DIRECTORY_SEPARATOR . $this->fileName . '.sql' . '.gz',
                gzencode($this->getDumpTables()));
        else
            $file = file_put_contents($this->path . DIRECTORY_SEPARATOR . $this->fileName . '.sql',
                $this->getDumpTables());

        if ($file)
            return true;

        return false;
    }

    /**
     * Востановление базы данных
     * @param string $file название файла
     * @return boolean
     */
    public function restore($file)
    {
        $this->fileName = $this->path . DIRECTORY_SEPARATOR . $file;

        if (file_exists($this->fileName))
        {
            $string = file_get_contents($this->fileName);
            $cmd    = Yii::app()->db->createCommand($string);

            try
            {
                $cmd->execute();
                return true;
            }
            catch(CDbException $e)
            {
                return false;
            }
        }
    }

    /**
     * Удаление файла
     * @param string $file название файла
     * @return boolean
     */
    public function removeFile($file)
    {
        $this->fileName = $this->path . DIRECTORY_SEPARATOR . $file;

        if (file_exists($this->fileName))
        {
            unlink($this->fileName);
            return true;
        }
        else
            return false;
    }

    /**
     * Очистка базы данных
     */
    public function clean()
    {
        ob_start();
        echo 'SET FOREIGN_KEY_CHECKS = 0;' . PHP_EOL;

        foreach($this->getTables() as $table)
        {
            $db = Yii::app()->db;

            echo 'TRUNCATE TABLE ' . $db->quoteTableName($table->name) . ';' . PHP_EOL;
        }

        echo 'SET FOREIGN_KEY_CHECKS = 1;' . PHP_EOL;

        $result = ob_get_contents();
        ob_end_clean();

        $cmd = Yii::app()->db->createCommand($result);

        try
        {
            $cmd->execute();
            return true;
        }
        catch(CDbException $e)
        {
            return false;
        }
    }

    /**
     * Получение пути
     * @return string
     */
    private function getPath()
    {
        $this->path = Yii::getPathOfAlias('webroot.uploads.backup');

        if (!file_exists($this->path))
        {
            mkdir($this->path);
            chmod($this->path, 777);
        }

        return $this->path;
    }

    /**
     * Дамп всех таблиц
     * @return string
     */
    private function getDumpTables()
    {
        ob_start();
        echo 'SET FOREIGN_KEY_CHECKS = 0;' . PHP_EOL;

        foreach($this->getTables() as $key => $val)
            $this->getDumpTable($key);

        echo 'SET FOREIGN_KEY_CHECKS = 1;' . PHP_EOL;

        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }

    /**
     * Получение дампа таблицы
     * @param string $tableName
     * @return mixed
     */
    private function getDumpTable($tableName)
    {
        $db  = Yii::app()->db;
        $pdo = $db->getPdoInstance();

        echo '
--
-- Structure for table `' . $tableName . '`
--
' . PHP_EOL;
        echo 'DROP TABLE IF EXISTS ' . $db->quoteTableName($tableName) . ';' . PHP_EOL;

        $q = $db->createCommand('SHOW CREATE TABLE ' . $db->quoteTableName($tableName) . ';')->queryRow();
        echo $q['Create Table'] . ';' . PHP_EOL . PHP_EOL;

        $rows = $db->createCommand('SELECT * FROM ' . $db->quoteTableName($tableName) . ';')->queryAll();

        if (empty($rows))
            return;

        echo '
--
-- Data for table `' . $tableName . '`
--
' . PHP_EOL;

        $attrs     = array_map(array( $db, 'quoteColumnName' ), array_keys($rows[0]));
        echo 'INSERT INTO ' . $db->quoteTableName($tableName) . '' . " (", implode(', ', $attrs), ') VALUES' . PHP_EOL;
        $i         = 0;
        $rowsCount = count($rows);
        foreach($rows AS $row)
        {
            foreach($row AS $key => $value)
            {
                if ($value === null)
                    $row[$key] = 'NULL';
                else
                    $row[$key] = $pdo->quote($value);
            }

            echo " (", implode(', ', $row), ')';
            if ($i < $rowsCount - 1)
                echo ',';
            else
                echo ';';
            echo PHP_EOL;
            $i++;
        }
        echo PHP_EOL;
        echo PHP_EOL;
    }

    /**
     * Получение всех таблиц в базе данных
     * @return array
     */
    private function getTables()
    {
        $db = Yii::app()->db;
        return $db->getSchema()->getTables();
    }

}

