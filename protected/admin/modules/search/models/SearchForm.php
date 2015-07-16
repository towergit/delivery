<?php

/**
 * Поиск
 *
 * @category Model
 * @package  Module.Search
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные поля формы:
 * @property string $string
 */
class SearchForm extends CFormModel
{

    /**
     * @var string поле поиска
     */
    public $string;

    /**
     * Правила проверки для атрибутов формы
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'string', 'required' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('search', 'Поиск'),
        );
    }

}

