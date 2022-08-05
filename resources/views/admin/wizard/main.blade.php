<?php
use App\Models\Utils;
$steps = Utils::get_wizard_actions(1);
$steps = array_reverse($steps);
$step = $steps[0];
$step_num = 1;
$step_text = 1;
$step_tot = count($steps);
$step_percentage = 0;
foreach ($steps as $s) {
    if (!$s->is_done) {
        $step = $s;
        $step_num = $s->id;
        $step_percentage = ($step_num / $step_tot) * 100;
    }
}

if ($step_num < 30) {
    $step_text = '';
} else {
    $step_text = "SETP $step_num of $step_tot";
}

?><div class="modal fade" id="exampleModalCenter" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-dark" id="exampleModalCenterTitle">
                    Welcome to ICT4Farmers
                </h2>
            </div>
            <div class="modal-body">
                <h4 class="p-0 m-0">Getting you started with your account in less than 5 minutes.</h4>

                <div class="progress" style="; height: 30px">
                    <div class="progress-bar " role="progressbar"
                        style="width: {{ $step_tot }}%; 30px; font-size:20px; padding-top: 5px;"
                        aria-valuenow="{{ $step_num }}" aria-valuemin="0" aria-valuemax="{{ $step_tot }}">
                        {{ $step_text }}</div>
                </div>

                <h3 class="text-primary p-0 m-0"><b>STEP {{ $step_num }}.</b>{{ $step->title }}</h3>
                <p>{{ $step->description }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">EXIT</button>
                <a type="button" class="btn btn-primary" href="{{ $step->link }}">{{ $step->action_text }}</a>
            </div>


        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#exampleModalCenter').modal('show')
    });
</script>
