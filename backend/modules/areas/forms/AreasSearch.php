<?php

namespace backend\modules\areas\forms;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Areas;

class AreasSearch extends Areas {

    public $pagesize = 10;
    public $keyword;
    public $status;

    public function rules() {
        return [
            ['pagesize', 'default', 'value' => 10],
            ['keyword', 'filter', 'filter' => 'trim'],
            [['pagesize', 'status'], 'integer'],
        ];
    }

    public function search($params) {
        $query = Areas::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_ASC, 'c_id' => SORT_ASC]],
            'pagination' => ['pageSize' => $this->pagesize],
        ];

        if ($this->load($params) && $this->validate()) {
            if ($this->keyword) {
                $query->andWhere([
                    'or',
                    ['like', 'c_title', $this->keyword],
                    ['like', 'c_postcode', $this->keyword]
                ]);
            }

            if ($this->status) {
                $query->andWhere(['c_status' => $this->status]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
        } else {
            $query->andWhere(['c_parent_id' => (int) Yii::$app->request->get('parent_id')]);
        }

        $provider_params['query'] = $query;

        return new ActiveDataProvider($provider_params);
    }

}
