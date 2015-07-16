<?php

/**
 * Валидатор псевдонима
 * 
 * @category Validator
 * @package  Validators
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 */
class AliasValidator extends CValidator
{

    /**
     * @var string атрибут транслитерации
     */
    public $translitAttribute = 'title';

    /**
     * @var boolean включение транслитерации когда отрибут пустой или равен null
     */
    public $setOnEmpty = true;

    /**
     * Валидация атрибута
     * @param CModel $object объект
     * @param string $attribute название атрибута
     */
    public function validateAttribute($object, $attribute)
    {
        if ($this->setOnEmpty && $this->isEmpty($object->$attribute))
            return;

        if (!$object->hasAttribute($this->translitAttribute))
        {
            throw new CException(Yii::t('yii', 'Active record "{class}" не может найти "{column}".',
                array(
                '{class}'  => get_class($object),
                '{column}' => $this->translitAttribute
            )));
        }

        $object->$attribute = String::translit($object->getAttribute($this->translitAttribute));
    }
}

