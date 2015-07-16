<?php

class m150713_112538_add_log extends CDbMigration {

    public function SafeUp() {

        $this->dropTable('{{log}}');
        
        $this->createTable('{{log}}', array(
            'id' => 'pk',
            'user_id' => 'int',
            'operation' => 'text',
            'model' => 'text',
            'object_id' => 'int',
            'attribute' => 'text',
            'before' => 'text',
            'after' => 'text',
            'date' => 'datetime',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addColumn('{{log}}', 'content', 'text');
        $this->addColumn('{{log}}', 'note', 'text');

        $result = Yii::app()->db->createCommand('SELECT MAX(sort) as MAX FROM {{module}}');
        $res =  $result->query()->read();
        
        if(isset($res['MAX']))
            $max = ++$res['MAX'];
        else
            $max = 111;
            
        $this->insert('{{module}}', array(
           'name' => 'log',
            'sort' => $max,
        ));
    }

    public function down() {
        echo "m150713_112538_add_log does not support migration down.\n";
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
