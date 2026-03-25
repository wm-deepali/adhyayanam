<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Adhyayanam</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

  <style>
    body {
      background: linear-gradient(135deg, #f5f7ff, #e8ecff);
      min-height: 100vh;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 30px 15px;
    }

    .login-card {
      background: white;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 70px rgba(0, 0, 0, 0.12);
      border: none;
      max-width: 70%;
      margin: auto;
    }

    .left-image {
      background: linear-gradient(rgba(13, 110, 253, 0.78), rgba(0, 123, 255, 0.88)),
                  url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 70px 40px;
      height:100%;
    }

    .left-image h2 {
      font-size: 2.6rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 0 3px 12px rgba(0,0,0,0.5);
    }

    .left-image p {
      font-size: 1.05rem;
      opacity: 0.92;
      max-width: 100%;
      line-height: 1.6;
    }

    .right-form {
      padding: 50px 45px;
    }

    .form-heading {
      font-size: 1.95rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 0.6rem;
    }

    .form-desc {
      color: #6b7280;
      font-size: 0.95rem;
      margin-bottom: 2rem;
      line-height: 1.5;
    }

    .form-label {
      font-size: 0.92rem;
      font-weight: 600;
      color: #374151;
      margin-bottom: 6px;
    }

    .input-group .form-control {
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 1rem;
      border: 1px solid #d1d5db;
    }

    .country-code {
      border-radius: 10px 0 0 10px;
      background: #f3f4f6;
      border-right: none;
      width: 100px;
      font-size: 0.95rem;
      font-weight: 500;
      padding: 12px;
      text-align: center;
    }

    .resend-link {
      font-size: 0.9rem;
      color: #3b82f6;
      text-decoration: none;
      transition: all 0.25s ease;
      cursor: pointer;
    }

    .resend-link:hover {
      color: #2563eb;
      text-decoration: underline;
    }

    .otp-container {
      display: flex;
      gap: 14px;
      justify-content: start;
      margin: 1rem 0 1.5rem;
    }

    .otp-input {
      width: 55px;
      height: 55px;
      font-size: 1.6rem;
      font-weight: 600;
      text-align: center;
      border: 2px solid #d1d5db;
      border-radius: 10px;
      transition: all 0.2s;
    }

    .otp-input:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
      outline: none;
    }

    .btn-send-otp, .btn-verify {
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.3s;
    }

    .btn-send-otp {
      background: #3b82f6;
      border: none;
    }

    .btn-send-otp:hover {
      background: #2563eb;
      transform: translateY(-2px);
    }

    .btn-verify {
      background: linear-gradient(90deg, #10b981, #34d399);
      border: none;
    }

    .btn-verify:hover {
      background: linear-gradient(90deg, #059669, #10b981);
      transform: translateY(-2px);
    }

    .otp-hidden {
      display: none;
    }

    @media (max-width: 991px) {
      .left-image {
        min-height: 320px;
        padding: 40px 25px;
      }
      .right-form {
        padding: 40px 15px;
      }
      .login-card {
        /*margin: 20px;*/
      }
      .login-wrapper {
    min-height: auto;
    display: flex;
    align-items: center;
    padding: 30px 15px;
}
.login-card {
    background: white;
    border-radius: 7px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.12);
    border: none;
    max-width: 100%;
    margin: auto;
}
    }
  </style>
</head>
<body>

  <div class="login-wrapper">
    <div class="container">
      <div class="row g-0 login-card">

        <!-- Left Side - Image with overlay -->
        <div class="col-lg-6 d-none d-lg-block">
          <div class="left-image">
            <div>
              <h2>Welcome Back</h2>
              <p>Login to continue your preparation journey with structured tests, daily boosters, and expert guidance.</p>
            </div>
          </div>
        </div>

        <!-- Right Side - Form -->
        <div class="col-lg-6">
          <div class="right-form">
            <h2 class="form-heading text-center text-lg-start">Login</h2>
            <p class="form-desc text-center text-lg-start">
              Enter your mobile number to receive OTP
            </p>

            <form id="loginForm">

              <!-- Mobile Number with Label -->
              <label for="mobile" class="form-label">Enter your mobile number</label>
              <div class="input-group mb-3">
                <span class="input-group-text country-code">
                  <img src="https://flagcdn.com/24x18/in.png" alt="India" class="me-2"> +91
                </span>
                <input type="tel" class="form-control" id="mobile" placeholder="Enter 10-digit number" maxlength="10" required pattern="[6-9][0-9]{9}">
              </div>

              <!-- Resend OTP (right aligned) -->
              <!--<div class="d-flex justify-content-end mb-4">-->
              <!--  <span class="resend-link">Resend OTP</span>-->
              <!--</div>-->

              <!-- Send OTP Button -->
              <button type="button" id="sendOtpBtn" class="btn btn-primary btn-send-otp w-100 mb-4">
                Send OTP
              </button>

              <!-- OTP Section (hidden initially) -->
              <div id="otpSection" class="otp-hidden">
                <label class="form-label fw-medium mb-2 mt-3 text-start d-block">Enter 4-digit OTP</label>
                <div class="otp-container">
                  <input type="text" maxlength="1" class="otp-input" id="otp1" autocomplete="off">
                  <input type="text" maxlength="1" class="otp-input" id="otp2" autocomplete="off">
                  <input type="text" maxlength="1" class="otp-input" id="otp3" autocomplete="off">
                  <input type="text" maxlength="1" class="otp-input" id="otp4" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-success btn-verify w-100 mt-4">
                  Verify & Login
                </button>

                <p class="text-center mt-3 small text-muted">
                  Didn't receive OTP? <span class="resend-link">Resend</span>
                </p>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
const sendOtpBtn = document.getElementById('sendOtpBtn');
const otpSection = document.getElementById('otpSection');

// OTP auto focus
const otpInputs = document.querySelectorAll('.otp-input');
otpInputs.forEach((input, index) => {
  input.addEventListener('input', (e) => {
    if (e.target.value.length === 1 && index < otpInputs.length - 1) {
      otpInputs[index + 1].focus();
    }
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
      otpInputs[index - 1].focus();
    }
  });
});


/* SEND OTP */
$("#sendOtpBtn").click(function(){

    var mobilenumber = $("#mobile").val();

    if(mobilenumber.length != 10){
        alert("Enter valid mobile number");
        return;
    }

    let formData = new FormData();
    formData.append('mobile_number', mobilenumber);
    formData.append('_token', "{{ csrf_token() }}");

    $.ajax({
        url: "{{ url('sendotopstudent') }}",
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        success: function(result){

            if(result.success){

                sendOtpBtn.style.display = 'none';
                otpSection.classList.remove('otp-hidden');
                document.getElementById('otp1').focus();

            }else{
                alert(result.message || "Something went wrong");
            }

        }
    });

});


/* VERIFY OTP */
$("#loginForm").submit(function(e){

    e.preventDefault();

    let mobilenumber = $("#mobile").val();

    let otp = '';
    $('.otp-input').each(function(){
        otp += $(this).val();
    });

    let formData = new FormData();
    formData.append('mobile_number', mobilenumber);
    formData.append('otp', otp);
    formData.append('_token', "{{ csrf_token() }}");

    $.ajax({
        url: "{{ url('verifymobilenumberstudent') }}",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: "json",
        data: formData,
        success: function(result){

            if(result.success){

                alert("Verified Successfully");

                if(result.profile == 1){
                    location.reload();
                }else{
                    window.location.href = "{{ url('/user/dashboard') }}";
                }

            }else{

                alert(result.message || "Invalid OTP");

            }

        }
    });

});
</script>

</body>
</html>