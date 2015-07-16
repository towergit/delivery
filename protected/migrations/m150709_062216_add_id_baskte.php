<?php

class m150709_062216_add_id_baskte extends CDbMigration
{
	public function up()
	{
            $this->dropPrimaryKey('session_id', '{{basket}}');
            $this->addColumn('{{basket}}', 'id', 'pk  FIRST');
	}

	public function down()
	{
		echo "m150709_062216_add_id_baskte does not support migration down.\n";
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