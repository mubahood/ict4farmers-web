<?php

namespace App\Admin\Controllers;

use App\Models\Call;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Http\Controllers\CallCenter\CallCenterController;
use App\Models\AgentProfile;
use App\Http\Controllers\Controller;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Http\Request;
use Carbon\Carbon;


class CallCenterAgentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UNFFE Call Center Agents';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new AgentProfile());
        $grid->column("name", __("Name"))->sortable();
        $grid->column("phone_number", __("Phone Number"))->sortable();
        $grid->column("region", __("Region"))->sortable();
        $grid->column("district", __("District"))->sortable();
        $grid->column("specific_role", __("Role"))->sortable();

        $grid->column('created_at', __('Date Registered'))
            ->display(function ($item) {
            return Carbon::parse($item)->diffForHumans();
        })->sortable();

        $grid->filter(function($search_param){
            $search_param->disableIdfilter();
            $search_param->like('name', __("Search for Agent by Name"));
            $search_param->like('phone_number', __("Search for Agent by Phone Number"));
            $search_param->like('district', __("Search for Agent by District"));
            $search_param->like('specific_role', __("Search for Agent by Role"));
        });


        return $grid;
    }


       /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AgentProfile());
        $form->text('name', __("Agent Name"))->required();
        $form->text('phone_number', __("Phone Number"))->required();
        $form->text('region', __("Region"))->required();
        $form->text('district', __("District"))->required();
        $form->text('specific_role', __("Role"))->required();
        return $form;
    }

}

