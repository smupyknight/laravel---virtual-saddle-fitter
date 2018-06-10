@extends('layouts.modal')

@section('modal')
	<div class="modal">
		<div class="modal-dialog">
			<form action="/global-admin/fitters/delete-user-modal/{{ $fitter->id }}/{{ $user->id }}" method="post" class="modal-content"
				  autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Fitter</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete User: #{{ $user->id }} {{ $user->first_name . ' ' . $user->last_name }}?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Delete</button>
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
