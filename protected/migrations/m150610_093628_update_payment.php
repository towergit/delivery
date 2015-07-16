<?php

class m150610_093628_update_payment extends CDbMigration
{
	public function up()
	{
            $this->addColumn('{{payment}}', 'date', 'timestamp');
	}

	public function down()
	{
		echo "m150610_093628_update_payment does not support migration down.\n";
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