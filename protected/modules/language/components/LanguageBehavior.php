<?php

/**
 * Мультиязычность
 *
 * @category Behavior
 * @package  Module.Language
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class LanguageBehavior extends CActiveRecordBehavior
{

    /**
     * @var array атрибуты для перевода
     */
    public $attributes;

    /**
     * @var array список доступных языков 
     */
    public $languages;

    /**
     * @var string язык по умолчанию 
     */
    public $defaultLanguage;

    /**
     * @var string название таблицы переводов.
     * По умолчанию [название таблицы базовой модели]_lang
     */
    public $tableName;

    /**
     * @var string название класса переводов модели.
     * По умолчанию [название базовой модели]Lang
     */
    public $langClassName;

    /**
     * @var string название ключа связывающего таблицу перевода с базовой таблицей модели.
     * По умолчанию owner_id
     */
    public $langForeignKey = 'owner_id';

    /**
     * @var string префикс локализованных атрибутов в таблице переводов. 
     */
    public $localizedPrefix = '';

    /**
     * @var string название поля языка таблицы переводов.
     * По умолчанию lang_id
     */
    public $languageField = 'language';

    /**
     * @var boolean будут ли валидироваться атрибуты модели
     */
    public $requireTranslations = false;

    /**
     * @var boolean будут ли удаляться переводы при удалении основной записи 
     */
    public $forceDelete = true;

    /**
     * @var boolean будет ли динамически создаваться модель перевода 
     */
    public $dynamicLangClass = true;

    /**
     * @var string текущий язык
     */
    private $_currentLanguage;
    private $_ownerClassName;
    private $_ownerPrimaryKey;
    private $_langAttributes = array();

}

