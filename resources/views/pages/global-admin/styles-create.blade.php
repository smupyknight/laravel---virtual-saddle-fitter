@extends('layouts.master')

@section('content')
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Create Style</h5>
				</div>
				<div class="ibox-content">
					@if ($errors->count())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $message)
						{{ $message }}<br>
						@endforeach
					</div>
					@endif

					<form class="form-horizontal" method="post" action="/global-admin/styles/create">
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('brand') ? ' has-error' : '' }}">
							<label class="col-lg-2 control-label">Brand</label>
							<div class="col-lg-6">
								<select name="brand" class="form-control">
									<option>Please select a Brand</option>
									@foreach ($brands as $brand)
									<option value="{{ $brand->id }}" {{ $brand == old('brand') ? 'selected' : '' }}>{{ $brand->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('brandhorse'))
									<span class="help-block"><strong>{{ $errors->first('brand') }}</strong></span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Style Name</label>
							<div class="col-lg-6">
								<input type="text" name="name" class="form-control" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button class="btn btn-sm btn-primary" type="submit">Add Style</button>
								<a href="/global-admin/styles" class="btn btn-default">Cancel</a>
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