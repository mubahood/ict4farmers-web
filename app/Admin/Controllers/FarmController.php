<?php

namespace App\Admin\Controllers;

use App\Models\Farm;
use App\Models\Location;
use App\Models\Utils;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Auth;
use StevebaumanLocation;


class FarmController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */

    protected $title = 'My Farms';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        if (!Utils::is_wizard_done(Auth::user()->id)) {
            return redirect(admin_url("/"));
        }
        $grid = new Grid(new Farm());
        $grid->model()->latest();
        $grid->model()->where('administrator_id', Admin::user()->id);


        //$grid->column('id', __('Id'));
        //$grid->column('updated_at', __('Updated at'));
        $grid->column('created_at', __('Created'))->sortable();
        $grid->column('name', __('Farm Name'))->sortable();

        $grid->column('running',__('Operational'))->bool();
        $grid->column('size', __('Size (acres)'));
        $grid->column('administrator_id', __('Owner'))->display(function () {
            return $this->owner->name;
        })->sortable();

        $grid->column('location_id', __('Subcounty'))->display(function () {
            return $this->location->get_name();
            
        })->sortable();

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
        $show = new Show(Farm::findOrFail($id));

        $show->field('created_at', __('Created'));
        $show->field('administrator_id', __('Administrator id'));
        $show->field('location_id', __('Location id'));
        $show->field('name', __('Name'));
        $show->field('running', __('Operational'))->display(function ($running) {
            if ($running) {
                return "<span class='label label-success'>Yes</span>";
            } else {
                return "<span class='label label-danger'>No</span>";
            }
        });
        $show->field('size', __('Acres'));
        $show->field('latitude', __('Latitude'));
        $show->field('longitude', __('Longitude'));
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
        $current_location = StevebaumanLocation::get();

        $form = new Form(new Farm());
        $form->disableReset();
        $form->disableViewCheck();
        $form->disableEditingCheck();
        $form->disableCreatingCheck();

        $user = Auth::user();
        if ($form->isCreating()) {
            $form->hidden('administrator_id', __('Administrator id'))->value($user->id);
        }
        $form->text('name', __('Farm Name'))->rules('required');

        $states = [
            'on'  => ['value' => 1, 'text' => 'Open', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'Closed', 'color' => 'danger'],
        ];
        
        $form->switch('running', 'Operational')->states($states);
        
        //this sub-county should match that from the enterprise as a rule
        $form->select('location_id', __('Farm Location (Sub-county)'))
            ->options(Location::get_subcounties())
            ->rules('required');
            
        $form->number('size', __('Size in Acres'))
            ->help("E.g, 1 acre, 2 acres, 3 acres, etc.")
            ->rules('required|numeric|min:1');


        //info user that there current location will be used
        $form->html('<div class="alert alert-info">Your current location will be used for this farm. If you want to change it, please edit it later.</div>');
        if($current_location){
            $form->hidden('latitude', __('GPS Latitude'))->default($current_location->latitude)->value($current_location->latitude);
            $form->hidden('longitude', __('GPS Longitude'))->default($current_location->longitude)->value($current_location->longitude);
        }else{
            $form->text('latitude', __('GPS Latitude'))->default("0.00")->rules('numeric|min:0');
            $form->text('longitude', __('GPS Longitude'))->default("0.00")->rules('numeric|min:0');
        }
        $form->textarea('details', __('Farm Details'))->help("Write something about this farm");

        return $form;
    }
}
