<?php

$this->title = '文章类别新增';
$this->params['breadcrumbs'][] = ['label' => '文章类别列表', 'url' => ['index']];
echo $this->render('_form', ['model' => $model]);
