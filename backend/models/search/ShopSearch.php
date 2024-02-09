<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Shop;

/**
 * ShopSearch represents the model behind the search form of `common\models\Shop`.
 */
class ShopSearch extends Shop
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'shop_status', 'user_id', 'cif'], 'integer'],
            [['shop_name', 'description', 'image', 'logo', 'tags', 'opening_days', 'category', 'social_media_links'], 'safe'],
            [['average_rating'], 'number'],
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
        $query = Shop::find();

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
            'tags' => $this->tags,
            'shop_status' => $this->shop_status,
            'average_rating' => $this->average_rating,
            'user_id' => $this->user_id,
            'cif' => $this->cif,
        ]);

        $query->andFilterWhere(['like', 'shop_name', $this->shop_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'opening_days', $this->opening_days])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'social_media_links', $this->social_media_links]);

        return $dataProvider;
    }
}
