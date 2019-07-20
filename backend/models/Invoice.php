<?php

namespace backend\models;

use Yii;
use yii\helpers\Url;
use common\models\User;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string $summary
 * @property string $invoice_date
 * @property string $due_date
 * @property int $client_id
 * @property int $status
 * @property string $discount
 * @property string $gst
 * @property string $note
 * @property int $invoice_pic
 * @property int $quotation_id
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $trash
 *
 * @property InvoiceItem[] $invoiceItems
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['summary', 'invoice_date', 'due_date', 'client_id', 'discount', 'gst', 'note', 'invoice_pic', 'quotation_id', 'created_by', 'created_at', 'updated_at', 'trash'], 'required'],
            [['invoice_date', 'due_date', 'created_at', 'updated_at'], 'safe'],
            [['client_id', 'status', 'invoice_pic', 'quotation_id', 'created_by', 'trash'], 'integer'],
            [['discount', 'gst'], 'number'],
            [['note'], 'string'],
            [['summary'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'summary' => 'Summary',
            'invoice_date' => 'Invoice Date',
            'due_date' => 'Due Date',
            'client_id' => 'Client ID',
            'status' => 'Status',
            'discount' => 'Discount',
            'gst' => 'Gst',
            'note' => 'Note',
            'invoice_pic' => 'Invoice Pic',
            'quotation_id' => 'Quotation ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'trash' => 'Trash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceItems()
    {
        return $this->hasMany(InvoiceItem::className(), ['invoice_id' => 'id']);
    }
	
	public function getClient(){
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
	
	public function getCreatedBy(){
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
	
	

	
	public function getProspectOrClient(){
		//echo $this->client_id;
		if($this->client_id > 0){
			$c = $this->client;
			return $this->prospectClientFormat(
			$c->name, 
			$c->address, 
			$c->postcode, 
			$c->city, 
			$c->state, 
			$c->email, 
			$c->phone1);
		}else{
			return "<a href='". Url::to(['/client/create'])."' class='btn btn-warning btn-sm'> <span class='glyphicon glyphicon-plus'></span>  Create New Client</a>";
		}
		
	}
	
	
	private function prospectClientFormat($name, $address, $postcode, $city, $state, $email, $phone){
		$text = '<b>' .$name . '</b><br />';
		if($address){
			$text .= $address;
		}
		
		if($postcode){
			if($address){
				$postcode = ' ' . $postcode;
			}else{
				$postcode = $postcode;
			}
		}
		
		if($city){
			if($postcode or $address){
				$city = ' ' . $city;
			}else{
				$city = $city;
			}
			
		}else{
			$city = '';
		}
		
		$text .=  $postcode . $city . ' ' . $state;
		
		
		if($email){
			$text .= '<br />(' . $email . ')';
		}else if($phone){
			$text .= '<br />(' . $phone . ')';
		}
		return $text;
	}
}
