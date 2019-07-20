<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Quotation;

/**
 * InvoiceSearch represents the model behind the search form of `backend\models\Invoice`.
 */
class QuotationSearch extends Quotation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'status', 'created_by', 'trash'], 'integer'],
            [['summary', 'quote_date', 'valid_until', 'note', 'created_at', 'updated_at'], 'safe'],
            [['discount', 'gst'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Quotation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,

        ]);

        $query->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
