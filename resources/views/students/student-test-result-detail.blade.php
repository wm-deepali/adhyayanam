@extends('layouts.app')

@section('title')
Current Affair
@endsection

@section('content')
<style>
    .company-logo {
	text-align: center;
}
.company-details {
	border: 1px solid #d3d3d3;
	padding: 10px;
	border-radius: 8px;
	min-height: 160px;
}
.company-name {
	font-size: 18px;
	font-weight: 600;
}
.company.contact ul {
	line-height: ;
	list-style: none;
	padding: 0;
}
.company.contact ul li .fr {
	float: right;
}
.header-result {
	padding-bottom: 30px;
}
.pointsa {
	padding-top: 7px;
}
.pointsa li {
	list-style: number;
	font-size: 15px;
	padding: 7px;
}
.student-tick {
	background-color: red;
	color: #fff;
	width: fit-content;
}
.student-tick::marker {
	color: #515b69;
}
.right-answer {
	background-color: green;
	color: #fff;
	width: fit-content;
}
.right-answer::marker {
	color: #515b69;
}
.pointsa li {
	list-style: number;
	font-size: 15px;
	padding: 7px;
	margin: 4px 0;
}
.pointsa li {
	width: 50%;
	display: flex;
}
.pointsa li {
	width: 45%;
	display: inline-flex;
}
.main-right-marks ul {
	list-style: none;
	padding: 0;
}
.mcq-cont {
	display: flex;
}
.right-marks {
	align-content: center;
	border-left: 1px solid #d9d9d9;
	padding-left: 10px;
	width: 100px;
}
.mcq-cont {
	border: 1px solid #d9d9d9;
	margin-bottom: 15px;
	border-radius: 8px;
}
.ques {
	padding: 15px;
}
.correct-answer-system {
	background-color: #eee;
}
.company-details {
	border: 1px solid #d3d3d3;
	padding: 10px;
	border-radius: 8px;
	min-height: 190px;
}
.company.contact ul {
	margin: 0px;
}
</style>
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student Result</h5>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <div class="header-result">
                     <div class="company-logo">
                          <img src="https://test.netiias.com/images/Neti-logo.svg#full"/>
                      </div>
                </div>
                 <div class="row">
                  <div class="col-sm-4 col-md-3">
                  <div class="company-details">
                      <div class="company-name">Student Details</div>
                      <div class="company contact">
                           <ul>
                              <li>Student Name:<span class="fr">MOHD OSAID </span></li>
                              <li>Emai:<span class="fr">osd@gmail.com</span></li>
                          </ul>
                      </div>
                  </div>
              </div>
              <div class="col-sm-4 col-md-3">
                  <div class="company-details">
                      <div class="company-name">Order Details</div>
                      <div class="company contact">
                          <ul>
                              <li>Order Id:<span class="fr">OID676 </span></li>
                              <li>Order Date & Time:<span class="fr">12-03-24,12:00pm </span></li>
                              <li>Test Series Name:<span class="fr">UPSC </span></li>
                          </ul>
                      </div>
                  </div>
              </div>
              <div class="col-sm-4 col-md-3">
                  <div class="company-details">
                      <div class="company-name">Test Paper Detail</div>
                      <div class="company contact">
                          <ul>
                              <li>Paper Type:<span class="fr">UPSC </span></li>
                              <li>Duration:<span class="fr">3 Hour </span></li>
                              <li>Total Questions:<span class="fr">720 </span></li>
                              <li>Total Marks:<span class="fr">UPSC </span></li>
                              <li>Negative Marking:<span class="fr">Yes (-0.5 per Ques) </span></li>
                          </ul>
                      </div>
                  </div>
              </div>
              <div class="col-sm-4 col-md-3">
                  <div class="company-details">
                      <div class="company-name">Result</div>
                      <div class="company contact">
                          <ul>
                              <li>Questions Attempted:<span class="fr">80 </span></li>
                              <li>Questions Skipped:<span class="fr">10 </span></li>
                              <li>Correct Answer:<span class="fr">70 </span></li>
                              <li>Marks Obtained :<span class="fr">600 </span></li>
                              <li>Time Taken:<span class="fr">3Hour </span></li>
                              <li>Rank:<span class="fr">15 </span></li>
                          </ul>
                      </div>
                  </div>
              </div>
              </div>
            </div>

        </div>
    </div>
</div>
<div class="bg-light rounded p-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student Result</h5>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="container mt-4">
                <div class="mcq-details">
        <h2 class="mcq-hading">UPSC Test Series</h2>
        <div class="mcq-cont">
          <div class="ques">
              <h4>1) HTML stands for -</h4>
          <ol class="pointsa">
            <li>HighText Machine Language</li>
            <li class="student-tick">HyperText and links Markup Language</li>
            <li>HyperText Markup Language</li>
            <li>None of these</li>
            <li class="correct-answer-system">Correct Answer:HyperText Markup Language </li>
          </ol>
          </div>
          <div class="right-marks">
              <div class="main-right-marks">
                  <ul>
                      <li>Time:<span class="fr">0:55</span></li>
                      <li>Marks:<span class="fr">0</span></li>
                  </ul>
              </div>
          </div>
         
         
        </div>
        <div class="mcq-cont">
          <div class="ques">
              <h4>1) HTML stands for -</h4>
          <ol class="pointsa">
            <li>HighText Machine Language</li>
            <li >HyperText and links Markup Language</li>
            <li class="right-answer">HyperText Markup Language</li>
            <li>None of these</li>
            <!--<li class="correct-answer-system">Correct Answer:HyperText Markup Language </li>-->
          </ol>
          </div>
          <div class="right-marks">
              <div class="main-right-marks">
                  <ul>
                      <li>Time:<span class="fr">0:55</span></li>
                      <li>Marks:<span class="fr">0</span></li>
                  </ul>
              </div>
          </div>
         
         
        </div>
        <div class="mcq-cont">
          <div class="ques">
              <h4>1) HTML stands for -</h4>
          <ol class="pointsa">
            <li>HighText Machine Language</li>
            <li class="student-tick">HyperText and links Markup Language</li>
            <li>HyperText Markup Language</li>
            <li>None of these</li>
            <li class="correct-answer-system">Correct Answer:HyperText Markup Language </li>
          </ol>
          </div>
          <div class="right-marks">
              <div class="main-right-marks">
                  <ul>
                      <li>Time:<span class="fr">0:55</span></li>
                      <li>Marks:<span class="fr">0</span></li>
                  </ul>
              </div>
          </div>
         
         
        </div>

        
            </div>

        </div>
    </div>
</div>
@endsection
