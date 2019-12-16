<?php

namespace App\Admin\Controllers;

use App\Model\WxUserModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\WxUserModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxUserModel);

        $grid->column('user_id', __('User id'));
        $grid->column('openid', __('Openid'));
        $grid->column('sex', __('Sex'))->display(function($sex){
            if($sex==1){
                return '男';
            }elseif($sex==2){
                return '女';
            }else{
                return '保密';
            }
        });
        $grid->column('sub_time', __('注册时间'))->display(function($time){
            return date('Y-m-d H:i:s',$time);
        });
        $grid->column('nickname', __('昵称'));
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));
        $grid->column('headimgurl', __('Headimgurl'))->display(function($url){
            return '<img src='.$url.'>';
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
        $show = new Show(WxUserModel::findOrFail($id));

        $show->field('user_id', __('User id'));
        $show->field('openid', __('Openid'));
        $show->field('sex', __('Sex'));
        $show->field('sub_time', __('Sub time'));
        $show->field('nickname', __('Nickname'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('headimgurl', __('Headimgurl'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxUserModel);

        $form->text('openid', __('Openid'));
        $form->switch('sex', __('Sex'));
        $form->number('sub_time', __('Sub time'));
        $form->text('nickname', __('Nickname'));
        $form->text('headimgurl', __('Headimgurl'));

        return $form;
    }
}
