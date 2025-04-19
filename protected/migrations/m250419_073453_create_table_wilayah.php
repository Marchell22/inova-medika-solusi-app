<?php

class m250419_073453_create_table_wilayah extends CDbMigration
{
	public function up()
    {
        // Mengecek jika tabel sudah ada, hapus terlebih dahulu
        if ($this->tableExists('wilayah')) {
            $this->dropTable('wilayah');
        }
        
        // Membuat tabel wilayah
        $this->createTable('wilayah', array(
            'id' => 'serial PRIMARY KEY',  // Menggunakan serial untuk auto-increment di PostgreSQL
            'kode' => 'varchar(10) NOT NULL',
            'nama_wilayah' => 'varchar(100) NOT NULL', // kolom wilayah tunggal untuk kabupaten/provinsi
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ));
        
        // Menambahkan indeks untuk mempercepat pencarian
        $this->createIndex('idx_wilayah_kode', 'wilayah', 'kode', true);  // kode harus unik
        
        // Menambahkan data awal (contoh wilayah)
        $this->insert('wilayah', array(
            'kode' => 'W-01',
            'nama_wilayah' => 'DKI Jakarta',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-02',
            'nama_wilayah' => 'Jawa Barat',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-03',
            'nama_wilayah' => 'Jawa Tengah',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-04',
            'nama_wilayah' => 'Jawa Timur',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-05',
            'nama_wilayah' => 'Bali',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-06',
            'nama_wilayah' => 'Sumatera Utara',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-07',
            'nama_wilayah' => 'Sumatera Barat',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-08',
            'nama_wilayah' => 'Sumatera Selatan',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-09',
            'nama_wilayah' => 'Kalimantan Barat',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        $this->insert('wilayah', array(
            'kode' => 'W-10',
            'nama_wilayah' => 'Kalimantan Timur',
            'created_at' => new CDbExpression('NOW()'),
            'updated_at' => new CDbExpression('NOW()'),
        ));
        
        // Menambahkan comment pada tabel
        $this->execute("COMMENT ON TABLE wilayah IS 'Tabel untuk menyimpan data wilayah seperti provinsi dan kabupaten'");
        $this->execute("COMMENT ON COLUMN wilayah.id IS 'Primary key'");
        $this->execute("COMMENT ON COLUMN wilayah.kode IS 'Kode unik wilayah'");
        $this->execute("COMMENT ON COLUMN wilayah.nama_wilayah IS 'Nama wilayah (provinsi/kabupaten)'");
        $this->execute("COMMENT ON COLUMN wilayah.created_at IS 'Waktu data dibuat'");
        $this->execute("COMMENT ON COLUMN wilayah.updated_at IS 'Waktu terakhir data diperbarui'");
    }

    public function down()
    {
        // Menghapus tabel jika melakukan rollback migrasi
        if ($this->tableExists('wilayah')) {
            $this->dropTable('wilayah');
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