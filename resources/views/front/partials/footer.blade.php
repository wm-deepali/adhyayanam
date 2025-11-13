<style>
    .otp-input{
    width: 50px;
    margin-right: 20px;
}
#hiddenInput{
    margin-bottom:30px;
}
</style>
<footer class="main-footer">
	<!--Waves end-->
	<div class="auto-container">
		<!--Widgets Section-->
		<div class="widgets-section">
			<div class="row clearfix">
				<!-- <div class="footer-column col-lg-4 col-md-4 col-sm-12">
							<div class="footer-widget logo-widget">
								<div class="logo">
									<a href="index-2.html"><img src="images/Neti-logo-white.svg" alt="" /></a>
								</div>
								<div class="text">We believe in making the world a better experience Nam libero templorem cum soluta
									agency</div>
								<ul class="social-box">
									<li><a href="https://www.facebook.com/" class="flaticon-facebook"></a></li>
									<li><a href="https://www.instagram.com/" class="flaticon-instagram"></a></li>
									<li><a href="https://www.twitter.com/" class="flaticon-twitter"></a></li>
								</ul>
							</div>
						</div> -->
				<div class="footer-column col-lg-3 col-md-4 col-sm-12">
					<div class="footer-widget links-widget">
						<h4>Our Institute</h4>
						<ul class="list-link">
							<li><a href="{{route('about')}}">About Us</a></li>
							<li><a href="{{route('our.team.index')}}">Our Team</a></li>
							<li><a href="{{route('vision.mission')}}">Our Vision & Mission</a></li>
							<li><a href="{{route('feed.back.index')}}">Feedback & Testimonials</a></li>
							<li><a href="{{route('enquiry.direct')}}">Enquiry Form</a></li>
							<li><a href="{{route('contact.inquiry')}}">Contact Us</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-column col-lg-3 col-md-4 col-sm-12">

					<div class="footer-widget links-widget">
						<h4>Student Corner</h4>
						<ul class="list-link">
							<li><a href="{{route('current.index')}}">Current Affairs</a></li>
							<li><a href="{{route('upcoming.exam.front')}}">Upcoming Exams</a></li>
							<li><a href="{{route('batches.index')}}">Batches & Online Programme</a></li>
							<li><a href="#">Workshops & Open Sessions</a></li>
							<li><a href="{{route('neti.corner.index')}}">Adhyayanam Education Corner</a></li>
							<li><a href="{{route('callback.inquiry')}}">Call Back Request</a></li>
							<li><a href="{{route('faq')}}">FAQ</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-column col-lg-3 col-md-4 col-sm-12">

					<div class="footer-widget links-widget">
						<h4>Courses & Test Series</h4>
						<ul class="list-link">
							<li><a href="{{route('courses')}}">Our Courses</a></li>
							<li><a href="test-series.html">Test Series</a></li>
							<li><a href="#">PYQ</a></li>
							<li><a href="{{route('study.material.front')}}">Study Material</a></li>
							<li><a href="{{route('daily.boost.front')}}">Daily Booster</a></li>
							<li><a href="{{route('test.planner.front')}}">Test Planner</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-column col-lg-3 col-md-4 col-sm-12">

					<div class="footer-widget links-widget">
						<h4>Others</h4>
						<ul class="list-link">
							<li><a href="{{route('term.conditions')}}">Terms & Conditions</a></li>
							<li><a href="{{route('privacy.policy')}}">Privacy Policy</a></li>
							<li><a href="{{route('refund.policy')}}">Refunds & Cancellation Policy</a></li>
							<li><a href="{{route('cookies.policy')}}">Cookies Policy</a></li>
							<li><a href="{{route('career')}}">Career</a></li>
							<li><a href="{{route('blog.articles')}}">Blogs & Articles</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>




	<!-- Footer Bottom -->
	<div class="footer-bottom">
		<div class="auto-container">
			<div class="row clearfix">
				<!-- Column -->
				<div class="column col-lg-6 col-md-12 col-sm-12">
					<div class="copyright">Copyright© 2024 All Rights Reserved</div>
				</div>
				<!-- Column -->
				<div class="column col-lg-6 col-md-12 col-sm-12">
					<div class="text">Design and Developed by WebMingo</div>
				</div>
			</div>
		</div>
	</div>

</footer>


</div>
<!-- Modal -->
<div class="modal fade" id="lr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<div class="progress-indicator">

				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="logo modals"><a href="{{url('/')}}"><img src="{{ url('images/Neti-logo.png')}}" alt="" title=""></a></div>
				<div class="get-start">
					Get started with Adhyayanam!
				</div>
				<div class="continue-w">Continue with your mobile number</div>
				<div class="form-login-reg comment-form modal-l">
					<div class="inner-frm contact-form">
						<div class="form-group" id="otpform">
							<input type="text" name="mobile_number" id="mobile_number" placeholder="Your Mobile Number*" >
						</div>
						<div  id="hiddenInput" style="display: none;">
                                <h6 class=" my-3" style="color: #8B2025">OTP</h6>
                                <div class=" d-flex justify-content-between">
                                    
                                    <input type="text" class="form-control col-2 otp-input" maxlength="1" autofocus >
                                    <input type="text" class="form-control col-2 otp-input" maxlength="1" >
                                    <input type="text" class="form-control col-2 otp-input" maxlength="1" >
                                    <input type="text" class="form-control col-2 otp-input" maxlength="1" >
                                    
                                    </div> 
                                    <div class="text-danger" id="otp-err"></div>
                                </div>
					
						<a href="#" class="osd-cus">
							<div class="cus-btn-osd" id="verify-btn">Continue</div>
							<button type="button" class="btn btn-primary" style="display:none" id="validate-otp">Verify Now</button>
						</a>
					</div>
					
				</div>
				<!--<div class="alredy-aacount">Already account? <a href="#">Login</a></div>-->
			</div>
		</div>
	</div>
