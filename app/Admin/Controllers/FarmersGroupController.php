<?php

namespace App\Admin\Controllers;

use App\Models\FarmersGroup;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Form\NestedForm;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FarmersGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Farmers associations';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FarmersGroup());

        $grid->column('id', __('Id'))->sortable('desc');
        $grid->column('name', __('Name'));
        $grid->column('organisation_id', __('Organisation'))->display(function ($org) {
            $org = \App\Models\Organisation::find($org);
            return $org->name;
        });
        $grid->column('details', __('Details'));

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
        $show = new Show(FarmersGroup::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('name', __('Name'));
        $show->organisation('Organisation', function ($org) {
            $org->name();
        });
        $show->field('details', __('Details'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FarmersGroup());

        $form->text('name', __('Group Name'))->required();
        $form->textarea('details', __('Details'));
        $form->select('organisation_id', __('Organisation'))->options(
            \App\Models\Organisation::all()->pluck('name', 'id')
        )->required();

        $form->hasMany('agents', function (NestedForm $f) {

            $items = [];
            /* foreach (Administrator::all() as $key => $f) {
                if (!$f->isRole('agent')) {
                    continue;
                }
                $items[$f->id] = $f->name . ", ID #" . $f->id;
            } */
 
            $ajax_url = url(
                '/api/ajax?'
                    . "&search_by_1=name"
                    . "&search_by_2=id"
                    . "&model=User"
            );
            $f->select('administrator_id', "Select Agent")
                ->options(function ($id) {
                    $a = Administrator::find($id);
                    if ($a) {
                        return [$a->id => "#" . $a->id . " - " . $a->name];
                    }
                })
                ->ajax($ajax_url)->rules('required');
        });


        return $form;
    }
}
