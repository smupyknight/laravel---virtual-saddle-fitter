@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>{{ $title }} {{ $fitter->name }}</h5>
						<div class="ibox-tools">
							<a href="/global-admin/fitters" class="btn btn-default btn-xs">Back to list</a>
							<a href="javascript:show_modal('/global-admin/fitters/create-user-modal/{{ $fitter->id }}')"
							class="btn btn-primary btn-xs">Create a User</a>
							<a href="javascript:show_modal('/global-admin/fitters/add-user-modal/{{ $fitter->id }}')"
							class="btn btn-primary btn-xs">Add a User</a>
							<a href="/global-admin/fitters/edit/{{ $fitter->id }}"
							class="btn btn-primary btn-xs">Edit</a>
						</div>
					</div>
					<div class="ibox-content">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">Name</label>
								<div class="col-md-10">
									<p id="name" class="form-control-static">{{ $fitter->name }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="abn">ABN</label>
								<div class="col-md-10">
									<p id="abn" class="form-control-static">{{ $fitter->abn }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="phone">Phone number</label>
								<div class="col-md-10">
									<p id="phone" class="form-control-static">{{ $fitter->phone }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="email">Email</label>
								<div class="col-md-10">
									<p id="email" class="form-control-static">{{ $fitter->email }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="address">Address</label>
								<div class="col-md-10">
									<p id="address" class="form-control-static">{{ $fitter->address }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="suburb">Suburb</label>
								<div class="col-md-10">
									<p id="suburb" class="form-control-static">{{ $fitter->suburb }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="postcode">Postcode</label>
								<div class="col-md-10">
									<p id="postcode" class="form-control-static">{{ $fitter->postcode }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label" for="state">State</label>
								<div class="col-md-10">
									<p id="state" class="form-control-static">{{ $fitter->state }}</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-2 control-label">Logo</label>
								<div class="col-md-10">
									<img class="form-control-static" src="/fitter_logos/{{ $fitter->logo }}">
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<form action="/global-admin/fitters/view/{{ $fitter->id }}" method="get">
										<div class="input-group">
											<input type="text" placeholder="Search User" class="input form-control"
												   name="search_user" value="{{ Request::get('search_user') }}">
											<span class="input-group-btn">
										<button type="submit" class="btn btn btn-primary search-user-btn"> <i
													class="fa fa-search"></i>Search</button>
											</span>
										</div>
									</form>
								</div>
							</div>

							@if(count($users))
								<table class="table table-striped">
									<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Email</th>
										<th>Type</th>
										<th>More</th>
									</tr>
									</thead>
									<tbody class="table_body">
									@foreach($users as $user)
										<tr>
											<td>{{ $user->id }}</td>
											<td>{{ $user->first_name . ' ' . $user->last_name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{ $user->type }}</td>
											<td>
												<div class="btn-group">
													<button data-toggle="dropdown"
															class="btn btn-default btn-xs dropdown-toggle">Action
														<span class="caret"></span></button>
													<ul class="dropdown-menu">
														<li>
															<a href="/global-admin/users/edit/{{$user->id}}/{{$fitter->id}}">Edit</a>
														</li>
														<li class="divider"></li>
														<li>
															<a href="javascript:show_modal('/global-admin/fitters/delete-user-modal/{{ $fitter->id }}/{{ $user->id }}')">Delete</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							@else
								<div class="text-center">
									<p>No Users found for this Fitter</p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection