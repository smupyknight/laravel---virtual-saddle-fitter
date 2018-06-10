@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<div class="ibox-title">
				<h5>{{ $title or '' }}</h5>
				<div class="ibox-tools">
					<a href="/global-admin/fitters/create" class="btn btn-primary btn-xs">Create New Organisation</a>
				</div>
			</div>
			<div class="ibox-content">
				@if (Request::session()->has('message'))
					<div class="alert alert-success">
						{{ Request::session()->get('message') }}
					</div>
				@endif
				<div class="row">
					<form method="GET" action="/global-admin/fitters">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" placeholder="Search Users" class="input form-control" name="search"
									   value="{{ Request::get('search') }}">
								<span class="input-group-btn">
									<button type="submit" class="btn btn btn-primary "> <i class="fa fa-search"></i> Search</button>
								</span>
							</div>
						</div>
					</form>
				</div>
				@if(count($fitters)>0)
					<table class="table table-striped">
						<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Actions</th>
						</tr>
						</thead>
						<tbody class="table_body">
						@foreach($fitters as $fitter)
							<tr>
								<td>{{ $fitter->id }}</td>
								<td>{{ $fitter->name }}</td>
								<td>{{ $fitter->email }}</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle">
											Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="/global-admin/fitters/view/{{$fitter->id}}">View</a></li>
											<li><a href="/global-admin/fitters/edit/{{$fitter->id}}">Edit</a></li>
											<li class="divider"></li>
											<li>
												<a href="javascript:show_modal('/global-admin/fitters/delete/{{ $fitter->id }}')">Delete</a>
											</li>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
						<tr>
							<td colspan="6" align="right">
								{{$fitters->render()}}
							</td>
						</tr>
						</tbody>
					</table>
				@else
					<div class="text-center">
						<p>No Fitters found in the system, please <a href="/global-admin/fitters/create">create</a> one.
						</p>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
@section('scripts')

@endsection
