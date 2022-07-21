<?php

namespace App\Admin\Controllers;

use App\Models\Market;
use App\Models\Pricing;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PricingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pricing';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pricing());

        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('name', __('Name'));
        $grid->column('image', __('Image'));

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
        $show = new Show(Pricing::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Pricing());

        $form->text('name', __('Name'))
            ->creationRules(['required', "unique:pricings"])
            ->rules('required');
        $form->image('image', __('Image'))->rules('required');

        $form->morphMany('pricings', 'Click on new to add Pricing', function (Form\NestedForm $form) {

            $markets = [];
            foreach (Market::all() as  $market) {
                $markets[$market->id] = $market->name;
            }

            $form->select('market_id', 'Market')
                ->options($markets)
                ->rules('required');
            $form->date('price_date', __('Price date'))->rules('required');
            $form->text('price', __('Price'))->attribute('type', 'number')->rules('required');
        });


        return $form;
    }
}
