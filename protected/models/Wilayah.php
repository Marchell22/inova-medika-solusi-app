<?php
/**
 * Model untuk tabel wilayah
 */
class Wilayah extends CActiveRecord
{
    /**
     * Mengembalikan nama tabel static
     * @return string nama tabel
     */
    public function tableName()
    {
        return 'wilayah';
    }

    /**
     * @return string nama class model ini
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('kode, nama_wilayah', 'required'),
            array('kode', 'length', 'max' => 10),
            array('nama_wilayah', 'length', 'max' => 100),
            array('kode', 'unique'),
            array('id, kode, nama_wilayah, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            // Contoh relasi jika ada tabel lain yang berhubungan dengan wilayah
            // 'pasien' => array(self::HAS_MANY, 'Pasien', 'wilayah_id'),
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
            'nama_wilayah' => 'Wilayah',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diperbarui',
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
        $criteria->compare('nama_wilayah', $this->nama_wilayah, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id ASC',
            ),
        ));
    }

    /**
     * Sebelum menyimpan, update tanggal updated_at
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }
}