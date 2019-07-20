<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $product_name
 * @property int $product_cat
 * @property string $product_code
 * @property string $unit_measure
 * @property string $price_perunit
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $trash
 *
 * @property InvoiceItem[] $invoiceItems
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'product_cat', 'product_code', 'unit_measure', 'price_perunit', 'status', 'created_at', 'updated_at', 'created_by', 'trash'], 'required'],
            [['product_cat', 'status', 'created_by', 'trash'], 'integer'],
            [['price_perunit'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_name'], 'string', 'max' => 255],
            [['product_code'], 'string', 'max' => 200],
            [['unit_measure'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'product_cat' => 'Product Cat',
            'product_code' => 'Product Code',
            'unit_measure' => 'Unit Measure',
            'price_perunit' => 'Price Perunit',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'trash' => 'Trash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceItems()
    {
        return $this->hasMany(InvoiceItem::className(), ['product_id' => 'id']);
    }
}
