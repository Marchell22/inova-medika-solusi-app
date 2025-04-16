<?php

class m250415_121754_users extends CDbMigration
{
	public function up() {
        // Buat tabel users untuk PostgreSQL
        $this->createTable('users', array(
            'id' => 'serial PRIMARY KEY', // PostgreSQL menggunakan 'serial' untuk auto increment
            'username' => 'varchar(255) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NULL DEFAULT NULL',
        ));
        
        // Buat index untuk username
        $this->createIndex('idx_users_username', 'users', 'username', true);
        
        // Tambahkan user admin default
        $this->insert('users', array(
            'username' => 'admin',
            'password' => md5('admin123'), // Simple hashing, sebaiknya gunakan bcrypt di aplikasi produksi
        ));
    }

    public function down() {
        // Hapus tabel saat rollback
        $this->dropTable('users');
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