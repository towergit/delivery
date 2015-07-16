<?php

/**
 * Cron
 *
 * @category Model
 * @package  Module.Cron
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{cron}}':
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $execution
 * @property integer $status
 * @property integer $sort
 */
class Cron extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * @var integer день недели
     */
    public $day_week;

    /**
     * @var integer месяц
     */
    public $month;

    /**
     * @var integer день
     */
    public $day;

    /**
     * @var integer часы
     */
    public $hour;

    /**
     * @var integer минуты
     */
    public $minute;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{cron}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'name, filename, day_week, month, day, hour, minute', 'required' ),
            array( 'id, name, filename, execution, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array();
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'        => Yii::t('cron', 'ID'),
            'name'      => Yii::t('cron', 'Название'),
            'filename'  => Yii::t('cron', 'Путь к файлу'),
            'execution' => Yii::t('cron', 'Выполнение'),
            'status'    => Yii::t('cron', 'Статус'),
            'sort'      => Yii::t('cron', 'Сортировка'),
            'day_week'  => Yii::t('cron', 'День недели'),
            'month'     => Yii::t('cron', 'Месяц'),
            'day'       => Yii::t('cron', 'День месяца'),
            'hour'      => Yii::t('cron', 'Часов'),
            'minute'    => Yii::t('cron', 'Минут'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('filename', $this->filename);
        $criteria->compare('execution', $this->execution);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
    }

    /**
     * Получение дней недели
     * @return array
     */
    public function getDaysWeek()
    {
        return array(
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
            7 => 'Воскресенье',
        );
    }

    /**
     * Получение месяцев
     * @return array
     */
    public function getMonths()
    {
        return array(
            1  => 'Январь',
            2  => 'Февраль',
            3  => 'Март',
            4  => 'Апрель',
            5  => 'Май',
            6  => 'Июнь',
            7  => 'Июль',
            8  => 'Август',
            9  => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        );
    }

    /**
     * Получение дней
     * @return array
     */
    public function getDays()
    {
        $array = array();

        for($i = 1; $i <= 31; $i++)
            $array[] = $i;

        return $array;
    }

    /**
     * Получение часов
     * @param boolean $every каждые
     * @return array
     */
    public function getHours($every = false)
    {
        $array = array();

        if ($every !== true)
        {
            for($i = 0; $i <= 23; $i++)
                $array[] = $i;
        }
        else
        {
            for($i = 1; $i <= 24; $i++)
                $array[] = $i;
        }

        return $array;
    }

    /**
     * Получение минут
     * @param boolean $every каждые
     * @return array
     */
    public function getMinutes($every = false)
    {
        $array = array();

        if ($every !== true)
        {
            for($i = 0; $i <= 59; $i++)
                $array[] = $i;
        }
        else
        {
            for($i = 1; $i <= 60; $i++)
                $array[] = $i;
        }

        return $array;
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('cron', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('cron', 'Активно'),
        );
    }

    /**
     * Получение статуса активности
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return (isset($data[$this->status])) ? $data[$this->status] : Yii::t('cron', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Cron статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

