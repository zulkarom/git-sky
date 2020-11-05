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
			'L1' => 'L1 - DR. AINON @ JAMILAH BINTI RAMLI',
			'L2' => 'L2 - DR. NOORUL AZWIN BINTI MD NASIR',
			'L3' => 'L3 - EN. ZUL KARAMI BIN CHE MUSA',
			'L4' => 'L4 - DR. AINON @ JAMILAH BINTI RAMLI',
			'K1' => 'K1 - DR. NADZIRAH BT MOHD SAID',
			'L1.FHPK' => 'L1.FHPK - DR. NORMAIZATUL AKMA SAIDI',
			'L2.FHPK' => 'L2.FHPK - DR. NORMAIZATUL AKMA SAIDI',
			
		];
	}
	

}
