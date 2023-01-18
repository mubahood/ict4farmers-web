<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\SimpleTask;
use App\Models\TaskCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;

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
        //$grid->disableActions();

        $grid->column('name', __('Name'));
        $grid->column('task_category_id', __('Category'))
            ->display(function ($cat_id) {
                //$cat = Category::find($cat_id);
                return $this->category->name; 
            });
        $grid->column('reminder', __('Reminder'));

 
        if(Auth::user()->isRole('administrator')){
            $grid->disableActions();
        }
        if(!Auth::user()->isRole('administrator')){
            $grid->column('description', __('Description'));
        } 

        //administrator

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

        $cats = [];
        foreach (TaskCategory::all() as $key => $value) {
            $cats[$value->id] = $value->name . " #$value->id";
        }

        $form->select('task_category_id', __('Task category'))
            ->options(TaskCategory::all()->pluck('name', 'id'))
            ->rules('required');

        $form->datetime('reminder', __('Reminder'))->default(date('Y-m-d H:i:s'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
