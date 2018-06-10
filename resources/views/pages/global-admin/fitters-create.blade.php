@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>{{ $title }}</h5>
					</div>
					<div class="ibox-content">
						<form class="form-horizontal" method="post" action="/global-admin/fitters/create" enctype="multipart/form-data">
							{{ csrf_field() }}

							<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="name">Name</label>
								<div class="col-md-10">
									<input name="name" id="name" class="form-control" value="{{ old('name') }}">
									@if ($errors->has('name'))
										<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('abn') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="abn">ABN</label>
								<div class="col-md-10">
									<input name="abn" id="abn" class="form-control" value="{{ old('abn') }}">
									@if ($errors->has('abn'))
										<span class="help-block"><strong>{{ $errors->first('abn') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="phone">Phone number</label>
								<div class="col-md-10">
									<input name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
									@if ($errors->has('phone'))
										<span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="email">Email</label>
								<div class="col-md-10">
									<input name="email" id="email" class="form-control" value="{{ old('email') }}">
									@if ($errors->has('email'))
										<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="address">Address</label>
								<div class="col-md-10">
									<input name="address" id="address" class="form-control" value="{{ old('address') }}">
									@if ($errors->has('address'))
										<span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('suburb') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="suburb">Suburb</label>
								<div class="col-md-10">
									<input name="suburb" id="suburb" class="form-control" value="{{ old('suburb') }}">
									@if ($errors->has('suburb'))
										<span class="help-block"><strong>{{ $errors->first('suburb') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('postcode') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="postcode">Postcode</label>
								<div class="col-md-10">
									<input name="postcode" id="postcode" class="form-control" value="{{ old('postcode') }}">
									@if ($errors->has('postcode'))
										<span class="help-block"><strong>{{ $errors->first('postcode') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label" for="state">State</label>
								<div class="col-md-10">
									<select id="state" name="state" class="form-control">
										<option disabled="disabled" selected="selected" value="">Select State</option>
										@foreach (['ACT','NSW','NT','QLD','SA','TAS','VIC','WA'] as $state)
											<option value="{{ $state }}"{{ old('state') == $state ? ' selected' : '' }}>{{ $state }}</option>
										@endforeach
									</select>
									@if ($errors->has('state'))
										<span class="help-block"><strong>{{ $errors->first('state') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
								<label class="col-md-2 control-label">Logo</label>
								<div class="col-md-10">
									<input type="file" class="form-control" name="logo" value="{{ old('logo') }}">
									@if ($errors->has('logo'))
										<span class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
									@endif
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-10">
									<button class="btn btn-primary" type="submit">Create Fitter</button>
									<a href="/global-admin/fitters" class="btn btn-default">Cancel</a>
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