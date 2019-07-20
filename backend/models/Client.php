<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $ic_no
 * @property string $address
 * @property string $postcode
 * @property int $city
 * @property int $state_id
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property string $occupation
 * @property int $category
 * @property int $status
 * @property string $date_drop
 * @property string $inactive_remark
 * @property int $prospect_id
 * @property string $updated_at
 * @property string $created_at
 * @property int $trash
 *
 * @property State $state
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'created_at'], 'required'],
            [['city', 'state_id', 'category', 'status', 'prospect_id', 'trash'], 'integer'],
            [['date_drop', 'updated_at', 'created_at'], 'safe'],
            [['inactive_remark'], 'string'],
            [['name', 'address'], 'string', 'max' => 255],
            [['ic_no', 'phone1', 'phone2'], 'string', 'max' => 12],
            [['postcode'], 'string', 'max' => 6],
            [['email', 'occupation'], 'string', 'max' => 200],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::className(), 'targetAttribute' => ['state_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ic_no' => 'Ic No',
            'address' => 'Address',
            'postcode' => 'Postcode',
            'city' => 'City',
            'state_id' => 'State ID',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'email' => 'Email',
            'occupation' => 'Occupation',
            'category' => 'Category',
            'status' => 'Status',
            'date_drop' => 'Date Drop',
            'inactive_remark' => 'Inactive Remark',
            'prospect_id' => 'Prospect ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'trash' => 'Trash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
