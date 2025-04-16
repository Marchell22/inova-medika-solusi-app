<?php

class m250416_100830_create_role_database extends CDbMigration
{
	public function up()
    {
        $this->createTable('role', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'updated_at' => 'datetime NOT NULL',
        ));
        
        // Add some default roles
        $this->insert('role', array(
            'name' => 'Admin',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('role', array(
            'name' => 'User',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
    }

    public function down()
    {
        $this->dropTable('role');
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