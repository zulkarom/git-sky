<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DemoToyyib;

/**
 * DemoToyyibSearch represents the model behind the search form of `backend\models\DemoToyyib`.
 */
class DemoToyyibSearch extends DemoToyyib
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'return_status'], 'integer'],
            [['billcode', 'billName', 'billDescription', 'billTo', 'billEmail', 'billPhone', 'return_response', 'callback_response'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = DemoToyyib::find();

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
            'order_id' => $this->order_id,
            'return_status' => $this->return_status,
        ]);

        $query->andFilterWhere(['like', 'billcode', $this->billcode])
            ->andFilterWhere(['like', 'billName', $this->billName])
            ->andFilterWhere(['like', 'billDescription', $this->billDescription])
            ->andFilterWhere(['like', 'billTo', $this->billTo])
            ->andFilterWhere(['like', 'billEmail', $this->billEmail])
            ->andFilterWhere(['like', 'billPhone', $this->billPhone])
            ->andFilterWhere(['like', 'return_response', $this->return_response])
            ->andFilterWhere(['like', 'callback_response', $this->callback_response]);

        return $dataProvider;
    }
}
