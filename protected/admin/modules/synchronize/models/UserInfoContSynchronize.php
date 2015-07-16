<?php


class UserInfoContSynchronize extends CActiveRecord {
    public function getDbConnection() {
        return Yii::app()->db2;
    }
    public function tableName()
    {
        return '{{users_info_cont}}';
    }

	public static function model($className = __CLASS__) 	{
		return parent::model($className);
	}
}

