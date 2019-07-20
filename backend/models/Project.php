<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $due_at
 * @property int $status
 *
 * @property Customer $customer
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'name', 'description', 'created_at', 'updated_at', 'due_at', 'status'], 'required'],
            [['customer_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'due_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'due_at' => 'Due At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}
