<!-- Main content -->
@extends('front-users.layouts.app')

@section('title')
Test Papers
@endsection

@section('content')
<section class="content">
			<div class="row">
				<div class="col-12 col-xl-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Test Paper</h5>
							<p class="mb-0 card-subtitle text-muted">Using the most basic table markup, here’s how .table-based tables look in Bootstrap.</p>
						</div>
						<div class="card-body">
							<table class="table">
								<thead>
									<tr>
										<th>Test Paper Name</th>
										<th>Subject</th>
										<th>Test Series Name</th>
										<th>Test Status</th>
										<th>Total Marks</th>
										<th >Duration</th>
										<th >-ve Marking</th>
										<th >Button</th>
										<!--<th >View Results</th>-->
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<td>BPSC</td>
										
										<td class="d-none d-md-table-cell text-fade">History</td>
										<td class="d-none d-md-table-cell text-fade">Test</td>
										<td class="d-none d-md-table-cell text-fade">Not Attempted</td>
										<td class="d-none d-md-table-cell text-fade">300</td>
										<td class="d-none d-md-table-cell text-fade">60 Min</td>
										<td class="d-none d-md-table-cell text-fade">Yes</td>
											<td class="d-none d-md-table-cell text-fade"><button style="border-radius:3px; background:Blue;color:white;"data-toggle="modal" data-target="#exampleModal">Attempt Now</button></td>
										<!--<td class="table-action min-w-100 text-center">-->
										<!--	<a href="course-details.html" class="text-fade hover-primary"><i class="align-middle" data-feather="eye"></i></a>-->
											<!--<a href="#" class="text-fade hover-primary"><i class="align-middle" data-feather="trash"></i></a>-->
										<!--</td>-->
									</tr>
									<tr>
										<td>BPSC</td>
										
										<td class="d-none d-md-table-cell text-fade">History</td>
										<td class="d-none d-md-table-cell text-fade">Test</td>
										<td class="d-none d-md-table-cell text-fade">Completed</td>
										<td class="d-none d-md-table-cell text-fade">300</td>
										<td class="d-none d-md-table-cell text-fade">2 Hours</td>
										<td class="d-none d-md-table-cell text-fade">Yes</td>
											<td class="d-none d-md-table-cell text-fade"><button style="border-radius:3px; background:green;color:white;"> View Result </button></td>
									
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

			

				
			</div>
		</section>
		<!-- /.content -->
		@endsection