<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "demo_toyyib".
 *
 * @property int $id
 * @property int $order_id
 * @property string $billcode
 * @property int $return_status Payment status. 1= success, 2=pending, 3=fail
 * @property string $billName
 * @property string $billDescription
 * @property string $billTo
 * @property string $billEmail
 * @property string $billPhone
 * @property string $return_response
 * @property string $callback_response
 */
class DemoToyyib extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demo_toyyib';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'billTo', 'billEmail', 'billPhone'], 'required'],
			
            [['order_id', 'return_status'], 'integer'],
            [['return_response', 'callback_response'], 'string'],
            [['billcode'], 'string', 'max' => 150],
            [['billName', 'billDescription', 'billTo', 'billEmail', 'billPhone'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'billcode' => 'Billcode',
            'return_status' => 'Return Status',
            'billName' => 'Bill Name',
            'billDescription' => 'Bill Description',
            'billTo' => 'Bill To',
            'billEmail' => 'Bill Email',
            'billPhone' => 'Bill Phone',
            'return_response' => 'Return Response',
            'callback_response' => 'Callback Response',
        ];
    }
}
