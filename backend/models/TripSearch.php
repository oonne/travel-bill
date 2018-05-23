<?php

namespace backend\models;

use yii\data\ActiveDataProvider;
use common\models\Trip;

class TripSearch extends Trip
{

    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['trip_name'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Trip::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['trip_sequence' => SORT_DESC]]
        ]);

        // load the seach form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'trip_name', $this->trip_name]);

        return $dataProvider;
    }
}