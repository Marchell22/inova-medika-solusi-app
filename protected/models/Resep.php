<?php
/**
 * Model untuk tabel resep
 */
class Resep extends CActiveRecord
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
        return 'resep';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('pendaftaran_id', 'required'),
            array('pendaftaran_id, created_by', 'numerical', 'integerOnly' => true),
            array('total_harga', 'numerical'),
            array('tanggal_resep, diagnosis', 'safe'),
            array('id, pendaftaran_id, tanggal_resep, diagnosis, total_harga, created_at, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranPasien', 'pendaftaran_id'),
            'resepDetails' => array(self::HAS_MANY, 'ResepDetail', 'resep_id'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
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
            'tanggal_resep' => 'Tanggal Resep',
            'diagnosis' => 'Diagnosis',
            'total_harga' => 'Total Harga',
            'created_at' => 'Dibuat Pada',
            'created_by' => 'Dibuat Oleh',
        );
    }

    /**
     * Sebelum menyimpan, update atribut created_by dan total_harga
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::app()->user->id;
                if (empty($this->tanggal_resep)) {
                    $this->tanggal_resep = date('Y-m-d');
                }
            }
            
            // Hitung total harga jika ada detail resep
            if (!$this->isNewRecord) {
                $this->hitungTotalHarga();
            }
            
            return true;
        }
        return false;
    }
    
    /**
     * Menghitung total harga dari detail resep
     */
    public function hitungTotalHarga()
    {
        $totalHarga = 0;
        foreach ($this->resepDetails as $detail) {
            $totalHarga += $detail->subtotal;
        }
        $this->total_harga = $totalHarga;
    }
    
    /**
     * Mendapatkan format harga dalam rupiah
     * @return string harga dalam format rupiah
     */
    public function getFormattedHarga()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
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
        $criteria->compare('tanggal_resep', $this->tanggal_resep, true);
        $criteria->compare('diagnosis', $this->diagnosis, true);
        $criteria->compare('total_harga', $this->total_harga);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}