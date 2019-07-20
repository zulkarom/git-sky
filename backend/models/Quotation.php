<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "quotation".
 *
 * @property int $id
 * @property string $summary
 * @property string $quote_date
 * @property string $valid_until
 * @property int $type 1=prospect, 2=client
 * @property int $prospect_id
 * @property int $client_id
 * @property int $status
 * @property string $discount
 * @property string $gst
 * @property string $note
 * @property int $quote_pic
 * @property int $invoice_id
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $trash
 *
 * @property QuotationItem[] $quotationItems
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['summary', 'quote_date', 'valid_until', 'type', 'prospect_id', 'client_id', 'discount', 'gst', 'note', 'quote_pic', 'invoice_id', 'created_by', 'created_at', 'updated_at', 'trash'], 'required'],
			
			
            [['quote_date', 'valid_until', 'created_at', 'updated_at'], 'safe'],
            [['type', 'prospect_id', 'client_id', 'status', 'quote_pic', 'invoice_id', 'created_by', 'trash'], 'integer'],
            [['discount', 'gst'], 'number'],
            [['note'], 'string'],
            [['summary'], 'string', 'max' => 255],
        ];
    }
	
	public function getClient(){
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
	
	public function getCreatedBy(){
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'summary' => 'Summary',
            'quote_date' => 'Quote Date',
            'valid_until' => 'Valid Until',
            'type' => 'Type',
            'prospect_id' => 'Prospect ID',
            'client_id' => 'Client ID',
            'status' => 'Status',
            'discount' => 'Discount',
            'gst' => 'Gst',
            'note' => 'Note',
            'quote_pic' => 'Quote Pic',
            'invoice_id' => 'Invoice ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'trash' => 'Trash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationItems()
    {
        return $this->hasMany(QuotationItem::className(), ['quotation_id' => 'id']);
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
