@extends('layouts.master')

@section('content')
<div class="wrapper wrapper-content">
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5>Edit User: {{ $user->first_name . ' ' . $user->last_name }}</h5>
		</div>
		<div class="ibox-content">
			<form action="/global-admin/users/edit/{{ $user->id }}" method="post" class="form-horizontal">
				{!! csrf_field() !!}

				<div class="form-group">
					<label class="col-lg-2 control-label">First Name</label>
					<div class="col-lg-6">
						<input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
						@if ($errors->has('first_name'))
							<span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Last Name</label>
					<div class="col-lg-6">
						<input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
						@if ($errors->has('last_name'))
							<span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Email</label>
					<div class="col-lg-6">
						<input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
						@if ($errors->has('email'))
							<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Password</label>
					<div class="col-lg-6">
						<input type="password" name="password" class="form-control">
						@if ($errors->has('password'))
							<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
					<label class="col-lg-2 control-label">Type</label>
					<div class="col-lg-10">
						<select id="type" name="type" class="form-control">
							<option value="rider" {{ old('type', $user->type) == 'rider' ? ' selected' : '' }}>Rider</option>
							<option value="fitter" {{ old('type', $user->type) == 'fitter' ? ' selected' : '' }}>Fitter</option>
							@if (Auth::user()->isGlobalAdmin())
								<option value="global-admin" {{ old('type', $user->type) == 'global-admin' ? ' selected' : '' }}>Global Admin</option>
							@endif
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
							<option value="1"{{ $company->id }}" {{ $company->id == old('company', $user->company_id) ? 'selected' : '' }}>{{ $company->name }}</option>
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
							<input type="checkbox" id="is_company_admin" name="is_company_admin" class="form-control" value="1"{{ $user->is_company_admin ? ' checked' : '' }}>
						</div>
					</div>
				@endif

				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
						<button type="submit" class="btn btn-primary">Save Changes</button>
						<a href="/global-admin/users" class="btn btn-default">Cancel</a>
					</div>
				</div>

			</form>
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

		    	if($('#company').prop('selectedIndex') > 0) {
		    		$('#is_company_admin').prop('disabled', false);
		   		}
		  	} else if (type === 'rider' || type === 'global-admin') {
		    	$('#company').prop('disabled', true);
		    	$('#is_company_admin').attr('checked', false);
				$('#is_company_admin').prop('disabled', true);
		  	}
		});

		$('#company').on('input', function (event) {
			var companySelected = $(this).prop('selectedIndex');

		  	if (companySelected > 0) {
		  		$('#is_company_admin').prop('disabled', false);
		  	} else {
		  		$('#is_company_admin').prop('disabled', true);
		  	}
		});
	</script>
@endsection