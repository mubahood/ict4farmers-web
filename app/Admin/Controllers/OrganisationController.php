<?php

namespace App\Admin\Controllers;

use App\Models\Organisation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Form\Field;
use Illuminate\Support\Facades\Log;
use Encore\Admin\Admin;

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
        $form = new Form(new Organisation());
        // $form->hasMany('organizations', function (Form\NestedForm $form) {
            $form->text('name', __('Name'))->required();
            $form->image('logo', __('Logo'))->rules('mimes:png,jpeg,jpg');
            $form->text('address', __('Address'))->required();
            
            $form->mobile('phone', __('Phone'));
            $form->email('email', __('Email'))->required();
            $form->radio('radiocheck')->options([
                1 => 'NO',
                2 => 'YES'
            ])->when(2, function() use($form) {
                $form->text('website', __('Website'));
                $form->textarea('details', __('Details'));
            })->default(1);
 

            $form->hasMany('organizations',null, function (Form\NestedForm $form) {
                $form->text('name', __('Name'))->required();
                $form->image('logo', __('Logo'))->rules('mimes:png,jpeg,jpg');
                $form->text('address', __('Address'))->required();
                
                $form->mobile('phone', __('Phone'));
                $form->email('email', __('Email'))->required();
                $form->radio('radiocheck')->options([
                    1 => 'NO',
                    2 => 'YES'
                ])->default(1);
                    // Admin::script('alert("fellow");');
                $form->html('<div class="cascade-group cascade-new___LA_KEY__ hide">
                                <div class="form-group  ">
                                    <label for="website" class="col-sm-2  control-label">Website</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="website" name="organizations[new___LA_KEY__][website]" value="" class="form-control organizations website" placeholder="Input Website">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  ">
                                    <label for="details" class="col-sm-2  control-label">Details</label>
                                    <div class="col-sm-8">
                                        <textarea name="organizations[new___LA_KEY__][details]" class="form-control organizations details" rows="5" placeholder="Input Details"></textarea>
                                    </div>  
                                </div>
                            </div>
                ');

                $form->html('<script data-exec-on-popstate>
                var operator_table = {
                    \'=\': function(a, b) {
                        if ($.isArray(a) && $.isArray(b)) {
                            return $(a).not(b).length === 0 && $(b).not(a).length === 0;
                        }
            
                        return a == b;
                    },
                    \'>\': function(a, b) { return a > b; },
                    \'<\': function(a, b) { return a < b; },
                    \'>=\': function(a, b) { return a >= b; },
                    \'<=\': function(a, b) { return a <= b; },
                    \'!=\': function(a, b) {
                         if ($.isArray(a) && $.isArray(b)) {
                            return !($(a).not(b).length === 0 && $(b).not(a).length === 0);
                         }
            
                         return a != b;
                    },
                    \'in\': function(a, b) { return $.inArray(a, b) != -1; },
                    \'notIn\': function(a, b) { return $.inArray(a, b) == -1; },
                    \'has\': function(a, b) { return $.inArray(b, a) != -1; },
                    \'oneIn\': function(a, b) { return a.filter(v => b.includes(v)).length >= 1; },
                    \'oneNotIn\': function(a, b) { return a.filter(v => b.includes(v)).length == 0; },
                };
                    var cascade_groups = [
                        { class: "cascade-new___LA_KEY__", operator: "=", value: "2" },
                    ];
                
                    $(\'input[name="organizations[new___LA_KEY__][radiocheck]"]\').on("ifChecked", function (e) {
                        var checked = $(this).val();
                        cascade_groups.forEach(function (event) {
                            console.log(event.class);
                            var group = $(\'div.cascade-group.\'+event.class);
                            console.log(operator_table[event.operator](checked, event.value));
                            if (operator_table[event.operator](checked, event.value)) {
                                group.removeClass("hide");
                            } else {
                                group.addClass("hide");
                            }
                        });
                    });
                
                 </script>');
   
                //  .cascade-\[new_3\]


                });
        
        


        return $form;
    }
}
