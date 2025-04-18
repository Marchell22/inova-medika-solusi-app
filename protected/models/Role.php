<?php
// File: protected/models/Role.php

/**
 * Model untuk tabel "roles"
 *
 * @property integer $id
 * @property string $name
 */
class Role extends CActiveRecord
{
    /**
     * @return string nama tabel di database
     */
    public function tableName()
    {
        return 'role';
    }

    /**
     * @return array validasi untuk atribut
     */
    public function rules()
    {
        return array(
            array('name', 'required', 'message'=>'Nama Role tidak boleh kosong'),
            array('name', 'length', 'max'=>64, 'message'=>'Nama Role maksimal 64 karakter'),
            array('name', 'unique', 'message'=>'Nama Role ini sudah digunakan'),
            array('id, name', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array kustomisasi label atribut
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Nama Role',
        );
    }
    
    /**
     * Mencari berdasarkan kriteria
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Role the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->isNewRecord)
            {
                $this->created_at = new CDbExpression('NOW()');
            }
            $this->updated_at = new CDbExpression('NOW()');
            return true;
        }
        return false;
    }
 }