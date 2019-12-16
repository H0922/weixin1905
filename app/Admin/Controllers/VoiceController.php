<?php

namespace App\Admin\Controllers;

use App\Model\WxVoice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VoiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '微信语音管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxVoice);

        $grid->column('voice_id', __('Voice id'));
        $grid->column('voice_url', __('Voice url'))->display(function($voice){
            return '<audio src= http://www.bianaoao.top/'.$voice.' controls>
            // http://www.bianaoao.top/admin/image
            </audio>';
        });
        $grid->column('user_id', __('User id'));
        $grid->column('time', __('Time'))->display(function($time){
            return date('Y-m-d H:i:s',$time);
        });

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
        $show = new Show(WxVoice::findOrFail($id));

        $show->field('voice_id', __('Voice id'));
        $show->field('voice_url', __('Voice url'));
        $show->field('user_id', __('User id'));
        $show->field('time', __('Time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxVoice);

        $form->text('voice_url', __('Voice url'));
        $form->number('user_id', __('User id'));
        $form->number('time', __('Time'));

        return $form;
    }
}
