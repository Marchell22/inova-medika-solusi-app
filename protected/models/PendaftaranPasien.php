<?php
/**
 * Model untuk tabel pendaftaran_pasien
 */
class PendaftaranPasien extends CActiveRecord
{
    /**
     * @return string nama class model ini
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string nama tabel
     */
    public function tableName()
    {
        return 'pendaftaran_pasien';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('nama_pasien, tanggal_lahir, jenis_kelamin, no_telepon, wilayah_id, alamat_lengkap, jenis_kunjungan, dokter_id, keluhan', 'required'),
            array('no_registrasi', 'unique', 'message' => 'Nomor registrasi "{value}" sudah digunakan.'),
            array('nama_pasien', 'length', 'max' => 100),
            array('jenis_kelamin', 'in', 'range' => array('Laki-laki', 'Perempuan')),
            array('no_identitas', 'length', 'max' => 20),
            array('no_telepon', 'length', 'max' => 15),
            array('jenis_kunjungan', 'in', 'range' => array('Rawat Jalan', 'Rawat Inap', 'Gawat Darurat')),
            array('status_kunjungan', 'in', 'range' => array('Menunggu', 'Proses', 'Selesai')),
            array('wilayah_id, dokter_id', 'numerical', 'integerOnly' => true),
            array('tanggal_pendaftaran, waktu_pendaftaran, updated_at', 'safe'),
            array('id, no_registrasi, tanggal_pendaftaran, waktu_pendaftaran, nama_pasien, tanggal_lahir, jenis_kelamin, no_identitas, no_telepon, wilayah_id, alamat_lengkap, jenis_kunjungan, dokter_id, keluhan, status_kunjungan, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            'wilayah' => array(self::BELONGS_TO, 'Wilayah', 'wilayah_id'),
            'dokter' => array(self::BELONGS_TO, 'Pegawai', 'dokter_id'),
        );
    }

    /**
     * @return array kustomisasi label atribut (nama field)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'no_registrasi' => 'No. Registrasi',
            'tanggal_pendaftaran' => 'Tanggal Pendaftaran',
            'waktu_pendaftaran' => 'Waktu Pendaftaran',
            'nama_pasien' => 'Nama Pasien',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'no_identitas' => 'No. Identitas',
            'no_telepon' => 'No. Telepon',
            'wilayah_id' => 'Wilayah',
            'alamat_lengkap' => 'Alamat Lengkap',
            'jenis_kunjungan' => 'Jenis Kunjungan',
            'dokter_id' => 'Dokter',
            'keluhan' => 'Keluhan',
            'status_kunjungan' => 'Status Kunjungan',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diperbarui',
        );
    }

    /**
     * Sebelum menyimpan, update atribut waktu
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            // Jika record baru, generate nomor registrasi
            if ($this->isNewRecord) {
                if (empty($this->no_registrasi)) {
                    $this->no_registrasi = $this->generateRegistrationNumber();
                }
                if (empty($this->tanggal_pendaftaran)) {
                    $this->tanggal_pendaftaran = date('Y-m-d');
                }
                if (empty($this->waktu_pendaftaran)) {
                    $this->waktu_pendaftaran = date('H:i:s');
                }
                if (empty($this->status_kunjungan)) {
                    $this->status_kunjungan = 'Menunggu';
                }
            } else {
                $this->updated_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

    /**
     * Generate nomor registrasi
     */
    protected function generateRegistrationNumber()
    {
        $date = date('Ymd');
        $lastReg = self::model()->find(array(
            'condition' => 'no_registrasi LIKE :prefix',
            'params' => array(':prefix' => "REG-$date%"),
            'order' => 'id DESC',
        ));
        
        if ($lastReg) {
            $lastNumber = (int)substr($lastReg->no_registrasi, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        return "REG-$date-" . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Fungsi untuk pencarian
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('no_registrasi', $this->no_registrasi, true);
        $criteria->compare('tanggal_pendaftaran', $this->tanggal_pendaftaran, true);
        $criteria->compare('waktu_pendaftaran', $this->waktu_pendaftaran, true);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin, true);
        $criteria->compare('no_identitas', $this->no_identitas, true);
        $criteria->compare('no_telepon', $this->no_telepon, true);
        $criteria->compare('wilayah_id', $this->wilayah_id);
        $criteria->compare('alamat_lengkap', $this->alamat_lengkap, true);
        $criteria->compare('jenis_kunjungan', $this->jenis_kunjungan, true);
        $criteria->compare('dokter_id', $this->dokter_id);
        $criteria->compare('keluhan', $this->keluhan, true);
        $criteria->compare('status_kunjungan', $this->status_kunjungan, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Mendapatkan daftar opsi untuk jenis kelamin
     * @return array
     */
    public static function getJenisKelaminOptions()
    {
        return array(
            'Laki-laki' => 'Laki-laki',
            'Perempuan' => 'Perempuan',
        );
    }

    /**
     * Mendapatkan daftar opsi untuk jenis kunjungan
     * @return array
     */
    public static function getJenisKunjunganOptions()
    {
        return array(
            'Rawat Jalan' => 'Rawat Jalan',
            'Rawat Inap' => 'Rawat Inap',
            'Gawat Darurat' => 'Gawat Darurat',
        );
    }

    /**
     * Mendapatkan daftar opsi untuk status kunjungan
     * @return array
     */
    public static function getStatusKunjunganOptions()
    {
        return array(
            'Menunggu' => 'Menunggu',
            'Proses' => 'Proses',
            'Selesai' => 'Selesai',
        );
    }
}