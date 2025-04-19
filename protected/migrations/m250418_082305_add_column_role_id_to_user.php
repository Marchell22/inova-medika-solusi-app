<?php

class m250418_082305_add_column_role_id_to_user extends CDbMigration
{
	public function up()
    {
        // Tambahkan kolom role_id ke tabel users
        $this->addColumn('users', 'role_id', 'INTEGER NOT NULL DEFAULT 1');
        
        // Tambahkan foreign key
        $this->addForeignKey('fk_users_role', 'users', 'role_id', 'role', 'id', 'CASCADE', 'CASCADE');
    }
    
    public function down()
    {
        // Hapus foreign key
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