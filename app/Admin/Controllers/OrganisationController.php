<?php

namespace App\Admin\Controllers;

use App\Models\Organisation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Form\Field;

class OrganisationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Organisation';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Organisation());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('details', __('Details'));
        $grid->column('logo', __('Logo'))->image('', 100, 100);
        $grid->column('address', __('Address'));
        $grid->column('phone', __('Phone'));
        $grid->column('email', __('Email'));
        $grid->column('website', __('Website'));
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
        $show = new Show(Organisation::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('logo', __('Logo'))->image();
        $show->field('address', __('Address'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('website', __('Website'));
        $show->field('details', __('Details'));
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
        $radio = '';
        $form = new Form(new Organisation());
        // $form->hasMany('organizations', function (Form\NestedForm $form) {
            $form->text('name', __('Name'))->required();
            $form->image('logo', __('Logo'))->rules('mimes:png,jpeg,jpg');
            $form->text('address', __('Address'))->required();
            
            $form->mobile('phone', __('Phone'));
            $form->email('email', __('Email'))->required();
            $form->text('website', __('Website'));
            $form->textarea('details', __('Details'));


        return $form;
    }
}
