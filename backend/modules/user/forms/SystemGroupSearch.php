<?php

namespace backend\modules\user\forms;

use yii\data\ActiveDataProvider;
use common\models\SystemGroup;

class SystemGroupSearch extends SystemGroup {

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
        $query = SystemGroup::find();

        $provider_params = [
            'query' => $query,
            'sort' => ['defaultOrder' => ['c_sort' => SORT_DESC, 'c_id' => SORT_DESC]],
            'pagination' => ['pageSize' => $this->pagesize],
        ];

        if ($this->load($params) && $this->validate()) {

            if ($this->keyword) {
                $query->andWhere([
                    'or',
                    ['like', 'c_title', $this->keyword]
                ]);
            }

            if ($this->status) {
                $query->andWhere(['c_status' => $this->status]);
            }

            $provider_params['pagination']['pageSize'] = $this->pagesize;
            $provider_params['query'] = $query;
        }

        return new ActiveDataProvider($provider_params);
    }

}
