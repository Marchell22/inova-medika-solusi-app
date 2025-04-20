<?php

class m250419_160208_create_table_transaksi_tindakan_obat_table extends CDbMigration
{
	public function up()
    {
        // Buat tabel tindakan_pasien
        if (!$this->tableExists('tindakan_pasien')) {
            $this->createTable('tindakan_pasien', array(
                'id' => 'serial PRIMARY KEY',
                'pendaftaran_id' => 'integer NOT NULL REFERENCES pendaftaran_pasien(id) ON DELETE CASCADE',
                'tindakan_id' => 'integer NOT NULL REFERENCES tindakan(id)',
                'catatan' => 'text',
                'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'created_by' => 'integer',
            ));
            
            $this->createIndex('idx_tindakan_pasien_pendaftaran', 'tindakan_pasien', 'pendaftaran_id');
            $this->createIndex('idx_tindakan_pasien_tindakan', 'tindakan_pasien', 'tindakan_id');
        }
        
        // Buat tabel resep
        if (!$this->tableExists('resep')) {
            $this->createTable('resep', array(
                'id' => 'serial PRIMARY KEY',
                'pendaftaran_id' => 'integer NOT NULL REFERENCES pendaftaran_pasien(id) ON DELETE CASCADE',
                'tanggal_resep' => 'date NOT NULL DEFAULT CURRENT_DATE',
                'diagnosis' => 'text',
                'total_harga' => 'decimal(15,2) NOT NULL DEFAULT 0',
                'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'created_by' => 'integer',
            ));
            
            $this->createIndex('idx_resep_pendaftaran', 'resep', 'pendaftaran_id');
            $this->createIndex('idx_resep_tanggal', 'resep', 'tanggal_resep');
        }
        
        // Buat tabel resep_detail
        if (!$this->tableExists('resep_detail')) {
            $this->createTable('resep_detail', array(
                'id' => 'serial PRIMARY KEY',
                'resep_id' => 'integer NOT NULL REFERENCES resep(id) ON DELETE CASCADE',
                'obat_id' => 'integer NOT NULL REFERENCES obat(id)',
                'jumlah' => 'integer NOT NULL DEFAULT 1',
                'dosis' => 'varchar(100)',
                'keterangan' => 'text',
                'subtotal' => 'decimal(15,2) NOT NULL DEFAULT 0',
            ));
            
            $this->createIndex('idx_resep_detail_resep', 'resep_detail', 'resep_id');
            $this->createIndex('idx_resep_detail_obat', 'resep_detail', 'obat_id');
        }
        
        // Tambahkan kolom total_biaya_tindakan dan status_tindakan_resep ke tabel pendaftaran_pasien
        if ($this->tableExists('pendaftaran_pasien')) {
            if (!$this->columnExists('pendaftaran_pasien', 'total_biaya_tindakan')) {
                $this->addColumn('pendaftaran_pasien', 'total_biaya_tindakan', 'decimal(15,2) DEFAULT 0');
            }
            
            if (!$this->columnExists('pendaftaran_pasien', 'total_biaya_resep')) {
                $this->addColumn('pendaftaran_pasien', 'total_biaya_resep', 'decimal(15,2) DEFAULT 0');
            }
            
            if (!$this->columnExists('pendaftaran_pasien', 'total_biaya')) {
                $this->addColumn('pendaftaran_pasien', 'total_biaya', 'decimal(15,2) DEFAULT 0');
            }
            
            if (!$this->columnExists('pendaftaran_pasien', 'status_tindakan_resep')) {
                $this->addColumn('pendaftaran_pasien', 'status_tindakan_resep', 'varchar(20) DEFAULT \'Belum\'');
            }
        }
    }

    public function down()
    {
        // Hapus kolom dari tabel pendaftaran_pasien
        if ($this->tableExists('pendaftaran_pasien')) {
            if ($this->columnExists('pendaftaran_pasien', 'total_biaya_tindakan')) {
                $this->dropColumn('pendaftaran_pasien', 'total_biaya_tindakan');
            }
            
            if ($this->columnExists('pendaftaran_pasien', 'total_biaya_resep')) {
                $this->dropColumn('pendaftaran_pasien', 'total_biaya_resep');
            }
            
            if ($this->columnExists('pendaftaran_pasien', 'total_biaya')) {
                $this->dropColumn('pendaftaran_pasien', 'total_biaya');
            }
            
            if ($this->columnExists('pendaftaran_pasien', 'status_tindakan_resep')) {
                $this->dropColumn('pendaftaran_pasien', 'status_tindakan_resep');
            }
        }
        
        // Hapus tabel resep_detail
        if ($this->tableExists('resep_detail')) {
            $this->dropTable('resep_detail');
        }
        
        // Hapus tabel resep
        if ($this->tableExists('resep')) {
            $this->dropTable('resep');
        }
        
        // Hapus tabel tindakan_pasien
        if ($this->tableExists('tindakan_pasien')) {
            $this->dropTable('tindakan_pasien');
        }
    }

    private function tableExists($tableName)
    {
        $schema = $this->getDbConnection()->getSchema();
        $tables = $schema->getTableNames();
        return in_array($tableName, $tables);
    }
    
    private function columnExists($tableName, $columnName)
    {
        $schema = $this->getDbConnection()->getSchema();
        $columns = $schema->getTable($tableName)->getColumnNames();
        return in_array($columnName, $columns);
    }
}