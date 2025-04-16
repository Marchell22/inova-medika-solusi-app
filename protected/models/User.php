<?php

/**
 * Model untuk tabel "users"
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 */
class User extends CActiveRecord
{
    /**
     * @return string nama tabel di database
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validasi untuk atribut
     */
    public function rules()
    {
        return array(
            array('username, password', 'required'),
            array('username', 'unique'),
            array('username, password', 'length', 'max'=>255),
            array('created_at, updated_at', 'safe'),
        );
    }

    /**
     * @return array relasi dengan model lain
     */
    public function relations()
    {
        return array(
            // Definisikan relasi dengan model lain jika diperlukan
        );
    }

    /**
     * @return array kustomisasi label atribut
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Tanggal Diperbarui',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * Sebelum menyimpan model, hash password jika diubah dan atur timestamp
     */
    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                $this->created_at = new CDbExpression('NOW()');
                // Hash password hanya jika baru
                $this->password = $this->hashPassword($this->password);
            }
            else if($this->password != $this->oldAttributes['password'])
            {
                // Hash password jika diubah
                $this->password = $this->hashPassword($this->password);
            }
            
            $this->updated_at = new CDbExpression('NOW()');
            return true;
        }
        return false;
    }
    
    /**
     * Hash password
     * @param string $password
     * @return string hashed password
     */
    public function hashPassword($password)
    {
        // Untuk migrasi yang ada, kita gunakan md5
        // Untuk keamanan lebih baik, gunakan password_hash() di PHP modern
        return md5($password);
    }
    
    /**
     * Verifikasi password
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return $this->password === $this->hashPassword($password);
    }
}