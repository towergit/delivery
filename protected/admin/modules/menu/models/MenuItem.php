<?php

/**
 * Пункты меню
 *
 * @category Model
 * @package  Module.Menu
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{menu_item}}':
 * @property integer $id
 * @property integer $parent_id
 * @property integer $menu_id
 * @property string $title
 * @property string $href
 * @property string $target
 * @property integer $status
 * @property integer $sort
 * 
 * Доступные модели связей:
 * @property Menu[] $menu
 */
class MenuItem extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{menu_item}}';
    }

    /**
     * Поведения
     * @return array
     */
    public function behaviors()
    {
        return array();
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'parent_id, menu_id, title', 'required' ),
            array( 'status, sort', 'numerical', 'integerOnly' => true ),
            array( 'parent_id, menu_id, target', 'length', 'max' => 11 ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'title, href', 'length', 'max' => 255 ),
            array( 'id, parent_id, menu_id, title, href, target, status, sort', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'menu' => array( self::BELONGS_TO, 'Menu', 'menu_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'        => Yii::t('menu', 'ID'),
            'parent_id' => Yii::t('menu', 'Родитель'),
            'menu_id'   => Yii::t('menu', 'Меню'),
            'title'     => Yii::t('menu', 'Название'),
            'href'      => Yii::t('menu', 'Адрес'),
            'target'    => Yii::t('menu', 'Атрибут target'),
            'status'    => Yii::t('menu', 'Статус'),
            'sort'      => Yii::t('menu', 'Сортировка'),
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
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('href', $this->href);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id',
            ),
        ));
    }

    /**
     * Получение списка меню
     * @return array
     */
    public function getMenuList()
    {
        $models = Menu::model()->findAll(array( 'select' => 'id, title' ));
        return CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение списка родителей
     * @return array
     */
    public function getParentList()
    {
        $criteria         = new CDbCriteria;
        $criteria->select = 'id, title';
        $criteria->compare('id', '<>' . $this->id);

        $models = $this->findAll($criteria);

        return array( 0 => Yii::t('menu', 'Корень меню') ) + CHtml::listData($models, 'id', 'title');
    }

    /**
     * Получение родителя
     * @return string
     */
    public function getParent()
    {
        $data = $this->parentList;
        return isset($data[$this->parent_id]) ? $data[$this->parent_id] : Yii::t('menu', '*неизвестно*');
    }

    /**
     * Получение дерева родителей
     * @return array
     */
    public function getParentTree()
    {
        return array( 0 => Yii::t('menu', 'Корень меню') ) + $this->getParentTreeIterator();
    }

    /**
     * Получение дерева родительских пунктов меню
     * @param integer $parent_id ID родителя
     * @param integer $level уровень
     * @return array
     */
    public function getParentTreeIterator($parent_id = 0, $level = 1)
    {
        $criteria            = new CDbCriteria;
        $criteria->condition = 'parent_id = :parent_id AND id <> :id';
        $criteria->params    = array( ':parent_id' => (int) $parent_id, ':id' => (int) $this->id );
        $criteria->order     = 'sort';

        $results = $this->findAll($criteria);

        $items = array();

        if (empty($results))
            return $items;

        foreach($results as $result)
        {
            $childItems = $this->getParentTreeIterator($result->id, ($level + 1));
            $items += array( $result->id => str_repeat('&nbsp;&nbsp;', $level) . $result->title ) + $childItems;
        }

        return $items;
    }

    /**
     * Получение списка атрибута target
     * @return array
     */
    public function getTargetList()
    {
        return array(
            '_self'   => Yii::t('menu', 'Открывать в текущем окне'),
            '_blank'  => Yii::t('menu', 'Открывать в новом окне'),
            '_parent' => Yii::t('menu', 'Открывать во фрейме'),
        );
    }

    /**
     * Получение списка статусов
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_INACTIVE => Yii::t('menu', 'Не активно'),
            self::STATUS_ACTIVE   => Yii::t('menu', 'Активно'),
        );
    }

    /**
     * Получение статуса
     * @return string
     */
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', '*неизвестно*');
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return MenuItem статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

