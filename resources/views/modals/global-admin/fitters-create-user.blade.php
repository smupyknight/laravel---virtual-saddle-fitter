@extends('layouts.modal')

@section('modal')
	<div class="modal">
		<div class="modal-dialog">
			<form action="/global-admin/fitters/create-user-modal/{{ $fitter->id }}" method="post" class="modal-content"
				  autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Create Fitter User</h4>
				</div>
				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-md-4 control-label">First Name</label>
							<div class="col-md-8">
								<input type="text" placeholder="First Name" name="first_name" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-8">
								<input type="text" placeholder="Last Name" name="last_name" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Email</label>
							<div class="col-md-8">
								<input type="email" class="form-control" placeholder="Email" name="email">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-8">
								<input type="password" placeholder="Password" class="form-control" name="password">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-8">
								<input type="password" class="form-control" placeholder="Password"
									   name="password_confirmation">
							</div>
						</div>
						<div class='form-group'>
							<label class="col-md-4 control-label" for="type">Type</label>
							<div class="col-md-8">
								<select class='form-control' name="type" id="type">
									<option value="fitter-user" selected="selected">Fitter User</option>
									<option value="fitter-admin">Fitter Admin</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Create</button>
				</div>
				{{ csrf_field() }}
			</form>
		</div>
	</div>
@endsection

@section('onsuccess')
	modal.modal('hide');
	document.location = '/global-admin/fitters/view/{{ $fitter->id }}';
@endsection
