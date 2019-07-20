<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "quotation_item".
 *
 * @property int $id
 * @property int $quotation_id
 * @property int $product_cat
 * @property int $product_id
 * @property string $description
 * @property string $price
 * @property double $quantity
 *
 * @property Quotation $quotation
 */
class QuotationItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'product_cat', 'product_id', 'description', 'price', 'quantity'], 'required'],
            [['quotation_id', 'product_cat', 'product_id'], 'integer'],
            [['price', 'quantity'], 'number'],
            [['description'], 'string', 'max' => 255],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotation::className(), 'targetAttribute' => ['quotation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
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
    public function getQuotation()
    {
        return $this->hasOne(Quotation::className(), ['id' => 'quotation_id']);
    }
	
	/**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
