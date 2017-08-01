<?php

namespace common\widgets\uploader;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use common\extensions\CheckRule;

class Uploader extends Widget {

    public $object_id = 0; //关联ID
    public $user_type = 1; //用户类型 1后台 2前台 前台需要再小部件写入 user_type=2
    public $is_file = false; //false上传图片 true上传文件
    public $name = '';
    public $value = ''; //控件默认值
    public $more = false;

    public function run() {
        $upload_url = $this->is_file ? 'uploader/file' : 'uploader/picture'; //上传附件路由
        $delete_url = 'uploader/delete'; //删除附件路由
        $var['name'] = $this->name ? $this->name : ( $this->is_file ? 'file_list' : 'picture_list');
        $var['value'] = $this->value;
        $var['upload_url'] = ($this->user_type === 1 && CheckRule::checkRole($upload_url)) || $this->user_type === 2 ? Url::to([$upload_url]) : false; //是否需要显示上传按钮
        $var['delete_url'] = ($this->user_type === 1 && CheckRule::checkRole($delete_url)) || $this->user_type === 2 ? Url::to([$delete_url]) : false; //是否需要显示删除按钮
        $var['object_id'] = $this->object_id;
        $var['is_file'] = $this->is_file;
        $var['extensions'] = $this->is_file ? '*' : implode(',', Yii::$app->params['image_extensions']);
        $var['more'] = $this->more;
        $template = $this->more ? 'multiple' : 'single';
        return $this->render($template, $var);
    }

}