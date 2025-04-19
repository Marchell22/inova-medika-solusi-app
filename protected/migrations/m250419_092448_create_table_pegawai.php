<?php

class m250419_092448_create_table_pegawai extends CDbMigration
{
	public function up()
    {
        // Mengecek jika tabel sudah ada, hapus terlebih dahulu
        if ($this->tableExists('pegawai')) {
            $this->dropTable('pegawai');
        }
        
        // Membuat tabel pegawai dengan 5 kolom utama saja
        $this->createTable('pegawai', array(
            'id' => 'serial PRIMARY KEY',
            'nip' => 'varchar(20) NOT NULL',
            'nama' => 'varchar(100) NOT NULL',
            'posisi' => 'varchar(50)',
            'status' => 'varchar(20) DEFAULT \'Aktif\'',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ));
        
        // Menambahkan indeks untuk mempercepat pencarian
        $this->createIndex('idx_pegawai_nip', 'pegawai', 'nip', true);  // nip harus unik
        $this->createIndex('idx_pegawai_nama', 'pegawai', 'nama');
        
        // Menambahkan data awal (contoh pegawai)
        $this->insert('pegawai', array(
            'nip' => 'PGW-001',
            'nama' => 'Dr. Budi Santoso',
            'posisi' => 'Dokter Umum',
            'status' => 'Aktif',
            'created_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('pegawai', array(
            'nip' => 'PGW-002',
            'nama' => 'Siti Rahayu',
            'posisi' => 'Perawat',
            'status' => 'Aktif',
            'created_at' => new CDbExpression('NOW()'),
        ));
        
        // Menambahkan comment pada tabel
        $this->execute("COMMENT ON TABLE pegawai IS 'Tabel untuk menyimpan data pegawai klinik'");
    }

    public function down()
    {
        // Menghapus tabel jika melakukan rollback migrasi
        if ($this->tableExists('pegawai')) {
            $this->dropTable('pegawai');
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

}