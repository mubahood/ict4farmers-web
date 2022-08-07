<style>
    .content-header {
        margin-bottom: 1rem;
    }

    .my-box-3 {
        color: black;
    }
    .my-box-3:hover {
        background-color: var(--primary);
        color: white;
    }
</style><?php
if (!isset($icon)) {
    $icon = 'icon-announcement.png';
}
if (!isset($count)) {
    $count = 0;
}
if (!isset($sub_title)) {
    $sub_title = '-';
}
if (!isset($title)) {
    $title = '-';
}

if (!isset($link)) {
    $link = admin_url();
}

?>
<a href="{{ $link }}" class="card rounded border-primary my-box-3 mb-5">
    <div class="card-body">
        <h2 class="h3 m-0 p-0 mb-2 ">{{ $title }}</h2>
        <div class="row pl-3 pb-0">
            <div class="col-3  p-0">
                <img width="60" height="60" src="{{ $icon }}" alt="">
            </div>
            <div class="col-9 p-0 ">
                <h2 class="p-0 m-0">{{ $count }}</h2>
                <p class="p-0 m-0">{{ $sub_title }}</p>
            </div>
        </div>
    </div>
</a>
