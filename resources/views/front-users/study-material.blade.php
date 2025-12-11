@extends('front-users.layouts.app')

@section('title')
	Study Material
@endsection

@section('content')
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Order Details</h5>
						<p class="mb-0 card-subtitle text-muted">Using the most basic table markup, here’s how .table-based
							tables look in Bootstrap.</p>
					</div>
					<div class="card-body">
						<table class="table">
							<thead>
								<tr>
									<th>Study Material Title</th>
									<th>Examination Commission</th>
									<th>Category</th>
									<th>Subcategory</th>
									<th>Subjects</th>
									<th>Language</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>

							<tbody>
								@forelse ($orders as $order)
									@php $m = $order->study_material; @endphp

									<tr>
										<td>{{ $m->title }}</td>
										<td>{{ $m->commission->name ?? 'N/A' }}</td>
										<td>{{ $m->category?->name ?? 'N/A' }}</td>
										<td>{{ $m->subcategory?->name ?? 'N/A' }}</td>
										
										<td>
											@if($m->subjects->count())
												<li>
													{{ $m->subjects->pluck('name')->implode(', ') }}
												</li>
											@else
												N/A
											@endif
										</td>
										<td>{{ ucfirst($m->language) }}</td>
										<td>{{ $m->status }}</td>
										<td class="table-action min-w-100">
											<a href="{{ route('study.material.details', $m->id) }}"
												class="text-fade hover-primary">
												<i class="align-middle" data-feather="eye"></i>
											</a>
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="6" class="text-center text-muted">No Study Material Purchased.</td>
									</tr>
								@endforelse
							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
@endsection