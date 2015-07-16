<?php

/**
 * Меню
 *
 * @category Model
 * @package  Module.Menu
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{menu}}':
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $description
 * @property integer $status
 * 
 * Доступные модели связей:
 * @property MenuItem[] $menuItems
 */
class Menu extends CActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{menu}}';
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
            array( 'title, code', 'required' ),
            array( 'code', 'unique', 'caseSensitive' => false ),
            array( 'title, description', 'length', 'max' => 255 ),
            array( 'status', 'numerical', 'integerOnly' => true ),
            array( 'status', 'in', 'range' => array_keys($this->statusList) ),
            array( 'id, title, code, description, status', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'menuItems' => array( self::HAS_MANY, 'MenuItem', 'menu_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('menu', 'ID'),
            'title'       => Yii::t('menu', 'Название'),
            'code'        => Yii::t('menu', 'Уникальный код'),
            'description' => Yii::t('menu', 'Описание'),
            'status'      => Yii::t('menu', 'Статус'),
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('code', $this->code);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
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
        return (isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', '*неизвестно*'));
    }

    /**
     * Получение пунктов меню
     * @param string $code уникальный код
     * @param integer $parent_id ID родителя
     * @return boolean
     */
    public function getItems($code, $parent_id = 0)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id, code';
        $criteria->condition = 'code = :code AND t.status = 1';
        $criteria->params = array( ':code' => $code );
        
        $results = self::model()
            ->with(array( 'menuItems' => array(
                'on'     => 'menuItems.parent_id = :parent_id AND menuItems.status = 1',
                'params' => array( 'parent_id' => (int) $parent_id ),
                'order'  => 'menuItems.sort ASC, menuItems.id ASC',
            )))
            ->findAll($criteria);
        
        $items = array();

        if ($results === null)
            return $items;

        $resultItems = $results[0]->menuItems;

        foreach($resultItems as $result)
        {
            $childItems = $this->getItems($code, $result->id);
            
            if ($result->href)
            {
                $url   = $result->href;
                
                if (count($childItems))
                    $url = array( 'url' => array( $url ), 'items' => $childItems );
                else
                    $url = array( 'url' => array( $url ) );
            }
            else if (count($childItems))
                $url = array( 'url' => array( 'javascript:void(0)' ), 'items' => $childItems );
            else
                $url = array();

            $target = ($result->target && $url) ? array( 'target' => $result->target ) : array();

            $items[] = array(
                'label'       => $result->title,
                'linkOptions' => $target,
                ) + $url;
        }

        return $items;
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return Menu статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

