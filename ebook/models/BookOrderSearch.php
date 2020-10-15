<?php

namespace ebook\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form of `backend\models\DemoToyyib`.
 */
class BookOrderSearch extends BookOrder
{
	public $blink;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_name'], 'string'],
			[['settlement'], 'integer'],
            
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
        $query = BookOrder::find()
		->joinWith('book')
		->where(['book_order.status' => 'success', 'book.blink' => $this->blink])
		;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 150,
            ],

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
            'group_name' => $this->group_name,
			'settlement' => $this->settlement,
          
        ]);

        

        return $dataProvider;
    }
}
