@extends('front.partials.app')
@section('header')
  <title>{{'Feedback & Testinomial'}}</title>
@endsection

<style>
  .rating-box {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 14px 16px;
  }

  .stars {
    display: flex;
    gap: 6px;
  }

  .star {
    font-size: 28px;
    color: #dcdcdc;
    cursor: pointer;
    transition: 0.2s ease;
  }

  .star:hover {
    transform: scale(1.15);
  }

  .star.active {
    color: #f4b400;
  }

  .rating-text {
    display: block;
    margin-top: 4px;
    font-size: 13px;
    color: #777;
  }
</style>

@section('content')

  <body class="hidden-bar-wrapper">
    <!-- Page Title -->
    <section class="page-title">
      <div class="auto-container">
        <h2>Adhyayanam</h2>
        <ul class="bread-crumb clearfix">
          <li><a href="index.html">Home</a></li>
          <li>Feedback & Testinomial</li>
        </ul>
      </div>
    </section>
    <!-- End Page Title -->
    <section class="carrer-page">
      <div class="auto-container">
        <div class="form-column">
          <div class="inner-column osd-c">
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <div class="title-box mb-b">
              <h3>Submit Feedback & Testinomial</h3>
              <div class="text">Fill the form for Feedback & Testinomial!
              </div>
            </div>
            <!-- Comment Form -->
            <div class="comment-form contact-form">
              <form method="post" action="{{route('feed.back.store')}}" id="carrer-form" enctype="multipart/form-data">
                @csrf
                <div class="row clearfix">

                  <div class="col-lg-12 form-group">

                    <div class="rating-box">
                      <input type="hidden" name="rating" id="ratingValue">

                      <div class="stars">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                      </div>

                      <small id="ratingText" class="rating-text">
                        Tap a star to rate
                      </small>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">

                    <select class="form-control" name="type" id="typeSelect" required>
                      <option value="">Select Option</option>
                      <option value="1">Feedback</option>
                      <option value="2">Testimonial</option>
                    </select>
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <input type="text" name="username" placeholder="Your name*" required="">
                  </div>
                  
                  <input type="hidden" name="designation" value="Student">

                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <input type="text" name="email" placeholder="Email Address" required="">
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <input type="text" name="number" placeholder="Mobile Number" required="">
                  </div>


                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <textarea class="" name="message" placeholder="Enter detail"></textarea>
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label>Add Photo</label>
                    <input type="file" name="photo" placeholder="Browse Photo" required="">
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <!-- Button Box -->
                    <div class="button-box">
                      <button type="submit" class="theme-btn submit-btn">
                        Submit now
                      </button>
                    </div>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>

  <script>
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('ratingValue');
    const ratingText = document.getElementById('ratingText');

    const ratingLabels = {
      1: "Poor 😞",
      2: "Fair 🙂",
      3: "Good 👍",
      4: "Very Good 😃",
      5: "Excellent 🤩"
    };

    stars.forEach(star => {

      star.addEventListener('mouseover', () => {
        highlightStars(star.dataset.value);
      });

      star.addEventListener('mouseout', () => {
        highlightStars(ratingValue.value);
      });

      star.addEventListener('click', () => {
        ratingValue.value = star.dataset.value;
        highlightStars(star.dataset.value);
        ratingText.innerHTML = ratingLabels[star.dataset.value];
      });

    });

    function highlightStars(value) {
      stars.forEach(star => {
        star.classList.toggle('active', star.dataset.value <= value);
      });
    }
  </script>
@endsection