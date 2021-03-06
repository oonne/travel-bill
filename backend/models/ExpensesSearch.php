<?php

namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\helpers\Query as QueryHelper;
use common\models\Expenses;

class ExpensesSearch extends Expenses
{
    public $dateRange;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expenses_money', 'expenses_item', 'expenses_city', 'expenses_category', 'expenses_trip', 'expenses_handler', 'expenses_receipt', 'expenses_remark', 'dateRange'], 'safe'],
        ];
    }

    public function search($params, $export=false)
    {
        $query = Expenses::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['expenses_date' => SORT_DESC, 'updated_at' => SORT_DESC]]
        ]);

        $data = [];

        if ($export) {
            $dataProvider->pagination->pageSize = 0;
        }    

        if (!($this->load($params) && $this->validate())) {
            $data['dataProvider'] = $dataProvider;
            $data['summary'] = $this->_summary();
            return $data;
        }    

        QueryHelper::addDigitalFilter($query, 'expenses_money', $this->expenses_money);

        $dates = explode('~', $this->dateRange, 2);
        if (count($dates) == 2) {
            $query->andFilterWhere(['>=', 'expenses_date', $dates[0] ])
                  ->andFilterWhere(['<=', 'expenses_date', $dates[1] ]);
        }

        $query->andFilterWhere(['like', 'expenses_item', $this->expenses_item])
              ->andFilterWhere(['like', 'expenses_city', $this->expenses_city])
              ->andFilterWhere(['expenses_category' => $this->expenses_category])
              ->andFilterWhere(['expenses_trip' => $this->expenses_trip])
              ->andFilterWhere(['expenses_handler' => $this->expenses_handler])
              ->andFilterWhere(['expenses_receipt' => $this->expenses_receipt])
              ->andFilterWhere(['like', 'expenses_remark', $this->expenses_remark]);

        $data['dataProvider'] = $dataProvider;
        $data['summary'] = $this->_summary();
        return $data;
    }

    public function _summary()
    {
        $query = Expenses::find()
                    ->select(['summary' => 'SUM(expenses_money)'])
                    ->from([Expenses::tableName()]);

        if ($this->expenses_money) {
            QueryHelper::addDigitalFilter($query, 'expenses_money', $this->expenses_money);
        }

        $dates = explode('~', $this ->dateRange, 2);
        if (count($dates) == 2) {
            $query->andFilterWhere(['>=', 'expenses_date', $dates[0] ])
                  ->andFilterWhere(['<=', 'expenses_date', $dates[1] ]);
        }

        if ($this->expenses_item) {
            $query->andWhere(['like', 'expenses_item', $this->expenses_item]);
        }
        if ($this->expenses_category) {
            $query->andWhere(['expenses_category' => $this->expenses_category]);
        }
        if ($this->expenses_handler) {
            $query->andWhere(['expenses_handler' => $this->expenses_handler]);
        }
        if ($this->expenses_remark) {
            $query->andWhere(['like', 'expenses_remark', $this->expenses_remark]);
        }                

        $data = $query->createCommand()->queryOne();

        return $data['summary'];
    }

    public function export($params) {
        return $this->search($params, true);
    }
}
