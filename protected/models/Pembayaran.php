<?php
/**
 * Model untuk tabel pembayaran
 */
class Pembayaran extends CActiveRecord
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
        return 'pembayaran';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('pendaftaran_id, total_tagihan, total_dibayar, metode_pembayaran, petugas_id', 'required'),
            array('pendaftaran_id, petugas_id', 'numerical', 'integerOnly' => true),
            array('total_tagihan, total_dibayar, kembalian', 'numerical'),
            array('metode_pembayaran', 'length', 'max' => 50),
            array('tanggal_bayar, keterangan', 'safe'),
            array('id, pendaftaran_id, tanggal_bayar, total_tagihan, total_dibayar, kembalian, metode_pembayaran, keterangan, petugas_id, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranPasien', 'pendaftaran_id'),
            'petugas' => array(self::BELONGS_TO, 'Pegawai', 'petugas_id'),
        );
    }

    /**
     * @return array kustomisasi label atribut (nama field)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'pendaftaran_id' => 'Pendaftaran',
            'tanggal_bayar' => 'Tanggal Bayar',
            'total_tagihan' => 'Total Tagihan',
            'total_dibayar' => 'Total Dibayar',
            'kembalian' => 'Kembalian',
            'metode_pembayaran' => 'Metode Pembayaran',
            'keterangan' => 'Keterangan',
            'petugas_id' => 'Petugas',
            'created_at' => 'Waktu Dibuat',
        );
    }

    /**
     * Sebelum menyimpan, hitung kembalian dan atur tanggal bayar
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->tanggal_bayar = date('Y-m-d');
                $this->kembalian = $this->total_dibayar - $this->total_tagihan;
                if ($this->kembalian < 0) {
                    $this->kembalian = 0;
                }
            }
            return true;
        }
        return false;
    }
    
    /**
     * Mendapatkan format rupiah
     * @param float $amount jumlah yang akan diformat
     * @return string jumlah dalam format rupiah
     */
    public function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Fungsi untuk pencarian
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('tanggal_bayar', $this->tanggal_bayar, true);
        $criteria->compare('total_tagihan', $this->total_tagihan);
        $criteria->compare('total_dibayar', $this->total_dibayar);
        $criteria->compare('kembalian', $this->kembalian);
        $criteria->compare('metode_pembayaran', $this->metode_pembayaran, true);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('petugas_id', $this->petugas_id);
        $criteria->compare('created_at', $this->created_at, true);

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
}