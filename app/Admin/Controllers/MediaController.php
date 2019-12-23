<?php

namespace App\Admin\Controllers;

use App\Model\WxMediaModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Model\WxUserModel;
use GuzzleHttp\Client;
class MediaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\WxMediaModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxMediaModel);

        $grid->column('id', __('Id'));
        $grid->column('media_id', __('Media id'));
        $grid->column('local_path', __('Local path'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WxMediaModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('media_id', __('Media id'));
        $show->field('local_path', __('Local path'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxMediaModel);

        $form->number('media_id', __('Media id'));
        $form->image('local_path', __('Local path'))->uniqueName();
        
        //表单提交保存后回调函数
        $form->saved(function (Form $form) {
            $d = $form->model();
            $media_info = $this->mediaUpload(storage_path('app/public/'.$d->local_path),'image');
            $m = json_decode($media_info,true);
            $d->where(['id'=>$d->id])->update(['media_id'=>$m['media_id']]);
        });
        return $form;
    }
    protected function mediaUpload($local_file,$media_type)
    {

        $access_token = WxUserModel::getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type='.$media_type;
        $client = new Client();
        $response = $client->request('POST',$url,[
            'multipart' => [
                [
                    'name'      => 'media',
                    'contents'  => fopen($local_file,'r')
                ]
            ]
        ]);
        return $response->getBody();
    }
}
