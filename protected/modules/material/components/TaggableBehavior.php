<?php

/**
 * Теги
 *
 * @category Component
 * @package  Module.Material
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class TaggableBehavior extends CActiveRecordBehavior
{

    /**
     * @var string название таблицы тегов
     */
    public $tagTable = 'tag';

    /**
     * @var string поле содержащее название тега
     */
    public $tagTableFieldName = 'title';

    /**
     * @var string поле содержащее первичный ключ
     */
    public $tagTablePrimaryKey = 'id';

    /**
     * @var string название кросс-таблицы связывающей модель с тегом
     */
    public $tagBindingTable = 'materialTag';

    /**
     * @var string поле содержащее ключ связывания таблиц
     */
    public $tagBindingTableForeignKey = 'tag_id';

    /**
     * @var array теги 
     */
    private $_tags = array();

    /**
     * @var CDbConnection 
     */
    private $_db;

    /**
     * Получение всех тегов
     */
    public function getAllTags()
    {
        $this->loadTags();
    }

    /**
     * Получение тегов
     * @return array
     */
    public function getTags()
    {
        $this->loadTags();
        return $this->_tags;
    }

    /**
     * Установка тегов
     * @param string|array $tags теги
     * @return CModel
     */
    public function setTags($tags)
    {
        $this->_tags = array_unique($tags);
        return $this->getOwner();
    }

    /**
     * Проверка на существование тегов
     * @param string|array $tags теги
     * @return boolean
     */
    public function hasTags($tags)
    {
        $this->loadTags();

        $tags = String::stringToArray($tags, ',');

        foreach($tags as $tag)
        {
            if (!in_array($tag, $this->_tags))
                return false;
        }

        return true;
    }

    /**
     * Проверка на существование тега
     * @param string $tag тег
     * @return boolean
     */
    public function hasTag($tag)
    {
        return $this->hasTags($tag);
    }

    /**
     * Добавление тегов
     * @param string|array $tags теги
     * @return CModel
     */
    public function addTags($tags)
    {
        $this->loadTags();

        $tags       = String::stringToArray($tags, ',');
        $this->tags = array_unique(array_merge($this->_tags, $tags));

        return $this->getOwner();
    }

    /**
     * Добавление тега
     * @param string $tag тег
     * @return CModel
     */
    public function addTag($tag)
    {
        return $this->addTags($tag);
    }

    /**
     * Удаление всех тегов данной модели
     * @return CModel
     */
    public function removeAllTags()
    {
        $this->loadTags();
        $this->_tags = array();

        return $this->getOwner();
    }

    /**
     * Удаление тегов
     * @param string|array $tags теги
     * @return CModel
     */
    public function removeTags($tags)
    {
        $this->loadTags();

        $tags        = String::stringToArray($tags, ',');
        $this->_tags = array_diff($this->_tags, $tags);

        return $this->getOwner();
    }

    /**
     * Удаление тега
     * @param string $tag тег
     * @return CModel
     */
    public function removeTag($tag)
    {
        return $this->removeTags($tag);
    }

    /**
     * Ограничение запроса ActiveRecord c указанными тегами
     * @param string|array $tags теги
     */
    public function withTags($tags)
    {
        $tags = String::stringToArray($tags, ',');
    }

    /**
     * Действие после сохранения
     * @param CModelEvent $event событие
     */
    public function afterSave($event)
    {
        parent::afterSave($event);
    }

    /**
     * Действие после удаления
     * @param CModelEvent $event событие
     */
    public function afterDelete($event)
    {
        $this->deleteTags();
        parent::afterDelete($event);
    }

    /**
     * Загрузка тегов модели
     * @return array
     */
    private function loadTags()
    {
        if ($this->_tags !== null)
            return;

        if ($this->getOwner()->getIsNewRecord())
            return;

        $this->_tags = $tags;
    }

    /**
     * Соединение с базой данных
     * @return CDbConnection
     */
    private function getConnection()
    {
        if (!isset($this->_db))
            $this->_db = $this->getOwner()->dbConnection;

        return $this->_db;
    }

}

