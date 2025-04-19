<?php
/**
 * Model untuk tabel tindakan
 */
class Tindakan extends CActiveRecord
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
        return 'tindakan';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('kode, nama, tarif', 'required'),
            array('kode', 'length', 'max' => 20),
            array('nama', 'length', 'max' => 100),
            array('tarif', 'numerical', 'min' => 0),
            array('kode', 'unique', 'message' => 'Kode tindakan "{value}" sudah digunakan.'),
            array('id, kode, nama, tarif, created_at', 'safe', 'on' => 'search'),
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
            'nama' => 'Nama Tindakan',
            'tarif' => 'Tarif (Rp)',
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
        $criteria->compare('tarif', $this->tarif);
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
     * Format tarif untuk ditampilkan
     * @return string tarif dalam format rupiah
     */
    public function getFormattedTarif()
    {
        return 'Rp ' . number_format($this->tarif, 0, ',', '.');
    }
}