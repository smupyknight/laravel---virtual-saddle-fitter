@extends('layouts.master')

@section('content')
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Create Brand</h5>
				</div>
				<div class="ibox-content">
					@if ($errors->count())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $message)
						{{ $message }}<br>
						@endforeach
					</div>
					@endif

					<form class="form-horizontal" method="post" action="/global-admin/brands/create">
						{{ csrf_field() }}

						<div class="form-group">
							<div class="col-lg-6 col-lg-offset-2">
								<p>You may add many brands at once by seperating them by commas.</p>
								<small>Eg. brand one, brand two, brand three</small>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Brand Name</label>
							<div class="col-lg-6">
								<input type="text" name="names" class="form-control" value="{{ old('names') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button class="btn btn-sm btn-primary" type="submit">Add Brand Names</button>
								<a href="/global-admin/brands" class="btn btn-default">Cancel</a>
								{!! csrf_field() !!}
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection