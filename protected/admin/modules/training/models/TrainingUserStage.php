<?php

/**
 * Этапы обучения пользователей
 *
 * @category Model
 * @package  Module.Training
 * @author   Timkovsky Alexandr <timkovsky.alexandr@gmail.com>
 *
 * Доступные столбцы в таблице '{{training_user_stage}}':
 * @property integer $user_id
 * @property integer $stage_id
 * 
 * Доступные модели связей:
 * @property User[] $user
 * @property TrainingStage[] $stage
 */
class TrainingUserStage extends CActiveRecord
{
    /**
     * Название таблицы в базе данных
     * @return string
     */
    public function tableName()
    {
        return '{{training_user_stage}}';
    }

    /**
     * Правила проверки для атрибутов модели
     * @return array
     */
    public function rules()
    {
        return array(
            array( 'user_id, stage_id', 'required' ),
            array( 'user_id, stage_id', 'numerical', 'integerOnly' => true ),
            array( 'user_id, stage_id', 'length', 'max' => 11 ),
            array( 'user_id, stage_id', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * Правила связей с таблицами базы данных
     * @return array
     */
    public function relations()
    {
        return array(
            'user'  => array( self::BELONGS_TO, 'User', 'user_id' ),
            'stage' => array( self::BELONGS_TO, 'TrainingStage', 'stage_id' ),
        );
    }

    /**
     * Индивидуальные метки атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'user_id'  => Yii::t('training', 'Пользователь'),
            'stage_id' => Yii::t('training', 'Стадия обучения'),
        );
    }

    /**
     * Получает список в зависимости от условий поиска / фильтров.
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('user.username', $this->user_id, true);
        $criteria->compare('stage.name', $this->stage_id, true);

        $criteria->with = array( 'user', 'stage' );

        return new CActiveDataProvider($this,
            array(
            'criteria' => $criteria,
            'sort'     => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    /**
     * Возвращает статическую модель класса ActivRecord
     * @param string $className
     * @return TrainingUserStage статический метод класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

