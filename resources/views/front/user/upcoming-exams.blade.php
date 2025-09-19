@extends('front.partials.app')
@section('header')
		<title>{{'Upcoming Exams'}}</title>
@endsection
@section('content')
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="index.html">Home</a></li>
        <li>Upcomming Exams</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="course-page-section-two">
    <div class="auto-container">
      @foreach($upcomingExams as $data)
      <div class="table-osd mb-5">
        <table class="osd-table" style="border-collapse: collapse; width: 100%;">
          <tbody>
            <tr>
              <td style="text-align: center; width: 99.7282%;" class="f22" colspan="6"><strong>Government
                  Exams Upcoming:
                  {{$data->exam_commission->name}}</strong></td>
            </tr>
            <tr>
              <td style="text-align: center; ">
                <p><strong>Name of Exam</strong></p>
              </td>
              <td style="text-align: center;">
                <p><strong>Date of Advertisement</strong></p>
              </td>
              <td style="text-align: center;">
                <p><strong>Exam Date</strong></p>
              </td>
              <td style="text-align: center;">
                <p><strong>Closing Date</strong></p>
              </td>
              <td style="text-align: center; ">
                <p><strong>Upcoming Government Exams 2024 Dates</strong></p>
              </td>
              <td style="text-align: center;">
                <p><strong>Download Details</strong></p>
              </td>
            </tr>
            
             <tr>
              <td style="text-align: center; ">
                <p><strong>{{$data->examination_name}}</strong></p>
              </td>
              <td style="text-align: center; ">{{$data->advertisement_date}}</td>
              <td style="text-align: center;">{{$data->examination_date}}</td>
              <td style="text-align: center;">{{$data->submission_last_date}}</td>
              <td style="text-align: center;">{{$data->form_distribution_date}}</td>
              <td style="text-align: center;"><a href="{{asset('public/storage/'.$data->pdf)}}" target="_blank" rel="noopener" download="{{$data->examination_name}}"><img
                    src="{{url('/images/eye-black.png')}}" alt="" /></a></td>
            </tr>
          </tbody>
        </table>
      </div>
      @endforeach
  </section>
</body>
@endsection