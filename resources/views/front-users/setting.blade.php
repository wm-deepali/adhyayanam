@extends('front-users.layouts.app')

@section('title')
Test Series
@endsection

@section('content')
<!-- Main content -->
<section class="content">
			<div class="row">				
				<div class="col-12">
					<h4 class="text-dark">Security Settings</h4>
					<hr>
					 @include('front-users.layouts.includes.messages')
					<div class="box">
						<div class="box-body">
							<div class="d-md-flex justify-content-between align-items-center">
								<div>
									<h5 class="text-primary fw-500">Activity Logs</h5>
									<p class="mb-0">You can save your all activity logs including unusual activity detected.</p>
								</div>
								<button type="button" class="btn btn-sm btn-toggle btn-primary active toggle-class" data-bs-toggle="button" ontoggle="logActivity()">
									<span class="handle"></span>
							    </button>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="box-body">
							<div class="d-md-flex justify-content-between align-items-center">
								<div>
									<h5 class="text-primary fw-500">Change Password</h5>
									<p class="mb-0">Set a unique password to protect your account.</p>
								</div>
								<button class="btn btn-info" data-toggle="modal" data-target="#changePassModal">Change Password</button>
							</div>
						</div>
					</div>
					<!--div class="box">
						<div class="box-body">
							<div class="d-md-flex justify-content-between align-items-center">
								<div>
									<h5 class="text-primary fw-500">2 Step Verification</h5>
									<p class="mb-0 me-25">Secure your account with 2 Step security. When it is activated you will need to enter not only your password, but also a special code using app. You can receive this code by in mobile app.</p>
								</div>
								<a href="#" class="btn btn-danger">Enabled</a>
							</div>
						</div>
					</div-->
				</div>			
				<div class="col-12">
					<h4 class="text-dark">Activity Log</h4>
					<hr>
					<div class="box">
						<div class="box-body p-0">
							<div class="table-responsive">
							  <table class="table mb-0">
								  <thead>
									<tr>
									    <th scope="col">Activity</th>
									  <th scope="col">Browser</th>
									  <th scope="col">IP Address</th>
									  <th scope="col">Date/Time</th>
									  <th scope="col">Action</th>
									</tr>
								  </thead>
								  <tbody>
								      @foreach($logs as $log)
									<tr>
									  <th scope="row">{{$log->subject}}</th>
									  <td>{{$log->agent}}</td>
									  <td>{{$log->ip}}</td>
									  <td>{{ date('d/m/Y : g:i:A', strtotime($log->created_at))}}</td>
									  <td>
									      <form action="{{ route('user-activity.destroy', $log->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="text-danger"><i class="fa fa-trash"></i></button>
                                           </form>
									      
									  </td>
									</tr>
									@endforeach
								  </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- Modal -->
<div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="changePassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changePassModalLabel">Change Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="changePasswordForm" method="post"> 
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" name="current_password" placeholder="Current Password" id="current_password" required>
                    <span id="current_password_msg" style="display:none" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="new_password" placeholder="New Password" id="new_password" required>
                    <span id="new_password_msg" style="display:none" class="text-danger"></span>
                </div>
                 <div class="mb-3">
                    <label for="confirm_pass" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_pass" placeholder="Confirm Password" required onkeyup="validate_passwords()">
                    <span id="confirm_pass_msg" style="display:none" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <span id="wrong_pass_alert_msg"></span>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updatePassword">Change Password</button>
            </div>
        </div>
    </div>
</div>
			
</section>
<!-- /.content -->
<!-- /.content -->
@endsection

@push('after-scripts')
    <script>
        function validate_passwords() {
 
            let pass = document.getElementById('new_password').value;
            let confirm_pass = document.getElementById('confirm_pass').value;
            if (pass != confirm_pass) {
                document.getElementById('wrong_pass_alert_msg').style.color = 'red';
                document.getElementById('wrong_pass_alert_msg').innerHTML
                    = '☒ Use same password';
                document.getElementById('updatePassword').disabled = true;
                document.getElementById('updatePassword').style.opacity = (0.4);
            } else {
                document.getElementById('wrong_pass_alert_msg').style.color = 'green';
                document.getElementById('wrong_pass_alert_msg').innerHTML =
                    '🗹 Password Matched';
                document.getElementById('updatePassword').disabled = false;
                document.getElementById('updatePassword').style.opacity = (1);
            }
        }

$('#updatePassword').on("click",function (e) {
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
            check_field("current_password");
            check_field("new_password");
            check_field("confirm_pass");
            
            if(flag==false)
            {
                return false;
            }
            e.preventDefault();
            var data = new FormData($('#changePasswordForm')[0]);//form name
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('change-student-password')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                crossDomain: false,
                success: function(result){
                    
                if (result.success) {
                        alert(result.message)
                        
                        window.location.href= `{{url('/user/setting')}}`
                        sessionStorage.setItem('otpVerified', 'true');
                    
                } 
                else
                {
                    if(result.code == 422)
                    {
                        $(`#current_password_msg`).fadeIn(200).show().html(result.message);
                            
                    }
                    
                }
                        
            },
        });
                
                
    });
	



	
    </script>
@endpush