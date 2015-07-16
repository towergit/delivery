<?php

/**
 * Профиль
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{user_profile}}':
 * @property integer $id
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $patronymic
 * @property string $phone
 * @property integer $curator
 * @property integer $birth_date
 * @property integer $gender
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $zip_code
 * @property string $address
 * @property string $skype
 * @property string $icq
 * @property string $vk
 * @property string $fb
 * @property string $ok
 * 
 * Доступные модели связей:
 * @property User[] $user
 */
class UserProfile extends CActiveRecord
{

    /**
     * Пол
     */
    const GENDER_THING  = 0;
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{user_profile}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'phone', 'required' ),
            array( 'phone', 'unique', 'caseSensitive' => false ),
            array( 'user_id, curator, birth_date, gender, zip_code', 'numerical', 'integerOnly' => true ),
            array( 'birth_date', 'length', 'max' => 10 ),
            array( 'curator', 'length', 'max' => 11 ),
            array( 'firstname, lastname, patronymic, country, region, city, address', 'length', 'max' => 255 ),
            array( 'skype, icq, vk, fb, ok', 'length', 'max' => 50 ),
            array( 'gender', 'in', 'range' => array_keys($this->genderList) ),
            array( 'id, user_id, firstname, lastname, patronymic, phone, curator, birth_date, gender, country, region, city, zip_code, address, skype, isq, vk, fb, ok', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'user' => array( self::BELONGS_TO, 'User', 'user_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'         => Yii::t('user', 'ID'),
            'user_id'    => Yii::t('user', 'Пользователь'),
            'firstname'  => Yii::t('user', 'Имя'),
            'lastname'   => Yii::t('user', 'Фамилия'),
            'patronymic' => Yii::t('user', 'Отчество'),
            'phone'      => Yii::t('user', 'Телефон'),
            'curator'    => Yii::t('user', 'Куратор'),
            'birth_date' => Yii::t('user', 'Дата рождения'),
            'gender'     => Yii::t('user', 'Пол'),
            'country'    => Yii::t('user', 'Страна'),
            'region'     => Yii::t('user', 'Область'),
            'city'       => Yii::t('user', 'Город'),
            'zip_code'   => Yii::t('user', 'Почтовый индекс'),
            'address'    => Yii::t('user', 'Адрес'),
            'skype'      => Yii::t('user', 'Skype'),
            'icq'        => Yii::t('user', 'ICQ'),
            'vk'         => Yii::t('user', 'Вконтакте'),
            'fb'         => Yii::t('user', 'Facebook'),
            'ok'         => Yii::t('user', 'Одноклассники'),
        );
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('patronymic', $this->patronymic, true);
        $criteria->compare('phone', $this->phone, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Получение куратора
     * @return object
     */
    public function getCurator()
    {
        $model = User::model()->findByPk($this->curator);
        
        if ($model === null)
            return false;
        
        return $model->username;
    }

    /**
     * Получение списка полов пользователя
     * @return array
     */
    public function getGenderList()
    {
        return array(
            self::GENDER_THING  => Yii::t('user', 'Не указано'),
            self::GENDER_MALE   => Yii::t('user', 'Мужской'),
            self::GENDER_FEMALE => Yii::t('user', 'Женский'),
        );
    }

    /**
     * Получение пола пользователя
     * @return string
     */
    public function getGender()
    {
        $data = $this->genderList;
        return (isset($data[$this->gender]) ? $data[$this->gender] : Yii::t('user', '*неизвестно*'));
    }
    
    /**
     * До валидации модели
     * @return boolean
     */
    public function beforeValidate()
    {
        if ($this->birth_date)
            $this->birth_date = strtotime($this->birth_date);
            
        return parent::beforeValidate();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return UserProfile статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

