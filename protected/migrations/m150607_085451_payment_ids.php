<?php

class m150607_085451_payment_ids extends CDbMigration
{
	public function up()
	{
            $this->addColumn('{{payment}}', 'ids_list', 'varchar(150)');
	}

	public function down()
	{
		echo "m150607_085451_payment_ids does not support migration down.\n";
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