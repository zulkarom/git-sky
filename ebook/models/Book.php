<?php

namespace ebook\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $bname
 * @property string $blink
 * @property int $price
 * @property string $created_at
 * @property string $updated_at
 */
class Book extends \yii\db\ActiveRecord
{
	public $group_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bname', 'blink', 'price'], 'required'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['bname', 'blink'], 'string', 'max' => 200],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bname' => 'Bname',
            'blink' => 'Blink',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function groupList(){
		return [
			'FHPK' => 'Dr. Normaizatul Akma Binti Saidi'
			
		];
	}
	

}
