@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<div class="ibox-title">
				<h5>{{ $title or '' }}</h5>
				<div class="ibox-tools">
					<a href="/global-admin/users/create" class="btn btn-primary btn-xs">Create User</a>
				</div>
			</div>
			<div class="ibox-content">
				@if (Request::session()->has('message'))
					<div class="alert alert-success">
						{{ Request::session()->get('message') }}
					</div>
				@endif
				<div class="row">
					<form method="GET" action="/global-admin/users">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" placeholder="Search Users" class="input form-control" name="phrase"
									   value="{{ Request::get('phrase') }}">
								<span class="input-group-btn">
									<button type="submit" class="btn btn btn-primary "> <i class="fa fa-search"></i> Search</button>
								</span>
							</div>
						</div>
					</form>
				</div>
				@if(count($users)>0)
					<table class="table table-striped">
						<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Company</th>
							<th>Type</th>
							<th>Actions</th>
						</tr>
						</thead>
						<tbody class="table_body">
						@foreach($users as $user)
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->first_name . ' ' . $user->last_name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->company ? $user->company->name : 'None' }}</td>
								<td>{{ $user->type }}</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle">
											Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="/global-admin/users/view/{{$user->id}}">View</a></li>
											<li><a href="/global-admin/users/edit/{{$user->id}}">Edit</a></li>
											<li class="divider"></li>
											<li>
												<a href="javascript:show_modal('/global-admin/users/delete/{{ $user->id }}')">Delete</a>
											</li>
											</li>
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
						<tr>
							<td colspan="6" align="right">
								{{$users->render()}}
							</td>
						</tr>
						</tbody>
					</table>
				@else
					<div class="text-center">
						<p>No Users found in the system, please <a href="/global-admin/users/create">create</a> one.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
@section('scripts')

@endsection
