<?php
use App\Models\Utils;

$steps = Utils::get_wizard_actions(Admin::user()->id);
$steps = array_reverse($steps);
$step = $steps[0];
$step_num = 1;
$step_text = 1;
$step_tot = 1;
$step_percentage = 0;
$faound = false;
foreach ($steps as $s) {
    if ($s->id > 3) {
        continue;
    }
    $step_tot++;

    if (!$faound) {
        $step_num++;
    }

    if ($s->is_done != 1 && !$faound) {
        $faound = true;
        $step = $s;
    }
}

if (!$faound) {
    $step->title = 'Congs! You have complted setting up your system!';
    $step->description = 'WHAT NEXT? If it is your first time here, don\'t worry you can go ahead and tour the system. 
    It is simple and straight forward to use.<br><br>
    We have also prepared explainer videos that will train you STEP by STEP without skipping any STEP
     to make you get the best of this software. Find <b><a href="javascript:;">expliner videos by clicking on this link</a></b> or 
     close this dialog box by clicking the finish button and navigate to explainer videos on your left hand side tab. 
     ';
    $step->action_text = 'FINISH';
    $step->link = admin_url('?completed_wizard=yes');
}
$step_percentage = (int) (($step_num / $step_tot) * 100);

if ($step_percentage < 25) {
    $step_text = $step_percentage . '%';
} else {
    $step_text = "$step_percentage% Done";
}

?><div class="modal fade" id="exampleModalCenter" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-dark" id="exampleModalCenterTitle">
                    Welcome to ICT4Farmers
                </h2>
                <h4 class="p-0 m-0">Getting you started with your account in less than 5 minutes.</h4>
            </div>
            <div class="modal-body">

                <h2 class="text-center text-primary">STEP {{ $step_num }} of {{ $step_tot }}</h2>
                <div class="progress" style="; height: 30px">
                    <div class="progress-bar " role="progressbar"
                        style="width: {{ $step_percentage }}%; 30px; font-size:20px; padding-top: 5px;"
                        aria-valuenow="{{ $step_num }}" aria-valuemin="0" aria-valuemax="{{ $step_tot }}">
                        {{ $step_text }}</div>
                </div>
                <br>

                <h3 class="text-primary p-0 m-0">{{ $step->title }}</h3>
                <p>{!! $step->description !!}</p>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">EXIT</button> --}}
                <a type="button" id="next-button" class="btn btn-primary"
                    href="{{ $step->link }}">{{ $step->action_text }}</a>
            </div>


        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#exampleModalCenter').modal('show')

        $('#next-button').click(function(e) {
            e.preventDefault();
            $('#exampleModalCenter').modal('hide')
            window.location.href = e.target.href;
        });

    });
</script>
