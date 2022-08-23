<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ProductsCategoryController extends AdminController
{
    protected $title = 'All categories';

    /**
     * Index interface.
     *
     * @return Content
     */

    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('image', __('thumnail'))
            ->display(function () {

                return '<img width="100" src="' . url('storage/' . $this->image) . '" >';
            })
            ->sortable();
        $grid->column('name', __('Title'))->sortable();
        $grid->column('parent', __('parent'))
            ->display(function () {
                $cat = Category::find($this->parent);
                if ($cat == null) {
                    return "-";
                }
                return $cat->name;
            })
            ->sortable();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $parents = [];
        foreach (Category::all() as $key => $v) {
            $id = (int)($v->parent);
            if ($v->parent < 1) {
                $parents[$v->id] = $v->name;
            }
        }

        $form->select('parent', __('Parent category'))
            ->options($parents);

        $form->text('name', __('Name'))->required();

        $form->image('image', __('Image'));
        $form->textarea('description', __('Details'));




        return $form;
    }
}
