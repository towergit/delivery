<?php

/**
 * Подписаться
 *
 * @category Model
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{subscribe}}':
 * @property integer $id
 * @property string $email
 */
class Subscribe extends CActiveRecord
{
    
    const STATUS_ACTIVE = 1;
    
    public $role = 'Подписчик';

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{subscribe}}';
    }

    /**
     * Поведения
     * @return array
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'           => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_date',
                'updateAttribute' => null,
            ),
        );
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'email', 'required' ),
            array( 'email', 'unique', 'caseSensitive' => false ),
            array( 'email', 'email' ),
        );
    }
    
        /**
     * Именованная группа условий
     * @return array
     */
    public function scopes()
    {
        return array(
            'active'   => array(
                'condition' => 't.subscribe = :subscribe',
                'params'    => array( ':subscribe' => self::STATUS_ACTIVE ),
            )
        );
    }
    
    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('main', 'ID'),
            'email'       => Yii::t('main', 'Ваш email адрес'),
            'phone' => Yii::t('main', 'Телефон'),
            'first_name' => Yii::t('main', 'Имя'),
            'last_name' => Yii::t('main', 'Имя'),
            'patronymic'  => Yii::t('main', 'Отчество'),
            'subscribe'  => Yii::t('main', 'Подписан'),
        );
    }
    
        /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone,true);
        $criteria->compare('first_name', $this->first_name,true);
        $criteria->compare('patronymic', $this->patronymic,true);
        $criteria->compare('last_name', $this->last_name,true);
        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }
    

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Subscribe статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

