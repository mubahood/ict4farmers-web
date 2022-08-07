<link rel="stylesheet" href="{{ url('/assets/css/bootstrap.css') }}">

<div class="row">
    <div class="col-md-8">
        <div class="card border-white">
            <div class="card-body">
                <div id='loading'>loading...</div>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card rounded border-white">
            <div class="card-body  rounded">
                <h2 class="text-bold p-0 m-0 mb-4">Recent activities

                    <a href="{{ admin_url('garden-activities') }}" class="btn btn-primary float-right">VIEW ALL
                        ACTIVITIES</a>
                </h2>
                <div class="list-group">

                    <?php
                    $events = array_reverse($events);
                    $x = 0; ?>
                    @foreach ($events as $s)
                        <?php
                        if ($x > 8) {
                            break;
                        }
                        $x++;
                        
                        $classes = '';
                        if ($s['is_done'] == 1) {
                            $classes = ' bg-light  ';
                        }
                        ?>
                        <a data-id="{{ $s['id'] }}" href="#"
                            class="list-group-item list-group-item-action flex-column align-items-start activity-item <?= $classes ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $s['type'] }}</h5>
                                <small class="text-muted">{{ $s['start'] }}</small>
                            </div>
                            <p class="mb-1 text-dark">
                                @if ($s['is_done'] == 1)
                                    <i class="fa fa-check"></i>
                                @endif
                                {!! $s['title'] !!}
                            </p>
                        </a>
                    @endforeach

                </div>




            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        var data = JSON.parse('<?= json_encode($events) ?>');

        function show_activity(x) {
            const eve = data[x];

            $.alert({
                title: eve.type,
                content: eve.details,
                closeIcon: true,
                buttons: {
                    edit: {
                        btnClass: 'btn-primary',
                        text: 'UPDATE ACTIVITY STATUS',
                        action: function() {
                            submit_activity(eve.activity_id);
                        }
                    },
                    CLOSE: function() {

                    },
                }
            });

        }

        $('.activity-item').click(function(e) {
            e.preventDefault();
            show_activity(e.currentTarget.dataset.id);

        });



        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {

            headerToolbar: {
                left: 'title',
                right: 'prev today next'
            },

            editable: false,
            selectable: false,
            selectMirror: true,
            nowIndicator: true,
            displayEventTime: true,
            events: data,

            eventClick: function(arg) {

                // opens events in a popup window
                //window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');
                arg.jsEvent.preventDefault() // don't navigate in main tab

                const eve = arg.event._def;
                const activity_id = eve.extendedProps.activity_id;


                $.alert({
                    title: eve.extendedProps.type,
                    content: eve.extendedProps.details,
                    closeIcon: true,
                    buttons: {
                        edit: {
                            btnClass: 'btn-primary',
                            text: 'UPDATE ACTIVITY STATUS',
                            action: function() {
                                submit_activity(activity_id);
                            }
                        },
                        CLOSE: function() {

                        },
                    }
                });
            },

            loading: function(bool) {
                document.getElementById('loading').style.display =
                    bool ? 'block' : 'none';
            }

        });

        calendar.render();
    });

    function submit_activity(x) {

        $.confirm({
            title: 'Activity status submission',
            content: '' +
                '<form method="GET" action="<?= admin_url('calender-activity-edit') ?>" class="formName">' +

                '<div class="form-group">' +
                '<div class="form-check form-check-inline">' +
                '<input required class="form-check-input" type="radio" id="done_status" name="done_status" value="1">' +
                '<label class="form-check-label" for="done_status">Done</label></div>' +
                '</div>' +

                '<div class="form-group">' +
                '<div class="form-check form-check-inline">' +
                '<input required class="form-check-input" type="radio" id="done_status_not" name="done_status" value="0">' +
                '<label class="form-check-label" for="done_status_not">Not Done (Missed)</label></div>' +
                '</div>' +


                '<div class="form-group">' +
                '<label>Activity remarks</label>' +
                '<input name="done_details" placeholder="Remarks about this activity"  class="name form-control" required />' +
                '</div>' +

                '<input name="id" type="hidden" value="' + x + '">' +


                '<button class="btn-lg float-right btn btn-primary mt-2" type="submit">SUBMIT</button>' +


                '</form>',
            buttons: {
                cancel: function() {
                    //close
                },
            },

        });
    }
</script>
