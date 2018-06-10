@extends('layouts.modal')

@section('modal')
	<div class="modal">
		<div class="modal-dialog">
			<form action="/global-admin/styles/edit/{{ $style->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Style</h4>
				</div>
				<div class="modal-body">
					<input type="text" name="name" class="form-control" value="{{ old('name', $style->name) }}">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
				{{ csrf_field() }}
			</form>
		</div>
	</div>
@endsection

@section('onsuccess')
	modal.modal('hide');
	document.location = '/global-admin/styles';
@endsection
