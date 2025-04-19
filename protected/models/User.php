<?php

/**
 * Model untuk tabel "users"
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property int $role_id
 * @property string $created_at
 * @property string $updated_at
 */
class User extends CActiveRecord
{
    public $password_repeat;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return array(
            // Username dan password wajib diisi
            array('username, password', 'required'),
            // Validasi role_id
            array('role_id', 'required'),
            array('role_id', 'numerical', 'integerOnly' => true),
            array('role_id', 'exist', 'attributeName' => 'id', 'className' => 'Role'),
            // Username harus unik
            array('username', 'unique'),
            // Password confirmation
            array('password_repeat', 'safe'),
            array('password', 'compare', 'compareAttribute' => 'password_repeat', 'on' => 'create'),

            // Max length validations
            array('username, password', 'length', 'max' => 255),
            // Pencarian
            array('id, username, password, created_at, updated_at, role_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Konfirmasi Password',
            'created_at' => 'Tanggal Dibuat',
            'updated_at' => 'Terakhir Diperbarui',
            'role_id' => 'Role',
        );
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
            } else {
                $this->updated_at = new CDbExpression('NOW()');
            }

            if (!empty($this->password)) {
                // Cek apakah password sudah dalam bentuk hash
                $passwordLength = strlen($this->password);
                $isMd5 = ($passwordLength === 32 && ctype_xdigit($this->password));
                
                // Jika bukan dalam bentuk hash, maka hash password
                if (!$isMd5) {
                    $this->password = $this->hashPassword($this->password);
                }
            } else if (!$this->isNewRecord) {
                // Jika update dan password kosong, ambil password lama
                $oldUser = self::model()->findByPk($this->id);
                if ($oldUser) {
                    $this->password = $oldUser->password;
                }
            }

            return true;
        }
        return false;
    }
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('role_id', $this->role_id);
        // $criteria->compare('created_at', $this->created_at, true);
        // $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    public function hashPassword($password)
    {
        return md5($password); // Sebaiknya gunakan algoritma hashing yang lebih aman seperti password_hash
    }

    public function validatePassword($password)
    {
        return $this->password === $this->hashPassword($password);
    }

    public function getRoleName()
    {
        return $this->role ? $this->role->name : 'Tidak Diketahui';
    }
}