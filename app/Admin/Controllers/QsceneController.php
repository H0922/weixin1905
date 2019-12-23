<?php

namespace App\Admin\Controllers;

use App\Model\WxQsceneModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class QsceneController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Model\WxQsceneModel';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxQsceneModel);

        $grid->column('s_id', __('S id'));
        $grid->column('scene_id', __('Scene id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('imgurl', __('Imgurl'));
        $grid->column('imghttp', __('Imghttp'));

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
        $show = new Show(WxQsceneModel::findOrFail($id));

        $show->field('s_id', __('S id'));
        $show->field('scene_id', __('Scene id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('imgurl', __('Imgurl'));
        $show->field('imghttp', __('Imghttp'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxQsceneModel);

        $form->number('scene_id', __('Scene id'));
        $form->text('imgurl', __('Imgurl'));
        $form->text('imghttp', __('Imghttp'));

        return $form;
    }
}
