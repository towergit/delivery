<?php

class UserInfoSynchronize extends CActiveRecord
{
    public function getDbConnection()
    {
        return Yii::app()->db2;
    }

    public function tableName()
    {
        return '{{users_info}}';
    }

    public function relations()
    {
        return array(
            'address' => array( self::HAS_ONE, 'UserInfoAddSynchronize', 'id_user' ),
            'contact' => array( self::HAS_ONE, 'UserInfoContSynchronize', 'id_user' ),
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}

