<?php
use App\Models\Utils;
$steps = Utils::get_wizard_actions(Admin::user()->id);
?>

<link rel="stylesheet" href="{{ url('/assets/css/bootstrap.css') }}">

<div class="row">
    <div class="col-md-8"> 
        <div class="card">
            <div class="card-body">
                <div id='loading'>loading...</div>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h2>Recent activities</h2>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic quos placeat ratione accusamus culpa illum
                rem quam distinctio incidunt, aut iste asperiores voluptatibus reprehenderit. Ad expedita deserunt eius
                et architecto.
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

            editable: true,
      selectable: true,
      selectMirror: true,
      nowIndicator: true,

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
