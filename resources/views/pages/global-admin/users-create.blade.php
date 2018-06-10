@extends('layouts.master')

@section('content')
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Create User</h5>
				</div>
				<div class="ibox-content">
					@if ($errors->count())
					<div class="alert alert-danger">
						@foreach ($errors->all() as $message)
							{{ $message }}<br>
						@endforeach
					</div>
					@endif

					<form class="form-horizontal" method="post" action="/global-admin/users/create">
						{{ csrf_field() }}

						<div class="form-group">
							<label class="col-lg-2 control-label">First Name</label>
							<div class="col-lg-10">
								<input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Last Name</label>
							<div class="col-lg-10">
								<input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label">Email</label>
							<div class="col-lg-10">
								<input type="text" name="email" class="form-control" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Password</label>
							<div class="col-lg-10"><input type="password" placeholder="Password" class="form-control" name="password" value="">
								@if ($errors->has('password'))
									<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<label class="col-lg-2 control-label">Confirm Password</label>
							<div class="col-lg-10">
								<input type="password" class="form-control" placeholder="Password" name="password_confirmation">
								@if ($errors->has('password_confirmation'))
									<span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
							<label class="col-lg-2 control-label">Type</label>
							<div class="col-lg-10">
								<select id="type" name="type" class="form-control">
									<option value="rider" {{ old('type') ? 'selected' : '' }}>Rider</option>
									<option value="fitter" {{ old('type') ? 'selected' : '' }}>Fitter</option>
									<option value="global-admin" {{ old('type') ? 'selected' : '' }}>Global Admin</option>
								</select>
								@if ($errors->has('type'))
									<span class="help-block"><strong>{{ $errors->first('type') }}</strong></span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
							<label class="col-lg-2 control-label">Parent Company</label>
							<div class="col-lg-10">
								<select id="company" name="company" class="form-control">
									<option value="">None</option>
									@foreach ($companies as $company)
									<option value="{{ $company->id }}" {{ $company == old('company') ? 'selected' : '' }}>{{ $company->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('company'))
									<span class="help-block"><strong>{{ $errors->first('company') }}</strong></span>
								@endif
							</div>
						</div>

						@if (Auth::user()->isCompanyAdmin() || Auth::user()->isGlobalAdmin())
							<div class="form-group">
								<label class="col-lg-2 control-label">Company Admin</label>
								<div class="col-lg-1">
									<input type="checkbox" id="is_company_admin" name="is_company_admin" class="form-control" value="1"{{ old('is_account_admin') ? ' checked' : '' }}>
								</div>
							</div>
						@endif

						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button class="btn btn-sm btn-primary" type="submit">Create User</button>
								<a href="/global-admin/users" class="btn btn-default">Cancel</a>
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

@section('scripts')
	<script>
		$( document ).ready(function() {
			var type = $('#type').val();

			if (type === 'fitter') {
				$('#company').prop('disabled', false);
				$('#is_company_admin').prop('disabled', false);
			} else {
				$('#company').prop('disabled', true);
				$('#is_company_admin').prop('disabled', true);
			}
		});

		$('#type').on('input', function (event) {
			var type = $(this).val();

		  	if (type === 'fitter') { 
		    	$('#company').prop('disabled', false);
		  	} else {
		    	$('#company').prop('disabled', true);
		  	}
		});

		$('#company').on('input', function (event) {
			var type = $(this).val();

		  	if (type != '') { 
		    	$('#is_company_admin').prop('disabled', false);
		  	} else {
		    	$('#is_company_admin').prop('disabled', true);
		  	}
		});
	</script>
@endsection