@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success alert-dismissible" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success alert-dismissible" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif
<style>
    .alert .close {
    color: #fff !important;
    opacity: 10 !important;
    float: right !important;
    text-decoration: none !important;
    font-size: 20px !important;
}
</style>