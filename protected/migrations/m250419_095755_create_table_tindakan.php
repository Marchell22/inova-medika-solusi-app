<?php

class m250419_095755_create_table_tindakan extends CDbMigration
{
	public function up()
    {
        // Mengecek jika tabel sudah ada, hapus terlebih dahulu
        if ($this->tableExists('tindakan')) {
            $this->dropTable('tindakan');
        }
        
        // Membuat tabel tindakan dengan 4 kolom utama
        $this->createTable('tindakan', array(
            'id' => 'serial PRIMARY KEY',
            'kode' => 'varchar(20) NOT NULL',
            'nama' => 'varchar(100) NOT NULL',
            'tarif' => 'decimal(15,2) NOT NULL DEFAULT 0',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ));
        
        // Menambahkan indeks untuk mempercepat pencarian
        $this->createIndex('idx_tindakan_kode', 'tindakan', 'kode', true);  // kode harus unik
        
        // Menambahkan data awal
        $this->insert('tindakan', array(
            'kode' => 'TND-001',
            'nama' => 'Periksa Umum',
            'tarif' => 50000,
        ));
        
        $this->insert('tindakan', array(
            'kode' => 'TND-002',
            'nama' => 'Cek Laboratorium Dasar',
            'tarif' => 150000,
        ));
        
        $this->insert('tindakan', array(
            'kode' => 'TND-003',
            'nama' => 'Konsultasi Gizi',
            'tarif' => 75000,
        ));
    }

    public function down()
    {
        if ($this->tableExists('tindakan')) {
            $this->dropTable('tindakan');
        }
    }

    private function tableExists($tableName)
    {
        $schema = $this->getDbConnection()->getSchema();
        $tables = $schema->getTableNames();
        return in_array($tableName, $tables);
    }
}