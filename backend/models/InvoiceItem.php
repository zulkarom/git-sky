<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "invoice_item".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $product_cat
 * @property int $product_id
 * @property string $description
 * @property string $price
 * @property double $quantity
 *
 * @property Invoice $invoice
 */
class InvoiceItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'product_cat', 'product_id', 'description', 'price', 'quantity'], 'required'],
            [['invoice_id', 'product_cat', 'product_id'], 'integer'],
            [['price', 'quantity'], 'number'],
            [['description'], 'string', 'max' => 255],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'product_cat' => 'Product Cat',
            'product_id' => 'Product ID',
            'description' => 'Description',
            'price' => 'Price',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
