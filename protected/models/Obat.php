<?php
/**
 * Model untuk tabel obat
 */
class Obat extends CActiveRecord
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
        return 'obat';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('kode, nama, harga', 'required'),
            array('kode', 'length', 'max' => 20),
            array('nama', 'length', 'max' => 100),
            array('harga', 'numerical', 'min' => 0),
            array('kode', 'unique', 'message' => 'Kode obat "{value}" sudah digunakan.'),
            array('id, kode, nama, harga, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array kustomisasi label atribut (nama field)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama Obat',
            'harga' => 'Harga (Rp)',
            'created_at' => 'Tanggal Dibuat',
        );
    }

    /**
     * Fungsi untuk pencarian
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('kode', $this->kode, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('harga', $this->harga);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'kode ASC',
            ),
            'pagination' => array(
                'pageSize' => 10, // Menampilkan 10 item per halaman
            ),
        ));
    }
    
    /**
     * Format harga untuk ditampilkan
     * @return string harga dalam format rupiah
     */
    public function getFormattedHarga()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}