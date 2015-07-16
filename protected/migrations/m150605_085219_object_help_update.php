<?php

class m150605_085219_object_help_update extends CDbMigration
{
	public function safeUp()
	{
            $this->update('{{payment_system}}', array(
              'status' => 0), 
              'code = \'yandex\''
            );
            
            $this->addColumn('{{object_help}}', 'uniqid', 'varchar(50)');
	}

	public function down()
	{
		echo "m150605_085219_object_help_update does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}