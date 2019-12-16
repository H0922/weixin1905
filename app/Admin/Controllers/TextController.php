<?php

namespace App\Admin\Controllers;

use App\Model\WxText;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TextController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '信息回复管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxText);
        // $grid->column('user_id', 'user_id')->sortable();
        $grid->column('text_id', __('Text id'));
        $grid->column('text_desc', __('Text desc'));
        // $grid->column('user_id', __('User id'));
        $grid->column('time', __('Time'))->display(function($time){
            return date('Y-m-d H:i:s',$time);
        });
        $grid->column('WxUserModel.nicknam','用户名称');

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
        $show = new Show(WxText::findOrFail($id));

        $show->field('text_id', __('Text id'));
        $show->field('text_desc', __('Text desc'));
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
        $form = new Form(new WxText);

        $form->text('text_desc', __('Text desc'));
        $form->number('user_id', __('User id'));
        $form->number('time', __('Time'));

        return $form;
    }
}
