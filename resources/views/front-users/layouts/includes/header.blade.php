<header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">	
		<!-- Logo -->
		<a href="{{url('/')}}" class="logo">
		  <!-- logo-->
		  <div class="logo-mini w-30">
			  <!-- <span class="light-logo"><img src="https://netiias.com/design/images/Neti-logo.svg" alt="logo"></span>
			  <span class="dark-logo"><img src="https://netiias.com/design/images/Neti-logo.svg" alt="logo"></span> -->
		  </div>
		  <div class="logo-lg">
			  <span class="light-logo"><img src="{{ url('images/Neti-logo.png')}}" alt="logo"></span>
			  <!-- <span class="dark-logo"><img src="https://netiias.com/design/images/Neti-logo.svg" alt="logo"></span> -->
		  </div>
		</a>	
	</div>   
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	  <div class="app-menu">
		<ul class="header-megamenu nav">
			<li class="btn-group nav-item">
				<a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light ms-0" data-toggle="push-menu" role="button">
					<i data-feather="menu"></i>
			    </a>
			</li>
			<li class="btn-group d-lg-inline-flex d-none">
				<div class="app-menu">
					<div class="search-bx mx-5">
						<form>
							<div class="input-group">
							  <input type="search" class="form-control" placeholder="Search">
							  <div class="input-group-append">
								<button class="btn" type="submit" id="button-addon3"><i class="icon-Search"><span class="path1"></span><span class="path2"></span></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</li>
		</ul> 
	  </div>
		
      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
			<li class="btn-group d-md-inline-flex d-none">
              <a href="javascript:void(0)" title="skin Change" class="waves-effect skin-toggle waves-light">
			  	<label class="switch">
					<input type="checkbox" data-mainsidebarskin="toggle" id="toggle_left_sidebar_skin">
					<span class="switch-on"><i data-feather="moon"></i></span>
					<span class="switch-off"><i data-feather="sun"></i></span>
				</label>
			  </a>				
            </li>
			
			<!--<li class="btn-group nav-item d-xl-inline-flex d-none">-->
			<!--	<a href="#" class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="" id="live-chat">-->
			<!--		<i data-feather="message-circle"></i>-->
			<!--    </a>-->
			<!--</li>-->
			

			
			<li class="btn-group nav-item d-xl-inline-flex d-none">
				<a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link btn-primary-light svg-bt-icon" title="Full Screen">
					<i data-feather="maximize"></i>
			    </a>
			</li>
			
			<!-- User Account-->
			<li class="dropdown user user-menu">
				<a href="#" class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent p-0 no-shadow" title="User" data-bs-toggle="modal" data-bs-target="#quick_user_toggle">
					<div class="d-flex pt-1 align-items-center">
						<div class="text-end me-10">
							<p class="pt-5 fs-14 mb-0 fw-700">{{(auth()->user() !='' && auth()->user()->name != '') ? auth()->user()->name : '' }}</p>
							<small class="fs-10 mb-0 text-uppercase text-mute">STudent</small>
						</div>
						<img src="{{ url('src/images/avatar/avatar-13.png')}}" class="avatar rounded-circle bg-primary-light h-40 w-40" alt="" />
					</div>
				</a>
			</li>		  
        
			
        </ul>
      </div>
    </nav>
  </header>