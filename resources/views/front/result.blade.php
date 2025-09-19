@extends('front-users.layouts.app')

@section('title')
Dashboard
@endsection

@section('content')
<style>
    .result-section {
      width: 100%;
      height: auto;
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
    }
    .result-card {
      width: 100%;
      height: 150px;
      border-radius: 10px;
      background-color: rgb(255, 255, 255);
      box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
      display: grid;
      grid-template-columns: 3fr 1fr;
      padding: 10px;
    }
    .result-card1 {
      width: 100%;
      height: 150px;
      border-radius: 10px;
      background-color: rgb(255, 255, 255);
      box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      padding: 10px;
    }
    .result-card2 {
      width: 100%;
      height: 150px;
      border-radius: 10px;
      background-color: rgb(255, 255, 255);
      box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;

      padding: 10px;
    }
    .result-card img {
      width: 100%;
    }
    .progress-report {
      width: 100%;
      height: auto;
      border-radius: 10px;
      background-color: white;
      box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
      margin-top: 20px;
      display: flex;
      /* grid-template-columns: 1fr 3fr; */
      flex-direction: row;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 20px;
      padding: 20px;
    }
    .left-side-chart{
        width: 35%;
        height: auto;
        border: 1px solid rgba(128, 128, 128, 0.137);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        padding: 10px;
    }
    .right-side-chart{
        width: 68%;
        height: auto;
        border: 1px solid rgba(128, 128, 128, 0.137);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        padding: 10px;
    }
    .pie-chart-section{
        width: 100%;
        height: auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .pieContainer {
      height: 150px;
      position: relative;
    }
    
    .pieBackground {
      position: absolute;
      width: 150px;
      height: 150px;
      border-radius: 100%;
      box-shadow: 0px 0px 8px rgba(0,0,0,0.5);
    } 
    
    .pie {
      transition: all 1s;
      position: absolute;
      width: 150px;
      height: 150px;
      border-radius: 100%;
      clip: rect(0px, 75px, 150px, 0px);
    }
    
    .hold {
      position: absolute;
      width: 150px;
      height: 150px;
      border-radius: 100%;
      clip: rect(0px, 150px, 150px, 75px);
    }
    
    #pieSlice1 .pie {
      background-color: #1b458b;
      transform:rotate(30deg);
    }
    
    #pieSlice2 {
      transform: rotate(30deg);
    }
    
    #pieSlice2 .pie {
      background-color: #0a0;
      transform: rotate(60deg);
    }
    
    #pieSlice3 {
      transform: rotate(90deg);
    }
    
    #pieSlice3 .pie {
      background-color: #f80;
      transform: rotate(120deg);
    }
    
    #pieSlice4 {
      transform: rotate(210deg);
    }
    
    #pieSlice4 .pie {
      background-color: #db3;
      transform: rotate(10deg);
    }
    
    #pieSlice5 {
      transform: rotate(220deg);
    }
    
    #pieSlice5 .pie {
      background-color: #a04;
      transform: rotate(70deg);
    }
    
    #pieSlice6 {
      transform: rotate(290deg);
    }
    
    #pieSlice6 .pie {
      background-color: #ffd700;
      transform: rotate(70deg);
    }
    
    .innerCircle {
      position: absolute;
      width: 100px;
      height: 100px;
      background-color: #ffffff;
      border-radius: 100%;
      top: 25px;
      left: 25px; 
      box-shadow: 0px 0px 8px rgba(0,0,0,0.5) inset;
      color: white;
    }
    .innerCircle .content {
      position: absolute;
      display: block;
      width: 120px;
      top: 30px;
      left: 0;
      text-align: center;
      font-size: 14px;
    }
  </style>
