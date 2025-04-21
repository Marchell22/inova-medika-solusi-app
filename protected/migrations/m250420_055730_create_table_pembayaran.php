<?php

class m250420_055730_create_table_pembayaran extends CDbMigration
{
	public function up()
    {
        // Mengecek jika tabel sudah ada, hapus terlebih dahulu
        if ($this->tableExists('pembayaran')) {
            $this->dropTable('pembayaran');
        }
        
        // Membuat tabel pembayaran
        $this->createTable('pembayaran', array(
            'id' => 'serial PRIMARY KEY',
            'pendaftaran_id' => 'integer NOT NULL REFERENCES pendaftaran_pasien(id) ON DELETE CASCADE',
            'tanggal_bayar' => 'date NOT NULL DEFAULT CURRENT_DATE',
            'total_tagihan' => 'decimal(15,2) NOT NULL',
            'total_dibayar' => 'decimal(15,2) NOT NULL',
            'kembalian' => 'decimal(15,2) NOT NULL',
            'metode_pembayaran' => 'varchar(50) NOT NULL',
            'keterangan' => 'text',
            'petugas_id' => 'integer NOT NULL REFERENCES pegawai(id)',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ));
        
        // Menambahkan indeks
        $this->createIndex('idx_pembayaran_pendaftaran', 'pembayaran', 'pendaftaran_id');
        
        // Menambahkan kolom status_pembayaran ke tabel pendaftaran_pasien jika belum ada
        if (!$this->columnExists('pendaftaran_pasien', 'status_pembayaran')) {
            $this->addColumn('pendaftaran_pasien', 'status_pembayaran', "varchar(20) NOT NULL DEFAULT 'Belum'");
        }
    }

    public function down()
    {
        // Hapus tabel pembayaran
        if ($this->tableExists('pembayaran')) {
            $this->dropTable('pembayaran');
        }
        
        // Hapus kolom status_pembayaran dari pendaftaran_pasien
        if ($this->columnExists('pendaftaran_pasien', 'status_pembayaran')) {
            $this->dropColumn('pendaftaran_pasien', 'status_pembayaran');
        }
    }
    
    /**
     * Helper method untuk mengecek apakah tabel sudah ada
     * @param string $tableName nama tabel yang akan dicek
     * @return boolean true jika tabel sudah ada, false jika belum
     */
    private function tableExists($tableName)
    {
        $schema = $this->getDbConnection()->getSchema();
        $tables = $schema->getTableNames();
        return in_array($tableName, $tables);
    }
    
    /**
     * Helper method untuk mengecek apakah kolom sudah ada
     * @param string $tableName nama tabel
     * @param string $columnName nama kolom
     * @return boolean true jika kolom sudah ada, false jika belum
     */
    private function columnExists($tableName, $columnName)
    {
        $table = $this->getDbConnection()->getSchema()->getTable($tableName);
        if ($table) {
            return isset($table->columns[$columnName]);
        }
        return false;
    }
}