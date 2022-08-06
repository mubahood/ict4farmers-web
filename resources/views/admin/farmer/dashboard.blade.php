<div class="row">
    <div class="col-md-5">
        <div class="box box-success">
            <div class="box-header with-border">
                <h2 class="box-title" style="font-size: 3rem; ">Production</h2>
                <div class="box-tools pull-right">
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body" style="display: block;">
                <div class="row ">
                    <a href="{{ admin_url('farms') }}" class="col-md-4 my-admin-item">
                        <img width="100%" src="{{ url('assets/images/admin/farm.png') }}">
                        <h3 class="my-title-1 text-center">Farms</h3>
                    </a>
                    <div class="col-md-4 pt-5">
                        <img width="100%" class=" " src="{{ url('assets/images/admin/arrow-right.png') }}">
                    </div>
                    <a href="{{ admin_url('gardens') }}" class="col-md-4 my-admin-item">
                        <img width="100%" src="{{ url('assets/images/admin/enterprise.png') }}" alt="">
                        <h3 class="my-title-1 text-center">Enterprises</h3>
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4 ">

                    </div>
                    <div class="col-md-4" style="padding-left: 5rem; padding-bottom: 3rem;  padding-top: 3rem;">
                        <img height="80px" src="{{ url('assets/images/admin/arrow-bottom.png') }}" alt="">
                    </div>
                </div>

                <div class="row">
                    <a href="{{ admin_url('garden-production-records') }}" class="col-md-4 my-admin-item">
                        <img width="100%" src="{{ url('assets/images/admin/records.png') }}">
                        <h3 class="my-title-1 text-center">Records</h3>
                    </a>
                    <div class="col-md-4 pt-5">
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

    <div class="col-md-3">

        <div class="box box-success">
            <div class="box-header with-border">
                <h2 class="box-title" style="font-size: 3rem; ">Management</h2>
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
    <div class="col-md-4">

        <div class="box box-success">
            <div class="box-body" style="display: block;">

                <div id='loading'>loading...</div>

                <div id='calendar'></div>

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

            displayEventTime: false, // don't show the time column in list view

            // THIS KEY WON'T WORK IN PRODUCTION!!!
            // To make your own Google API key, follow the directions here:
            // http://fullcalendar.io/docs/google_calendar/
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
