<?php

class m150709_092921_update_payment extends CDbMigration
{
	public function up()
	{
            $this->addColumn('{{payment}}', 'basket_id', 'int(11) AFTER `session_id`');
	}

	public function down()
	{
		echo "m150709_092921_update_payment does not support migration down.\n";
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