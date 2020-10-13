<?php

namespace ebook\models;

use Yii;

/**
 * This is the model class for table "book_order".
 *
 * @property int $id
 * @property int $transaction_id
 * @property string $billcode
 * @property int $return_status Payment status. 1= success, 2=pending, 3=fail
 * @property string $billName
 * @property string $billDescription
 * @property string $billAmount
 * @property string $billTo
 * @property string $billEmail
 * @property string $billPhone
 * @property string $return_response
 * @property string $callback_response
 * @property string $group_name
 */
class BookOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['billTo', 'billEmail', 'billPhone', 'group_name', 'student_id'], 'required', 'on' => 'purchase'],
			
			
            [['return_status', 'book_id'], 'integer'],
			
            [['billAmount'], 'number'],
			[['billEmail'], 'email'],
            [['return_response', 'callback_response', 'student_id', 'transaction_id', 'status', ], 'string'],
            [['billcode'], 'string', 'max' => 150],
			
            [['billName', 'billDescription', 'billTo', 'billEmail', 'billPhone', 'group_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'billcode' => 'Billcode',
            'return_status' => 'Return Status',
            'billName' => 'Bill Name',
            'billDescription' => 'Bill Description',
            'billAmount' => 'Bill Amount',
            'billTo' => 'Student\'s Name',
            'billEmail' => 'Email',
            'billPhone' => 'Phone',
			'student_id' => 'Student Matric Number',
            'return_response' => 'Return Response',
            'callback_response' => 'Callback Response',
            'group_name' => 'Group Name',
        ];
    }
	
	public function getBook(){
         return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

	
	public function groupList(){
		return [
			'L1' => 'L1 - DR. AINON @ JAMILAH BINTI RAMLI',
			'L2' => 'L2 - DR. NOORUL AZWIN BINTI MD NASIR',
			'L3' => 'L3 - EN. ZUL KARAMI BIN CHE MUSA',
			'L4' => 'L4 - DR. AINON @ JAMILAH BINTI RAMLI',
			'K1' => 'K1 - DR. NADZIRAH BT MOHD SAID'
			
		];
	}
}
