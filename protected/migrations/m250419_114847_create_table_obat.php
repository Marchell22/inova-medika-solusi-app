<?php

class m250419_114847_create_table_obat extends CDbMigration
{
	public function up()
    {
        // Mengecek jika tabel sudah ada, hapus terlebih dahulu
        if ($this->tableExists('obat')) {
            $this->dropTable('obat');
        }
        
        // Membuat tabel obat dengan 4 kolom utama
        $this->createTable('obat', array(
            'id' => 'serial PRIMARY KEY',
            'kode' => 'varchar(20) NOT NULL',
            'nama' => 'varchar(100) NOT NULL',
            'harga' => 'decimal(15,2) NOT NULL DEFAULT 0',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ));
        
        // Menambahkan indeks untuk mempercepat pencarian
        $this->createIndex('idx_obat_kode', 'obat', 'kode', true);  // kode harus unik
        $this->createIndex('idx_obat_nama', 'obat', 'nama');
        
        // Menambahkan data awal
        $this->insert('obat', array(
            'kode' => 'OBT-001',
            'nama' => 'Paracetamol 500mg',
            'harga' => 5000,
        ));
        
        $this->insert('obat', array(
            'kode' => 'OBT-002',
            'nama' => 'Amoxicillin 500mg',
            'harga' => 12000,
        ));
        
        $this->insert('obat', array(
            'kode' => 'OBT-003',
            'nama' => 'Cetirizine 10mg',
            'harga' => 8000,
        ));
    }

    public function down()
    {
        if ($this->tableExists('obat')) {
            $this->dropTable('obat');
        }
    }

    private function tableExists($tableName)
    {
        $schema = $this->getDbConnection()->getSchema();
        $tables = $schema->getTableNames();
        return in_array($tableName, $tables);
    }
}