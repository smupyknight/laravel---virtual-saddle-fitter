@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<div class="ibox-title">
				<h5>{{ $title or '' }}</h5>
				<div class="ibox-tools">
					<a href="/global-admin/brands/create" class="btn btn-primary btn-xs">Create Brand</a>
				</div>
			</div>
			<div class="ibox-content">
				<div class="row">
					<form method="GET" action="/brands">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" placeholder="Search Brands" class="input form-control" name="phrase" value="{{ Request::get('phrase') }}" >
								<span class="input-group-btn">
									<button type="submit" class="btn btn btn-primary "> <i class="fa fa-search"></i> Search</button>
								</span>
							</div>
						</div>
					</form>
				</div>
				@if (count($brands) > 0)
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody class="table_body">
						@foreach($brands as $brand)
							<tr>
								<td>{{ $brand->id }}</td>
								<td>{{ $brand->name }}</td>
								<td>
									<a href="javascript:show_modal('/global-admin/brands/edit/{{ $brand->id }}')" class="btn btn-success btn-xs">Edit</a>
									<a href="javascript:show_modal('/global-admin/brands/delete/{{ $brand->id }}')" class="btn btn-danger btn-xs">Delete</a>
								</td>
							</tr>
						@endforeach
							<tr>
								<td colspan="6" align="right">
									{{ $brands->render() }}
								</td>
							</tr>
						</tbody>
					</table>
				@else
					<div class="text-center">
						<p>No brands to display. Please <a href="/global-admin/brands/create">add</a> one.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection