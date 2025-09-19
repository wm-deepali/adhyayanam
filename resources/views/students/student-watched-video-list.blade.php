@extends('layouts.app')

@section('title')
Current Affair
@endsection

@section('content')
<style>
    td {
	vertical-align: middle;
}
.progress-thin {
	height: 10px;
}
.video-osd {
	display: flex;
	gap: 25px;
}
.video-tittle {
	font-size: 18px;
	font-weight: 600;
}
.c-name {
	font-size: 16px;
}
.video-osd {
	border-bottom: 1px solid #cbcbcb;
	margin-bottom:10px;
}
@media only screen and (max-width: 900px) {
  .video-osd {
	display: block;
	gap: 25px;
}
.video-osd {
	padding: 20px 0;
}
}
</style>
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student Video Analysis</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage Current Affair here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
    <!--           <table class="table table-striped mt-5">-->
    <!--    <thead>-->
    <!--        <tr>-->
    <!--            <th>#</th>-->
    <!--            <th>Number of Times Watched</th>-->
    <!--            <th>Completion Progress</th>-->
    <!--        </tr>-->
    <!--    </thead>-->
    <!--    <tbody>-->
    <!--                    <tr>-->
    <!--            <td><img src="/storage/topic/kU6L3C5gUizkJ4BZuXiXNne1aq99OmRBfphN6Qbe.png" alt="" style="max-width: 100px;"></td>-->
    <!--            <td>1200</td>-->
    <!--             <td>-->
    <!--                 <div class="progress progress-thin my-2">-->
    <!--                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
    <!--            </div>-->
    <!--             </td>-->
    <!--        </tr>-->
    <!--        <tr>-->
    <!--            <td><img src="/storage/topic/kU6L3C5gUizkJ4BZuXiXNne1aq99OmRBfphN6Qbe.png" alt="" style="max-width: 100px;"></td>-->
    <!--            <td>1200</td>-->
    <!--             <td>-->
    <!--                 <div class="progress progress-thin my-2">-->
    <!--                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
    <!--            </div>-->
    <!--             </td>-->
    <!--        </tr>-->
    <!--                </tbody>-->
    <!--</table>-->
    <div class="video-osd">
        <div class="vode-left"><video autoplay="" loop="" controls="" width="250" height="200">
<source type="video/mp4" src="https://endtest-videos.s3-us-west-2.amazonaws.com/documentation/endtest_data_driven_testing_csv.mp4">
</video></div>
<div class="video-right-desc">
    <div class="video-tittle">Video Tittle</div>
    <div class="c-name"><b>Course Name:</b> UPSC</div>
     <div class="progress progress-thin my-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
    <div class="twatches"><i class="fa fa-eye"></i> 4.3k</div>
</div>
    </div>
    <div class="video-osd">
        <div class="vode-left"><video autoplay="" loop="" controls="" width="250" height="200">
<source type="video/mp4" src="https://endtest-videos.s3-us-west-2.amazonaws.com/documentation/endtest_data_driven_testing_csv.mp4">
</video></div>
<div class="video-right-desc">
    <div class="video-tittle">Video Tittle</div>
    <div class="c-name"><b>Course Name:</b> UPSC</div>
    <div class="progress progress-thin my-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
    <div class="twatches"><i class="fa fa-eye"></i> 4.3k</div>
</div>
    </div>
            </div>

        </div>
    </div>
</div>
@endsection
