<?php
/**
 * Model untuk tabel tindakan_pasien
 */
class TindakanPasien extends CActiveRecord
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
        return 'tindakan_pasien';
    }

    /**
     * @return array aturan validasi untuk atribut model
     */
    public function rules()
    {
        return array(
            array('pendaftaran_id, tindakan_id', 'required'),
            array('pendaftaran_id, tindakan_id, created_by', 'numerical', 'integerOnly' => true),
            array('catatan', 'safe'),
            array('id, pendaftaran_id, tindakan_id, catatan, created_at, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranPasien', 'pendaftaran_id'),
            'tindakan' => array(self::BELONGS_TO, 'Tindakan', 'tindakan_id'),
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
            'tindakan_id' => 'Tindakan',
            'catatan' => 'Catatan',
            'created_at' => 'Dibuat Pada',
            'created_by' => 'Dibuat Oleh',
        );
    }

    /**
     * Sebelum menyimpan, update atribut created_by
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::app()->user->id;
            }
            return true;
        }
        return false;
    }
    
    /**
     * Mendapatkan harga tindakan
     * @return float harga tindakan
     */
    public function getHarga()
    {
        if ($this->tindakan) {
            return $this->tindakan->tarif;
        }
        return 0;
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
        $criteria->compare('tindakan_id', $this->tindakan_id);
        $criteria->compare('catatan', $this->catatan, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}