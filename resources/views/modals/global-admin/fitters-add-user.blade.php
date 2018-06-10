@extends('layouts.modal')

@section('modal')
	<div class="modal">
		<div class="modal-dialog">
			<form action="/global-admin/fitters/add-user-modal/{{ $fitter->id }}" method="post" class="modal-content"
				  autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Existing User</h4>
				</div>
				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-md-4 control-label">User</label>
							<div class="col-md-8">
								<select class='form-control' name="user_id" id="user_id">
									<option disabled >Select User</option>
									@foreach($users as $user)
										<option value="{{$user->id}}"> {{ ucfirst($user->first_name . ' ' . $user->last_name) }} </option>
									@endforeach
								</select>
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
					<button type="submit" class="btn btn-primary">Add</button>
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
