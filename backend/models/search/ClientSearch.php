<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Client;

/**
 * ClientSearch represents the model behind the search form of `backend\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city', 'state_id', 'category', 'status', 'prospect_id', 'trash'], 'integer'],
            [['name', 'ic_no', 'address', 'postcode', 'phone1', 'phone2', 'email', 'occupation', 'date_drop', 'inactive_remark', 'updated_at', 'created_at'], 'safe'],
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
        $query = Client::find();

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
            'city' => $this->city,
            'state_id' => $this->state_id,
            'category' => $this->category,
            'status' => $this->status,
            'date_drop' => $this->date_drop,
            'prospect_id' => $this->prospect_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'trash' => $this->trash,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ic_no', $this->ic_no])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'postcode', $this->postcode])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'occupation', $this->occupation])
            ->andFilterWhere(['like', 'inactive_remark', $this->inactive_remark]);

        return $dataProvider;
    }
}
