<?php

/**
 * Сесии пользователей
 *
 * @category Component
 * @package  Component
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class Session extends CDbHttpSession
{

    /**
     * @var boolean обновление даты последнего визита
     */
    public $updateLastVisit = true;

    /**
     * @var boolean уникальный IP 
     */
    public $uniqueIP = false;

    /**
     * Создание таблицы сессии
     * @param CDbConnection $db подключение к базе данных
     * @param string $tableName название таблицы
     */
    protected function createSessionTable($db, $tableName)
    {
        $db->createCommand()->createTable($tableName,
            array(
            'id'      => 'CHAR(32) PRIMARY KEY',
            'user_id' => 'INTEGER(10) UNSIGNED NULL',
            'ip'      => 'VARCHAR(15) NOT NULL',
            'expire'  => 'INTEGER(10) UNSIGNED NOT NULL',
            'data'    => 'TEXT NOT NULL',
        ));
    }

    /**
     * Чтение сессии
     * @param string $id ID сессии
     * @return string
     */
    public function readSession($id)
    {
        $db = $this->getDbConnection();
        $ip = Yii::app()->request->userHostAddress;

        $data = $db->createCommand()
            ->select('data')
            ->from($this->sessionTableName)
            ->where('id = :id AND ip = :ip AND expire > :expire',
                array(
                ':id'     => $id,
                ':ip'     => $ip,
                ':expire' => time()
            ))
            ->queryScalar();

        return $data === false ? '' : $data;
    }

    /**
     * Чиение сессии
     * @param string $id ID сессии
     * @param string $data данные сессии
     * @return boolean
     */
    public function writeSession($id, $data)
    {
        $db     = $this->getDbConnection();
        $ip     = Yii::app()->request->userHostAddress;
        $expire = time() + $this->getTimeout();

        $user   = Yii::app()->getComponent('user', false);
        $userId = empty($user) ? null : $user->id;

        $data1 = $db->createCommand()
            ->select('id')
            ->from($this->sessionTableName)
            ->where('id = :id AND ip = :ip', array( ':id' => $id, ':ip' => $ip ))
            ->limit(1)
            ->queryScalar();

        if (false === $data1)
        {
            $sql = "DELETE FROM `{$this->sessionTableName}` WHERE `id` = :id LIMIT 1";
            $db->createCommand($sql)->bindValue(':id', $id)->execute();
            $sql = "INSERT INTO `{$this->sessionTableName}` (`id`, `ip`, `expire`, `data`, `user_id`) VALUES (:id, :ip, :expire, :data, :user_id)";
            $db->createCommand($sql)->bindValue(':id', $id)->bindValue(':user_id', $userId)->bindValue(
                ':ip', $ip
            )->bindValue(':expire', $expire)->bindValue(':data', $data)->execute();
        }
        else
        {
            $sql = "UPDATE `{$this->sessionTableName}` SET `expire` = :expire, `data` = :data, `user_id` = :user_id WHERE `id` = :id LIMIT 1";
            $db->createCommand($sql)->bindValue(':expire', $expire)->bindValue(':user_id', $userId)->bindValue(
                ':data', $data
            )->bindValue(':id', $id)->execute();

            if ($this->updateLastVisit)
                $this->updateLastVisit($userId);

            if ($this->uniqueIP)
            {
                $sql = "DELETE FROM `{$this->sessionTableName}` WHERE `id` != :id AND `ip` = :ip AND `user_id` != :user_id";
                $db->createCommand($sql)->bindValue(':ip', $ip)->bindValue(':id', $id)->bindValue(
                    ':user_id', $userId
                )->execute();
            }
        }

        return true;
    }

    /**
     * Обновление даты последнего визита пользователя
     * @param integer $userId идентификатор пользователя
     */
    public function updateLastVisit($userId)
    {
        $db = $this->getDbConnection();

        $sql = "UPDATE `{{user}}` SET `last_visit` = :last_visit WHERE `id` = :id LIMIT 1";
        $db->createCommand($sql)
            ->bindValue(':last_visit', time())
            ->bindValue(':id', $userId)
            ->execute();
    }

}

