<?php
/**
 * Model untuk tabel pegawai
 */
class Pegawai extends CActiveRecord
{
    /**
     * Mengembalikan nama tabel static
     * @return string nama tabel
     */
    public function tableName()
    {
        return 'pegawai';
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
            array('nip, nama', 'required'),
            array('nip', 'length', 'max' => 20),
            array('nama', 'length', 'max' => 100),
            array('posisi', 'length', 'max' => 50),
            array('status', 'length', 'max' => 20),
            array('status', 'default', 'value' => 'Aktif'),
            // Perbaikan aturan validasi unique
            array('nip', 'uniqueNipValidator'),
            array('id, nip, nama, posisi, status, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Validator kustom untuk memeriksa keunikan NIP
     * @param string $attribute atribut yang divalidasi
     * @param array $params parameter tambahan
     */
    public function uniqueNipValidator($attribute, $params)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'nip=:nip';
        $criteria->params = array(':nip' => $this->$attribute);
        
        // Jika ini record yang sudah ada (update), kecualikan ID saat ini
        if (!$this->isNewRecord) {
            $criteria->condition .= ' AND id!=:id';
            $criteria->params[':id'] = $this->id;
        }
        
        $count = self::model()->count($criteria);
        
        if ($count > 0) {
            $this->addError($attribute, 'NIP "'.$this->$attribute.'" sudah digunakan.');
        }
    }

    /**
     * @return array relasi antar tabel
     */
    public function relations()
    {
        return array(
            // Contoh relasi jika ada tabel lain yang berhubungan dengan pegawai
        );
    }

    /**
     * @return array kustomisasi label atribut (nama field)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'nip' => 'NIP',
            'nama' => 'Nama Lengkap',
            'posisi' => 'Posisi',
            'status' => 'Status',
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
        $criteria->compare('nip', $this->nip, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('posisi', $this->posisi, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id ASC',
            ),
            'pagination' => array(
                'pageSize' => 10, // Menampilkan 10 item per halaman
            ),
        ));
    }

    /**
     * Sebelum menyimpan, update tanggal created_at
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
            }
            return true;
        }
        return false;
    }

    /**
     * Mendapatkan daftar opsi untuk status
     * @return array
     */
    public static function getStatusOptions()
    {
        return array(
            'Aktif' => 'Aktif',
            'Cuti' => 'Cuti',
            'Keluar' => 'Keluar',
            'Pensiun' => 'Pensiun',
        );
    }
    
    /**
     * Fungsi untuk debugging NIP yang sudah ada
     * @return array daftar NIP yang sudah ada di database
     */
    public static function getExistingNips()
    {
        $result = array();
        $models = self::model()->findAll(array('select'=>'nip'));
        foreach ($models as $model) {
            $result[] = $model->nip;
        }
        return $result;
    }
}