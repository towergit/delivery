<?php

class m150605_071449_interkassa extends CDbMigration
{
	public function up()
	{
                $this->insert('{{payment_system}}', array(
                    'title' => 'Interkassa',
                    'code' => 'interkassa',
                    'site' => 'https://www.interkassa.com',
                    'type' => '1',
                    'status' => '1',
                    'debug' => '0',
                    'sort' => '0'
		));
            
	}

	public function down()
	{
		echo "m150605_071449_interkassa does not support migration down.\n";
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