<?php

/**
 * Пользователи
 *
 * @category Model
 * @package  Module.User
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $last_visit
 * @property string $activation_key
 * @property integer $status
 * @property integer $read_only
 * @property integer $sort
 *
 * Доступные модели связей:
 * @property UserProfile[] $profile
 * @property AuthAssignment[] $assignment
 */
class User extends CActiveRecord
{

    /**
     * Статус
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_BLOCK    = 2;

    /**
     * Только для чтения
     */
    const READ_ONLY = 1;

    /**
     * @var mixed роли
     */
    public $role;

    /**
     * @var mixed операции 
     */
    public $operation;

    /**
     * @var string телефон
     */
    public $phone;

    /**
     * @var string новый пароль
     */
    public $new_password;

    /**
     * @var string повторение нового пароля
     */
    public $confirm_password;

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
                'updateAttribute' => 'update_date',
            ),
        );
    }

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'username, email, role', 'required' ),
            array( 'username', 'match', 'pattern' => '/^[A-Za-z0-9\-]+$/iu', 'message' => Yii::t('user',
                    'Логин должен состоять из латинских букв и цифр') ),
            array( 'username, email', 'unique', 'caseSensitive' => false ),
            array( 'email', 'email' ),
            array( 'create_date, update_date, last_visit, status, read_only', 'numerical', 'integerOnly' => true ),
            array( 'create_date, update_date, last_visit', 'length', 'max' => 10 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'username, new_password, confirm_password, email', 'length', 'max' => 255 ),
            array( 'new_password', 'length', 'min' => 6, 'allowEmpty' => true ),
            array( 'confirm_password', 'compare', 'compareAttribute' => 'new_password' ),
            array( 'operation, last_visit, activation_key', 'safe' ),
            array( 'new_password, confirm_password', 'required', 'on' => 'create' ),
            array( 'id, username, email, phone, create_date, update_date, last_visit, activation_key, status, read_only, sort',
                'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'profile'    => array( self::HAS_ONE, 'UserProfile', 'user_id' ),
            'assignment' => array( self::HAS_MANY, 'AuthAssignment', 'userid' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('user', 'ID'),
            'username'         => Yii::t('user', 'Логин'),
            'password'         => Yii::t('user', 'Пароль'),
            'new_password'     => Yii::t('user', 'Новый пароль'),
            'confirm_password' => Yii::t('user', 'Повторить пароль'),
            'email'            => Yii::t('user', 'Эл. почта'),
            'role'             => Yii::t('user', 'Роль'),
            'operation'        => Yii::t('user', 'Операции'),
            'phone'            => Yii::t('user', 'Телефон'),
            'create_date'      => Yii::t('user', 'Дата создания'),
            'update_date'      => Yii::t('user', 'Дата обновления'),
            'last_visit'       => Yii::t('user', 'Последний визит'),
            'activation_key'   => Yii::t('user', 'Ключ активации'),
            'status'           => Yii::t('user', 'Статус'),
            'read_only'        => Yii::t('user', 'Только для чтения'),
            'sort'             => Yii::t('user', 'Сортировка'),
        );
    }

    /**
     * Именованная группа условий
     * @return array
     */
    public function scopes()
    {
        return array(
            'inactive' => array(
                'condition' => 'status = :status',
                'params'    => array( ':status' => self::STATUS_INACTIVE ),
            ),
            'active'   => array(
                'condition' => 'status = :status',
                'params'    => array( ':status' => self::STATUS_ACTIVE ),
            ),
            'blocked'  => array(
                'condition' => 'status = :status',
                'params'    => array( ':status' => self::STATUS_BLOCK ),
            ),
            'readOnly' => array(
                'condition' => 'read_only = :read_only',
                'params'    => array( ':read_only' => self::READ_ONLY ),
            ),
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
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('FROM_UNIXTIME(create_date, "%d.%m.%Y")', $this->create_date);
        $criteria->compare('FROM_UNIXTIME(last_visit, "%d.%m.%Y")', $this->last_visit);
        $criteria->compare('status', $this->status);
        $criteria->with = array( 'profile' );
        $criteria->compare('profile.phone', $this->phone, true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'create_date DESC',
            ),
            'pagination' => array(
                'pageSize' => (int) Yii::app()->session['pageCount'] ? Yii::app()->session['pageCount'] : 10,
            ),
        ));
    }

    /**
     * Получение куратора пользователя
     * @param string $username логин
     * @return boolean
     */
    public function getCurator($username)
    {
        $model = self::model()->findByAttributes(array( 'username' => $username ));

        if ($model === null)
            return false;

        return $model;
    }

    /**
     * Получение списка пользователей
     * @return array
     */
    public function getUserList()
    {
        $models = self::model()->findAll();
        return CHtml::listData($models, 'id', 'username');
    }

    /**
     * Получение списка ролей
     * @return array
     */
    public function getRolesList()
    {
        $auth  = Yii::app()->authManager;
        $roles = array();

        foreach($auth->roles as $role)
        {
            if (!Yii::app()->user->checkAccess('superadministrator') && $role->name == 'superadministrator')
                continue;

            $roles[$role->name] = $role->description;
        }

        return $roles;
    }

    /**
     * Получение списка операций
     * @return array
     */
    public function getOperationList()
    {
        $auth = Yii::app()->authManager;
        return CHtml::listData($auth->operations, 'name', 'description');
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('user', 'Не активен'),
            self::STATUS_ACTIVE   => Yii::t('user', 'Активен'),
            self::STATUS_BLOCK    => Yii::t('user', 'Заблокирован'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('user', '*неизвестно*');
    }

    /**
     * До сохранения модели
     * @return boolean
     */
    public function beforeSave()
    {
        if ($this->new_password)
            $this->password = CPasswordHelper::hashPassword($this->new_password);

        if ($this->isNewRecord)
            $this->activation_key = md5(microtime());

        return parent::beforeSave();
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return User статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