<div class="content-header">
            <div class="d-flex align-items-center">
              <div class="me-auto">
                <h4 class="page-title">{{$test->name}}</h4>
                <div class="d-inline-block align-items-center">
                  <nav>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#"><i class="mdi mdi-home-outline"></i></a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Result
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <!-- Main content -->
          <section class="content">
            <div class="row">
              <div class="col-12">
                <div class="result-section">
                  <div class="result-card">
                    <div class="content-section">
                      <h5 style="font-weight: 600; font-size: 14px">Rank</h5>
                      <p>
                        Congratulations! your current Rank is #49, among 1000
                        students
                      </p>
                      <h4>Score: {{$studentest->score}}/{{$studentest->total_marks}}</h4>
                    </div>
                    <img
                      src="https://img.freepik.com/free-vector/medal-2_78370-531.jpg"
                    />
                  </div>
                  <div class="result-card1">
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          Total Questions
                        </p>
                        <h4 style="font-weight: 600; font-size: 14px">{{$studentest->total_questions}}</h4>
                      </div>
                    </div>
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          Attempted
                        </p>
                        <h4 style="font-weight: 500; font-size: 14px">{{$studentest->attempted}}</h4>
                      </div>
                    </div>
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          Correct Answers
                        </p>
                        <h4 style="font-weight: 500; font-size: 14px">{{$studentest->correct_answer}}</h4>
                      </div>
                    </div>
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          Not Attempted
                        </p>
                        <h4 style="font-weight: 500; font-size: 14px">{{$studentest->not_attempted}}</h4>
                      </div>
                    </div>
                  </div>
                  <div class="result-card1">
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          No. of Attempts
                        </p>
                        <h4 style="font-weight: 600; font-size: 14px">{{$count_attempt}}</h4>
                      </div>
                    </div>
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          Test Duration
                        </p>
                        <h4 style="font-weight: 500; font-size: 14px">{{$studentest->duration}} mins</h4>
                      </div>
                    </div>
                    <div class="content-data" style="display: flex">
                      <p style="font-size: 20px; margin-right: 10px">
                        <i class="fa fa-users text-danger"></i>
                      </p>
                      <div
                        class=""
                        style="display: flex; flex-direction: column"
                      >
                        <p
                          class="p-0 m-0"
                          style="color: gray; padding-bottom: 5px"
                        >
                          Time Taken
                        </p>
                        <h4 style="font-weight: 500; font-size: 14px">{{$studentest->taken_time}} mins</h4>
                      </div>
                    </div>
                    <div class="content-data" style="display: flex">
                      <!-- <div class="" style="display: flex; flex-direction: column;">
      <button class="p-0 m-0 " style="color: rgb(255, 255, 255); padding-bottom: 5px; border: none; padding: 10px 10px; background-color: green;">Download Result</button>
      
  </div> -->
                    </div>
                  </div>
                  <!-- <div class="result-card2">
                <canvas id="myChart" style="width:100%;"></canvas>
                  
            </div> -->
                </div>
                <div class="progress-report">
                    <div class="left-side-chart">
<h3 class="border-bottom pb-2" style="font-weight: 500;">Progress Report</h3>
<div class="pie-chart-section">
<div class="pieContainer mb-3">
    <div class="pieBackground"></div>
    <div id="pieSlice1" class="hold"><div class="pie"></div></div>
    <div id="pieSlice2" class="hold"><div class="pie"></div></div>
    <div id="pieSlice3" class="hold"><div class="pie"></div></div>
    <div id="pieSlice4" class="hold"><div class="pie"></div></div>
    <!--div id="pieSlice5" class="hold"><div class="pie"></div></div>
    <div id="pieSlice6" class="hold"><div class="pie"></div></div> -->
    <div class="innerCircle"></div>
  </div>
  <div class="pichart-chart-content" style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center;">
    <div class="color-tag d-flex gap-2">
        <p style="width: 20px; height: 20px; background-color: #0a0;"></p>
        <p> Correct Questions</p>
    </div>
    <div class="color-tag d-flex gap-2">
        <p style="width: 20px; height: 20px; background-color: rgb(37, 50, 168);"></p>
        <p> Wrong Questions</p>
    </div>
    <div class="color-tag d-flex gap-2">
        <p style="width: 20px; height: 20px; background-color: rgb(219, 95, 13);"></p>
        <p> Attempted</p>
    </div>
    <div class="color-tag d-flex gap-2">
        <p style="width: 20px; height: 20px; background-color: rgb(219, 59, 13);"></p>
        <p> Not Attempted</p>
    </div>

  </div>
</div>
<div class="progress-score-card" style="width: 100%; height: auto; padding: 10px; background-color: rgba(0, 136, 255, 0.082); border-radius: 5px;">
<h4 style="font-weight: 500; font-size: 16px;">Overall Progress</h4>
<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
  </div>
</div>
<div class="progress-score-card mt-3" style="width: 100%; height: auto; padding: 10px; background-color: rgba(0, 136, 255, 0.082); border-radius: 5px;">
    <h4 style="font-weight: 500; font-size: 16px;">Overall Progress</h4>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
      </div>
    </div>
                    </div>
                    <div class="right-side-chart">
                        <h3 class="border-bottom pb-2" style="font-weight: 500;">Progress Report</h3>
                        <h4 style="font-weight: 500;">Overall Progress</h4>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                          </div>
                                            </div>
                </div>
              </div>
            </div>
          </section>
          <!-- /.content -->
         @endsection