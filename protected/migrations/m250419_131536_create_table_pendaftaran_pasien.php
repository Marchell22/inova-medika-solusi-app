<?php

class m250419_131536_create_table_pendaftaran_pasien extends CDbMigration
{
	public function up()
    {
        // Mengecek jika tabel sudah ada, hapus terlebih dahulu
        if ($this->tableExists('pendaftaran_pasien')) {
            $this->dropTable('pendaftaran_pasien');
        }
        
        // Membuat tabel pendaftaran_pasien
        $this->createTable('pendaftaran_pasien', array(
            'id' => 'serial PRIMARY KEY',
            'no_registrasi' => 'varchar(20) NOT NULL UNIQUE',
            'tanggal_pendaftaran' => 'date NOT NULL DEFAULT CURRENT_DATE',
            'waktu_pendaftaran' => 'time NOT NULL DEFAULT CURRENT_TIME',
            
            // Data Pasien
            'nama_pasien' => 'varchar(100) NOT NULL',
            'tanggal_lahir' => 'date NOT NULL',
            'jenis_kelamin' => 'varchar(10) NOT NULL',
            'no_identitas' => 'varchar(20)',
            'no_telepon' => 'varchar(15) NOT NULL',
            'wilayah_id' => 'integer REFERENCES wilayah(id)',
            'alamat_lengkap' => 'text NOT NULL',
            
            // Data Kunjungan
            'jenis_kunjungan' => 'varchar(20) NOT NULL',
            'dokter_id' => 'integer REFERENCES pegawai(id)',
            'keluhan' => 'text',
            
            // Status dan Timestamp
            'status_kunjungan' => 'varchar(20) NOT NULL DEFAULT \'Menunggu\'',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp',
        ));
        
        // Menambahkan indeks untuk mempercepat pencarian
        $this->createIndex('idx_pendaftaran_no_registrasi', 'pendaftaran_pasien', 'no_registrasi', true);
        $this->createIndex('idx_pendaftaran_nama_pasien', 'pendaftaran_pasien', 'nama_pasien');
        $this->createIndex('idx_pendaftaran_dokter_id', 'pendaftaran_pasien', 'dokter_id');
        
        // Menambahkan data awal
        $this->insert('pendaftaran_pasien', array(
            'no_registrasi' => 'REG-001',
            'nama_pasien' => 'Budi Santoso',
            'tanggal_lahir' => '1985-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'no_identitas' => '3173051505850001',
            'no_telepon' => '081234567890',
            'wilayah_id' => 1, // Pastikan wilayah dengan ID 1 sudah ada
            'alamat_lengkap' => 'Jl. Kemanggisan No. 10',
            'jenis_kunjungan' => 'Rawat Jalan',
            'dokter_id' => 1, // Pastikan pegawai dengan ID 1 sudah ada
            'keluhan' => 'Demam dan batuk',
            'status_kunjungan' => 'Menunggu',
        ));
        
        $this->insert('pendaftaran_pasien', array(
            'no_registrasi' => 'REG-002',
            'nama_pasien' => 'Siti Nurhaliza',
            'tanggal_lahir' => '1990-08-22',
            'jenis_kelamin' => 'Perempuan',
            'no_identitas' => '3173052208900003',
            'no_telepon' => '087654321098',
            'wilayah_id' => 2, // Pastikan wilayah dengan ID 2 sudah ada
            'alamat_lengkap' => 'Jl. Dipatiukur No. 35',
            'jenis_kunjungan' => 'Gawat Darurat',
            'dokter_id' => 2, // Pastikan pegawai dengan ID 2 sudah ada
            'keluhan' => 'Nyeri perut akut',
            'status_kunjungan' => 'Proses',
            'updated_at' => date('Y-m-d H:i:s'),
        ));
    }

    public function down()
    {
        if ($this->tableExists('pendaftaran_pasien')) {
            $this->dropTable('pendaftaran_pasien');
        }
    }

    private function tableExists($tableName)
    {
        $schema = $this->getDbConnection()->getSchema();
        $tables = $schema->getTableNames();
        return in_array($tableName, $tables);
    }
}