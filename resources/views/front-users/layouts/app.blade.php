<!DOCTYPE html>
<html lang="en">
  

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>
        @if (trim($__env->yieldContent('title')))
        @yield('title') | {{ config('app.name', 'adhyayanam') }}
        @else
        {{ config('app.name', 'adhyayanam') }}
        @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('before-styles')
    @stack('after-styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('src/css/vendors_css.css')}}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('src/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('src/css/skin_color.css')}}">
     	<link rel="shortcut icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">
	<link rel="icon" href="{{url('images/favicon.svg')}}" type="image/x-icon">
  </head>
<style>
    .fade:not(.show) {
    opacity: 1 !important;
}
.modal-dialog
{
    top:10%;
}
.modal-backdrop.fade {
opacity: 0 !important;
filter: alpha(opacity=0) !important;
}
label{
    width: 100% !important;
}
.modal-backdrop.fade.in {
opacity: 0.5 !important;
filter: alpha(opacity=50) !important;
}
</style>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
	@if(auth()->user() !='' && auth()->user()->email == '')
    <div id="over" style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index:999;opacity:0.4;filter: alpha(opacity = 50);background-color:#eee;"></div>

    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="progress-indicator">
                    <div class="continue-w">Register Details</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="logo modals"><a href="{{url('/')}}"><img src="{{url('images/Neti-logo.png')}}" alt="" title=""></a></div>
                    <div class="get-start">
                        Get started with Adhyayanam!
                    </div>
                    <br/>
                    <div class="form-login-reg comment-form modal-l">
                        <form  id="registerForm"> 
                            <div class="inner-frm contact-form">
                                <div class="form-group">
                                <input type="hidden" name="id" id="id" value="{{auth()->user()->id}}">
                                    <label for="first_name" class="col-sm-2 control-label">First Name* </label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Your First Name*" >
                                    <span id="first_name_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="col-sm-2 control-label">Last Name* </label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Your Last Name*" >
                                    <span id="last_name_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email* </label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email Id*" >
                                    <span id="email_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="date_of_birth" class="col-sm-2 control-label">Date Of Birth* </label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="Your Date Of Birth*" >
                                    <span id="date_of_birth_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="gender" class="col-sm-2 control-label">Gender* </label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">Choose Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <span id="gender_msg" style="display:none" class="text-danger"></span>
                                </div>

                                <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password* </label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password*" >
                                    <span id="password_msg" style="display:none" class="text-danger"></span>
                                </div>

                                <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">Confirm Password* </label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password*" onkeyup="validate_password()">
                                    <span id="confirm_password_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                <span id="wrong_pass_alert"></span>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-md btn-primary" id="saveUser">Submit</button>
                                </div>
                            </div>
                        </Form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
<div class="wrapper">
	<div id="loader"></div>
	
    @include('front-users.layouts.includes.header')
  
    @include('front-users.layouts.navigation')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Errors block -->
        @include('front-users.layouts.includes.errors')
        <!-- / Errors block -->
        @yield('content')
		
	  </div>
  </div>
  <!-- /.content-wrapper -->
	
  @include('front-users.layouts.includes.footer')
  @include('front-users.layouts.includes.side-modal')
  @include('front-users.layouts.includes.sidebar')  
  
  
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>	
	
</div>
<!-- ./wrapper -->
	
			
	
	
	<!-- Page Content overlay -->
	
    @stack('before-scripts')
	<!-- Vendor JS -->

	<script src="{{ asset('src/js/vendors.min.js')}}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<script src="{{ asset('src/js/pages/chat-popup.js')}}"></script>
    <script src="{{ asset('src/assets/icons/feather-icons/feather.min.js')}}"></script>
	
	<script src="{{ asset('src/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js')}}"></script>
	<script src="{{ asset('src/assets/vendor_components/moment/min/moment.min.js')}}"></script>
	<script src="{{ asset('src/assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>	
	
	<!-- edulearn App -->
	<script src="{{ asset('src/js/demo.js')}}"></script>
	<script src="{{ asset('src/js/template.js')}}"></script>
	<script src="{{ asset('src/js/pages/dashboard.js')}}"></script>
    @stack('after-scripts')
    <!-- / Scripts -->
    <script>
        if(jQuery("#registerModal").length != 0) {
            jQuery('#registerModal').modal({backdrop: 'static', keyboard: false})  
            jQuery("#registerModal").modal();
        
            function validate_password() {
 
                let pass = document.getElementById('password').value;
                let confirm_pass = document.getElementById('confirm_password').value;
                if (pass != confirm_pass) {
                    document.getElementById('wrong_pass_alert').style.color = 'red';
                    document.getElementById('wrong_pass_alert').innerHTML
                        = '☒ Use same password';
                    document.getElementById('saveUser').disabled = true;
                    document.getElementById('saveUser').style.opacity = (0.4);
                } else {
                    document.getElementById('wrong_pass_alert').style.color = 'green';
                    document.getElementById('wrong_pass_alert').innerHTML =
                        '🗹 Password Matched';
                    document.getElementById('saveUser').disabled = false;
                    document.getElementById('saveUser').style.opacity = (1);
                }
            }

            $('#saveUser').on("click",function (e) {
                var flag=true;
                function check_field(id)
                {
            
                    if(!$("#"+id).val() ) //Also check Others????
                    {
            
                        $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
                        // $('#'+id).css({'background-color' : '#E8E2E9'});
                        flag=false;
                    }
                    else
                    {
                        $('#'+id+'_msg').fadeOut(200).hide();
                        //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
                    }
                }
            
                //Validate Input box or selection box should not be blank or empty
                check_field("first_name");
                check_field("last_name");
                check_field("email");
                check_field("gender");
                check_field("date_of_birth");
                check_field("password");
                check_field("confirm_password");
                if(flag==false)
                {
                    return false;
                }
                e.preventDefault();
                var data = new FormData($('#registerForm')[0]);//form name
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('register-student')}}",
                    type: 'POST',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result){
                    if (result.success) {
                            alert("Registered Suceessfully")
                            window.location.href= `{{url('/user/dashboard')}}`
                            //location.reload();
                            sessionStorage.setItem('otpVerified', 'true');
                            
                            
                    } else {
                        if(result.code == 422)
                        {
                            if(result.errors)
                            {
                                for (const key in result.errors) {
                                    $(`#${key}_msg`).fadeIn(200).show().html(result.errors[key][0]);
                                }
                            
                            }
                        }
                    }
                            
                            
                        
                    },
                    });
                
                
            });
        }
        
        
    </script>
     
</body>

</html>
