<?php

$this->title = '活动编辑';
$this->params['breadcrumbs'][] = ['label' => '活动列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