</div>
<!--End pagewrapper-->
@php
$socialMediaSettings = App\Models\SocialMedia::first();
@endphp
<div class="wd-social-icons wd-sticky-social ">
	<a rel="noopener noreferrer nofollow" href="{{$socialMediaSettings->youtube}}" target="_blank" class=" wd-social-icon social-youtube" aria-label="Facebook social link">
						<span class="fa fa-youtube"></span>
													<span class="wd-icon-name y">Youtube</span>
											</a>
				
									<a rel="noopener noreferrer nofollow" href="{{$socialMediaSettings->facebook}}" target="_blank" class=" wd-social-icon social-facebook" aria-label="Facebook social link">
						<span class="fa fa-facebook"></span>
													<span class="wd-icon-name f">Facebook</span>
											</a>
											<a rel="noopener noreferrer nofollow" href="{{$socialMediaSettings->instagram}}" target="_blank" class=" wd-social-icon social-instagram" aria-label="Facebook social link">
						<span class="fa fa-instagram"></span>
													<span class="wd-icon-name i">Instagram</span>
											</a>
												<a rel="noopener noreferrer nofollow" href="{{$socialMediaSettings->linkdin}}" target="_blank" class=" wd-social-icon social-linkedin" aria-label="Facebook social link">
						<span class="fa fa-linkedin"></span>
													<span class="wd-icon-name l">LinkedIn</span>
											</a>
												<a rel="noopener noreferrer nofollow" href="{{$socialMediaSettings->twitter}}" target="_blank" class=" wd-social-icon social-twitter" aria-label="Facebook social link">
						<span class="fa fa-twitter"></span>
													<span class="wd-icon-name t">Twitter</span>
											</a>
												<a rel="noopener noreferrer nofollow" href="{{$socialMediaSettings->whatsapp}}" target="_blank" class=" wd-social-icon social-whatsapp" aria-label="Facebook social link">
						<span class="fa fa-whatsapp"></span>
													<span class="wd-icon-name w">WhatsApp</span>
											</a>
										
			</div>

<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-up"></span></div>

<script src="{{url('assets/js/jquery.js')}}"></script>
<script src="{{url('assets/js/popper.min.js')}}"></script>
<script src="{{url('assets/js/bootstrap.min.js')}}"></script>
<script src="{{url('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{url('assets/js/jquery.fancybox.js')}}"></script>
<script src="{{url('assets/js/appear.js')}}"></script>
<script src="{{url('assets/js/tilt.jquery.min.js')}}"></script>
<script src="{{url('assets/js/owl.js')}}"></script>
<script src="{{url('assets/js/wow.js')}}"></script>
<script src="{{url('assets/js/nav-tool.js')}}"></script>
<script src="{{url('assets/js/jquery-ui.js')}}"></script>
<script src="{{url('assets/js/script.js')}}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script>
 document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (event) => {
            const currentValue = event.target.value;
            const maxLength = parseInt(event.target.getAttribute('maxlength'));
            
            if (currentValue.length >= maxLength) {
                // Move to the next input field if available
                const nextIndex = index + 1;
                if (nextIndex < otpInputs.length) {
                    otpInputs[nextIndex].focus();
                }
            }
        });

        // Allow only numeric input
        input.addEventListener('keydown', (event) => {
            const key = event.key;
            const isValidInput = /^\d$/.test(key); // Only allow numeric input
            if (!isValidInput && key !== 'Backspace' && key !== 'Delete') {
                event.preventDefault();
            }
        });
    });
});
     $("#verify-btn").click(function(){
        $(".validation-err").html('');
        var data = $(this)
        var mobilenumber = $("#mobile_number").val();
        let formData = new FormData();
        formData.append('mobile_number', mobilenumber);
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
                url: "{{ URL::to('sendotopstudent') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function(result) {
                    if (result.success) {
                        // $("#verifymobilemodal").modal("show")
                     //   data.text("Verify Now")
                        $("#hiddenInput").removeAttr("style")
                        $("#verify-btn").css("display","none")
                        $("#validate-otp").removeAttr("style")
                    } else {
                        $(this).attr('disabled', false);
                        if(result.code == 402){
                        }
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            console.log(result);
                        }
                    }
                }
            });
    })
    
     $(document).on("click","#validate-otp",function(){
        $(".validation-err").html('');
        var mobilenumber = $("#mobile_number").val();
       let otp = ''; 
            $('.otp-input').each(function() {
                otp += $(this).val();
            });
        let formData = new FormData();
        formData.append('mobile_number', mobilenumber);
        formData.append('otp', otp);
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
                url: "{{ URL::to('verifymobilenumberstudent') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: 'json',
                data: formData,
                context: this,
                success: function(result) {
                    if (result.success) {
                        alert("Verified Suceessfully")
                        $("#otpform").remove();
						if(result.profile == 1)
						{
							location.reload();
						}
						else{
							window.location.href= `{{url('/user/dashboard')}}`
						}
                        
                       //location.reload();
                        sessionStorage.setItem('otpVerified', 'true');
                      
                       
                    } else {
                        $(this).attr('disabled', false);
                        if (result.code == 422) {
                            for (const key in result.errors) {
                                $(`#${key}-err`).html(result.errors[key][0]);
                            }
                        } else {
                            $(`#otp-err`).html(result.message);
                        }
                    }
                }
            });
    })
</script>
