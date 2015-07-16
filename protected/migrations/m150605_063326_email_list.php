<?php

class m150605_063326_email_list extends CDbMigration
{
	public function up()
	{
            $arStucrt = array(
                  'id'          => 'pk',
                  'name'         => "varchar(100) DEFAULT NULL COMMENT 'Имя'",
                  'email'         => "varchar(100) DEFAULT NULL COMMENT 'емейл'",
                  'date'       => "timestamp DEFAULT  CURRENT_TIMESTAMP COMMENT 'время'",
                );
            $this->createTable('{{addition_emails_list}}', $arStucrt );
	}

	public function down()
	{
		$this->dropTable('{{addition_emails_list}}');
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