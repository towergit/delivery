<?php

class m150608_105527_update_halpe extends CDbMigration
{
	public function up()
	{
            $this->addColumn('{{object_help}}', 'sort', 'int(2)');
	}

	public function down()
	{
		echo "m150608_105527_update_halpe does not support migration down.\n";
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