@extends('front.partials.app')
@section('header')
	<title>{{ 'PYQ SubjectWise Papers' }}</title>
	<meta name="description" content="{{ $seo->description ?? 'Default Description' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? 'default, keywords' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">
@endsection
@section('content')
<body class="hidden-bar-wrapper">
	<!-- Page Title -->
	<section class="page-title">
		<div class="auto-container">
			<h2>Adhyayanam</h2>
			<ul class="bread-crumb clearfix">
				<li><a href="{{url('/')}}">Home</a></li>
				<li>PYQ SubjectWise Papers</li>
			</ul>
		</div>
	</section>
	<!-- End Page Title -->

	<section class="course-page-section-two">
    <div class="auto-container">

      <div class="top-banner-sm">
        <div class="image">
          <img src="images/main-slider/slider2.png" alt="">
        </div>
      </div>
      
      <div class="smaterial-box">
        <div class="content">
          <h4 class="osd sm">Papers For {{$subject->name}}</h4>
          <div class="row">
		  @if(isset($papers) && count($papers) >0)
			@foreach($papers as $paper)
            <div class="col-sm-12 col-md-6">
              <div class="cm-all a"><a href="{{url('../storage/app/pyq-pdf',$paper->pyq->pdf)}}"  target="_blank">{{$paper->pyq->pdf}}</a></div>
            </div>
            @endforeach
			@endif
            


          </div>
        </div>

      </div>
      <div class="smaterial-boxs">
        <div class="content">
          <h3 class="osd sm">{!! $pyq_content->heading ?? "" !!}</h3>
          <p class="text-justify">{!! $pyq_content->detail_content ?? "" !!}</p>
        </div>

      </div>
      <div class="mcq-details">
        <h2 class="mcq-hading">Multiple choice questions (MCQ's)</h2>
        @foreach($questions as $key=>$question)
        <div class="mcq-cont">
          <h4>{{++$key}}) {{$question->question}} -</h4>
          <ol class="pointsa">
            <li>{{$question->option_a}}</li>
            <li>{{$question->option_b}}</li>
            <li>{{$question->option_c}}</li>
            <li>{{$question->option_d}}</li>
            @if($question->has_option_e == 1 )
            <li>{{$question->option_e}}</li>
            @endif
          </ol>
          <div class="show-ans-btn">
            <button class="showanswer" data-answer="answer{{$key}}">
              <img src="/images/eye-black.png" />
              <div id="btntext1">Show/Hide Answer</div>
            </button>
          </div>
          <div class="testanswer" id="answer{{$key}}" style="display: none;">
            <p>
                @if(ucfirst($question->answer) == "A")
                {{$question->option_a}}
                @elseif(ucfirst($question->answer) == "B")
                {{$question->option_b}}
                @elseif(ucfirst($question->answer) == "C")
                {{$question->option_c}}
                @elseif(ucfirst($question->answer) == "D")
                {{$question->option_d}}
                @elseif(ucfirst($question->answer) == "E")
                {{$question->option_e}}
                @endif
            </p>
          </div>
        </div>
        @endforeach
      </div>

  </section>
  <script>
      $(".showanswer").click(function(){
          var data = $(this).data("answer")
          $(`#${data}`).toggle();
      })
  </script>
</body>
@endsection