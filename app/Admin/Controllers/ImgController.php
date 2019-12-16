<?php

namespace App\Admin\Controllers;

use App\Model\WxImg;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ImgController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '微信图片管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxImg);

        $grid->column('img_id', __('Img id'));
        $grid->column('img_url', __('素材'))->display(function($img){
            return '<img src=" http://www.bianaoao.top/'.$img.'" width="50">';
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
        $show = new Show(WxImg::findOrFail($id));

        $show->field('img_id', __('Img id'));
        $show->field('img_url', __('Img url'));
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
        $form = new Form(new WxImg);

        $form->text('img_url', __('Img url'));
        $form->number('user_id', __('User id'));
        $form->number('time', __('Time'));

        return $form;
    }
}
