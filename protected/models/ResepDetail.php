<?php
/**
 * Model untuk tabel resep_detail
 */
class ResepDetail extends CActiveRecord
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
        return 'resep_detail';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('resep_id, obat_id, jumlah', 'required'),
            array('resep_id, obat_id, jumlah', 'numerical', 'integerOnly' => true),
            array('jumlah', 'numerical', 'min' => 1),
            array('subtotal', 'numerical'),
            array('dosis', 'length', 'max' => 100),
            array('keterangan', 'safe'),
            array('id, resep_id, obat_id, jumlah, dosis, keterangan, subtotal', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            'resep' => array(self::BELONGS_TO, 'Resep', 'resep_id'),
            'obat' => array(self::BELONGS_TO, 'Obat', 'obat_id'),
        );
    }

    /**
     * @return array kustomisasi label atribut (nama field)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'resep_id' => 'Resep',
            'obat_id' => 'Obat',
            'jumlah' => 'Jumlah',
            'dosis' => 'Dosis',
            'keterangan' => 'Keterangan',
            'subtotal' => 'Subtotal',
        );
    }

    /**
     * Sebelum menyimpan, hitung subtotal
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            // Hitung subtotal
            if ($this->obat && $this->jumlah > 0) {
                $this->subtotal = $this->obat->harga * $this->jumlah;
            }
            return true;
        }
        return false;
    }
    
    /**
     * Setelah menyimpan, update total harga di resep
     */
    protected function afterSave()
    {
        parent::afterSave();
        
        // Update total harga di resep
        if ($this->resep) {
            $this->resep->hitungTotalHarga();
            $this->resep->save(false);
        }
    }
    
    /**
     * Setelah menghapus, update total harga di resep
     */
    protected function afterDelete()
    {
        parent::afterDelete();
        
        // Update total harga di resep
        if ($this->resep) {
            $this->resep->hitungTotalHarga();
            $this->resep->save(false);
        }
    }
    
    /**
     * Mendapatkan format subtotal dalam rupiah
     * @return string subtotal dalam format rupiah
     */
    public function getFormattedSubtotal()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Fungsi untuk pencarian
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('resep_id', $this->resep_id);
        $criteria->compare('obat_id', $this->obat_id);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('dosis', $this->dosis, true);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('subtotal', $this->subtotal);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}