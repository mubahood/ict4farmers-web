<?php
use App\Models\Utils;

$steps = Utils::get_wizard_actions(Admin::user()->id);
?><div class="row">

    <div class="col-md-8">

        <div class="row">

            <div class="col-md-8">
                <div class="box box-success">
                    <h2 class="h4 text-bold m-0 border-bottom p-2 border-primary">Production</h2>

                    <div class="box-body" style="display: block;">
                        <div class="row ">
                            <a href="{{ admin_url('farms') }}" class="col-md-4 my-admin-item">
                                <img width="100%" src="{{ url('assets/images/admin/farm.png') }}">
                                <h3 class="my-title-1 text-center">Farms</h3>
                            </a>
                            <div class="col-md-4 " style="padding-top: 5rem">
                                <img width="100%" class=" "
                                    src="{{ url('assets/images/admin/arrow-right.png') }}">
                            </div>
                            <a href="{{ admin_url('gardens') }}" class="col-md-4 my-admin-item">
                                <img width="100%" src="{{ url('assets/images/admin/enterprise.png') }}"
                                    alt="">
                                <h3 class="my-title-1 text-center">Enterprises</h3>
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4 ">

                            </div>
                            <div class="col-md-4" style="padding-left: 5rem; padding-bottom: 1rem;  padding-top: 2rem;">
                                <img height="70px" src="{{ url('assets/images/admin/arrow-bottom.png') }}"
                                    alt="">
                            </div>
                        </div>

                        <div class="row">
                            <a href="{{ admin_url('garden-production-records') }}" class="col-md-4 my-admin-item">
                                <img width="100%" src="{{ url('assets/images/admin/records.png') }}">
                                <h3 class="my-title-1 text-center">Production Records</h3>
                            </a>
                            <div class="col-md-4 " style="padding-top: 5rem">
                                <img width="100%" class=" " src="{{ url('assets/images/admin/arrow-left.png') }}"
                                    alt="">
                            </div>
                            <a href="{{ admin_url('garden-activities') }}" class="col-md-4 my-admin-item">
                                <img width="100%" src="{{ url('assets/images/admin/tasks.png') }}">
                                <h3 class="my-title-1 text-center ">Activities</h3>
                            </a>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>

            <div class="col-md-4">

                <div class="box box-success">
                    <div class="with-border p-0">
                        <h2 class="h4 text-bold m-0 border-bottom p-2 border-primary">Management</h2>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body" style="display: block;">

                        <div class="row">
                            <a href="{{ admin_url('financial-records') }}" class="col-md-12 my-admin-item text-center">
                                <img width="40%" src="{{ url('assets/images/admin/money.gif') }}">
                                <h3 class="my-title-1 text-center ">Financial records</h3>
                            </a>
                        </div>

                        <hr>

                        <div class="row">
                            <a href="{{ admin_url('my-workers') }}" class="col-md-12 my-admin-item text-center">
                                <img width="40%" src="{{ url('assets/images/admin/workers.png') }}">
                                <h3 class="my-title-1 text-center ">Farm workers</h3>
                            </a>
                        </div>

                        <hr>

                        <div class="row">
                            <a href="{{ admin_url('products') }}" class="col-md-12 my-admin-item text-center">
                                <img width="40%" src="{{ url('assets/images/admin/market.png') }}">
                                <h3 class="my-title-1 text-center ">Market place</h3>
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="card border border-success  ">
                            <a href="{{ admin_url('gardens') }}" class=" card-body py-1 my-0">
                                <h3 class="p-0 m-0 text-dark">20</h3>
                                <h3 class="p-0 m-0 text-primary h4 text-bold">Enterprises</h3>
                                <p class="text-dark">2 Cattle, 4 Gardens</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <a href="{{ admin_url('garden-activities') }}" class="card border border-success  ">
                            <div class=" card-body py-1 my-0">
                                <h3 class="p-0 m-0 text-dark">12</h3>
                                <h3 class="p-0 m-0 text-primary h4 text-bold">Activities</h3>
                                <p class="text-dark">23 Pending, 4 Done, <span class="text-danger">80 Missed</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card border border-success  ">
                            <a href="{{ admin_url('financial-records') }}" class=" card-body py-1 my-0">
                                <h3 class="p-0 m-0 text-dark">UGX 120,000</h3>
                                <h3 class="p-0 m-0 text-primary h4 text-bold">Total Profit or Loss</h3>
                                <p class="text-dark">UGX 20,000 Income, UGX 45,000 Expenses</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>


    <div class="col-md-4">

        <div class="box box-success">
            <div class="box-body" style="display: block;">

                <div id='loading'>loading...</div>

                <div id='calendar'></div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 class="h3 text-primary text-bold m-0 py-2 mb-2">Getting Started Checklist</h2>
                @foreach ($steps as $s)
                    <div class="form-check">
                        <input @if ($s->is_done == 1) checked @endif class="form-check-input " readonly
                            type="checkbox" value="" id="box-{{ $s->id }}">
                        <label class="form-check-label text-dark pl-2"
                            style="font-weight: 400; font-size: 1.4rem; line-height: 1.5;"
                            for="box-{{ $s->id }}">
                            {{ $s->title }}
                        </label>
                        <a class="text-right float-right text-bold" href="javascript:;">
                            <i class="fa fa-youtube-play"></i>
                            Learn how</a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {

            headerToolbar: {
                left: 'title',
                right: 'prev today next'
            },

            displayEventTime: false,
            googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
            // US Holidays
            events: 'en.usa#holiday@group.v.calendar.google.com',

            eventClick: function(arg) {
                // opens events in a popup window
                //window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');
                alert("Clicked on event");
                arg.jsEvent.preventDefault() // don't navigate in main tab
            },

            loading: function(bool) {
                document.getElementById('loading').style.display =
                    bool ? 'block' : 'none';
            }

        });

        calendar.render();
    });
</script>
