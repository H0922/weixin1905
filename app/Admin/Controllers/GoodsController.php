<?php

namespace App\Admin\Controllers;

use App\Model\WxGoodsModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商哝管睆';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxGoodsModel);

        $grid->column('goods_id', __('Goods id'));
        $grid->column('goods_name', __('Goods name'));
        $grid->column('goods_img', __('Goods img'))->image();
        $grid->column('goods_desc', __('Goods desc'));
        $grid->column('goods_price', __('Goods price'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(WxGoodsModel::findOrFail($id));

        $show->field('goods_id', __('Goods id'));
        $show->field('goods_name', __('Goods name'));
        $show->field('goods_img', __('Goods img'));
        $show->field('goods_desc', __('Goods desc'));
        $show->field('goods_price', __('Goods price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxGoodsModel);

        $form->text('goods_name', __('Goods name'));
        $form->image('goods_img', __('Goods img'));
        $form->number('goods_price', __('Goods price'));
        // $form->text('goods_desc', __('Goods desc'));
        $form->ckeditor('goods_desc',__('Goods desc'));
  

        return $form;
    }
}
