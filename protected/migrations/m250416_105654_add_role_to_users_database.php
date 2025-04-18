<?php

class m250416_105654_add_role_to_users_database extends CDbMigration
{
	public function up()
	{
		$this->addColumn('users', 'role_id', 'integer');
        
        // Buat foreign key
		$this->addForeignKey('fk_users_role', 'users', 'role_id', 'role', 'id', 'SET NULL', 'CASCADE');
		   
	}

	public function down()
	{
		$this->dropForeignKey('fk_users_role', 'users');
        
        // Hapus kolom role_id
        $this->dropColumn('users', 'role_id');
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