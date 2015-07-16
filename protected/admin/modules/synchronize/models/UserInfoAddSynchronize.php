<?php


class UserInfoAddSynchronize extends CActiveRecord {
    public function getDbConnection() {
        return Yii::app()->db2;
        // другие методы
    }
    public function tableName()
    {
        return '{{users_info_add}}';
    }


	public static function model($className = __CLASS__) 	{
		return parent::model($className);
	}

}

