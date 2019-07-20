<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "invoice_note".
 *
 * @property int $id
 * @property string $note_name
 * @property string $note_text
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $trash
 */
class InvoiceNote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_name', 'note_text', 'created_at', 'created_by', 'updated_at', 'trash'], 'required'],
            [['note_text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'trash'], 'integer'],
            [['note_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note_name' => 'Note Name',
            'note_text' => 'Note Text',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'trash' => 'Trash',
        ];
    }
}
