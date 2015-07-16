<?php

class m150622_064527_add_module extends CDbMigration
{
	public function up()
	{
            $this->insert('{{module}}', array(
                'name' => 'comment',
                'sort' => 6,
            ));
            
	}

	public function down()
	{
		echo "m150622_064527_add_module does not support migration down.\n";
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