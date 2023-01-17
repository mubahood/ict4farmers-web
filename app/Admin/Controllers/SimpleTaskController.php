<?php

namespace App\Admin\Controllers;

use App\Models\SimpleTask;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SimpleTaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SimpleTask';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SimpleTask());
        $grid->disableActions();
  
        $grid->column('name', __('Name'));
        $grid->column('reminder', __('Reminder'));
        $grid->column('description', __('Description'));
        $grid->column('created_at', __('Created'))->sortable();

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
        $show = new Show(SimpleTask::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('reminder', __('Reminder'));
        $show->field('description', __('Description'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SimpleTask());

        $form->text('name', __('Name'))->rules('required');
        $form->datetime('reminder', __('Reminder'))->default(date('Y-m-d H:i:s'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
