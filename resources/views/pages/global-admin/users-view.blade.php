@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-sm-8">
				<div class="ibox">
					<div class="ibox-title">
						<h5>{{ $title }}</h5>
						<div class="ibox-tools">
							<a href="/global-admin/users/edit/{{ $user->id }}" class="btn btn-default btn-xs">Edit User</a>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-12">
								<div class="tab-content">
									<div class="tab-pane active" id="details">
										<br>
										<div class="row m-b-xs">
											<div class="col-sm-6">
												<label>ID:</label>
												{{ $user->id }}
											</div>

											<div class="col-sm-6">
												<label>Name:</label>
												{{ $user->first_name . ' ' . $user->last_name }}
											</div>

											<div class="col-sm-6">
												<label>User Type:</label>
												{{ $user->type }}
											</div>

											<div class="col-sm-6">
												<label>Email:</label>
												{{ $user->email }}
											</div>

											<div class="col-sm-6">
												<label>Company:</label>
												{{ $user->company->name }}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection