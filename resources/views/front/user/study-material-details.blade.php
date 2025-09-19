@extends('front.partials.app')
@section('header')
  <title>{{$studyMaterial->meta_title}}</title>
  <meta name="description" content="{{ $studyMaterial->meta_description ?? 'Default Description' }}">
  <meta name="keywords" content="{{ $studyMaterial->meta_keywords ?? 'default, keywords' }}">   
@endsection
@section('content')
<style>
  .collapse-content {
      max-height: 0px; /* Adjust the max-height as needed */
      overflow: hidden;
      transition: max-height 0.5s ease;
  }
  
  .collapse-content.expanded {
      max-height: none;
  }
  </style> 
<body class="hidden-bar-wrapper">
  <!-- Page Title -->
  <section class="page-title">
    <div class="auto-container">
      <h2>Adhyayanam</h2>
      <ul class="bread-crumb clearfix">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>{{$studyMaterial->title}} Details</li>
      </ul>
    </div>
  </section>
  <!-- End Page Title -->
  <section class="course-page-section-two">
    <div class="auto-container">

      <div class="top-banner-sm">
        <div class="image">
          <img src="{{ url('storage/'.$studyMaterial->banner) }}" alt="{{ $studyMaterial->title }}">
          @if($studyMaterial->IsPaid)
          <div class="label-red">Paid</div>
          @endif
        </div>
      </div>

      <div class="smaterial-boxs">
        <div class="content">
          <div class="row osd-x">
              <div class="col-sm-12 col-md-8 osd smosd">
                  <h3 class="osd sm x">{{ $studyMaterial->title }}</h3>
                  <p class="osd">{{ $studyMaterial->short_description }}</p>
              </div>
              @if($studyMaterial->IsPaid == 1)
              <div class="col-sm-12 col-md-4">
                  <div class="osd-sq">
                    
                  @if($studyMaterial->discount !='' && $studyMaterial->discount > 0)
                    <div class="osd-price-lav"><b>&#8377;{{$studyMaterial->price}}</b> <strike>&#8377;{{$studyMaterial->mrp}}</strike></div>
                  @else
                  <div class="osd-price-lav"><b>&#8377;{{$studyMaterial->price}}</b></div>
                  @endif
                    <div class="mockup-start-btn">
                    @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
                      @php
                        $user_id = auth()->user()->id;
                        $package_id = $studyMaterial->id;
                        $type ='Study Material';
                        $checkExist = Helper::GetStudentOrder($type,$package_id,$user_id)
                      @endphp
                      @if(!$checkExist)
                        <a href="{{route('user.process-order',['type' => 'study-material', 'id' => $studyMaterial->id])}}" class="osd-cus s">Buy Now</a>
                      @endif
                    @else
                    <a data-bs-toggle="modal" data-bs-target="#lr" class="osd-cus s">Buy Now</a>
                    @endif
                        
                    </div>
                  </div>
              </div>
              @endif
              
          </div>

          <div>
            {!! Str::limit($studyMaterial->detail_content, 150, '') !!} 
            @if (strlen($studyMaterial->detail_content) > 150)
              <span id="dots-{{ $studyMaterial->id }}">...</span>
              <span id="more-{{ $studyMaterial->id }}" style="display: none;">{!! substr($studyMaterial->detail_content, 150) !!}</span>
            @endif
          </div>
          <div class="col-12 d-flex justify-content-center">
          <button type="button" class="btn btn-secondary mt-3" onclick="loadMore({{ $studyMaterial->id }})" id="read-more-btn">Read More</button>
          </div>
          
          <div class="pdf-nt">
            <div class="mockup-start-btn">

          @if(auth()->user() && auth()->user()->email !='' && auth()->user()->type =='student')
            @php
              $user_id = auth()->user()->id;
              $package_id = $studyMaterial->id;
              $type ='Study Material';
              $checkExist = Helper::GetStudentOrder($type,$package_id,$user_id)
            @endphp
            @if($checkExist)
            <a class="osd-cus s"  type="button" href="{{ asset('storage/' . $studyMaterial->pdf) }}" download="{{ $studyMaterial->topic }}">Download PDF</a>
            @endif     
          @elseif($studyMaterial->IsPaid == 0)
          <a class="osd-cus s"  type="button" href="{{ asset('storage/' . $studyMaterial->pdf) }}" download="{{ $studyMaterial->topic }}">Download PDF</a>
          @endif
            </div>     
        </div>
        </div>

      </div>

  </section>
</body>
<script>
  function loadMore(id) {
    const readMoreBtn = document.getElementById('read-more-btn');
  var dots = document.getElementById("dots-" + id);
  var moreText = document.getElementById("more-" + id);
  if (moreText.style.display === "none") {
    moreText.style.display = "inline";
    dots.style.display = "none";
    readMoreBtn.textContent = 'Read Less';
  } else {
    moreText.style.display = "none";
    dots.style.display = "inline";
    readMoreBtn.textContent = 'Read More';
  }
}
  document.addEventListener('DOMContentLoaded', (event) => {
      // const readMoreBtn = document.getElementById('read-more-btn');
      // const detailContent = document.getElementById('detail-content');
  
      // readMoreBtn.addEventListener('click', () => {
      //     if (detailContent.classList.contains('expanded')) {
      //         detailContent.classList.remove('expanded');
      //         readMoreBtn.textContent = 'Read More';
      //     } else {
      //         detailContent.classList.add('expanded');
      //         readMoreBtn.textContent = 'Read Less';
      //     }
      // });
  });
</script>  
@endsection