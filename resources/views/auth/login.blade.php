@extends('layouts.full-screen')
@section('content')
<div class="page container-fluid">
	<div class="row">
		<div class="login-panel col-xs-12 col-md-4">
			<div class="row banner">
				<div class="banner-img">
					<img src="/images/logo/A_logo.png" class="img-responsive">
				</div>
				<div class="banner-text">
					<h3>Aitken's Saddlery</h3>
					<p>Virtual <nobr>Saddle Fitter</nobr></p>
				</div>
			</div>
			<h1>Welcome!</h1>
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
				{{ csrf_field() }}

				<div class="form-group row @if(old('email')) focus @endif">
					<input type="email" class="form-control" name="email" required="" value="{{ old('email') }}">
					<span class="form-input-placeholder" data-placeholder="Username"></span>
				</div>
				@if ($errors->has('email'))
				<div class="row">
					<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				</div>
				@endif
				<div class="form-group row @if(old('password')) focus @endif">
					<input type="password" name="password" class="form-control" required="">
					<span class="form-input-placeholder" data-placeholder="Enter Your Password"></span>
				</div>
				@if ($errors->has('email'))
				<div class="row">
					<span class="help-block">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				</div>
				@endif

				<div class="row">
					<div class="col-xs-6 content-left">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember"> Remember Me
								</label>
							</div>
						</div>
					</div>
					<div class="col-xs-6 content-right">
						<div class="form-group">
							<a class="btn btn-primary" href="/password/reset">Forgot Password?</a>
						</div>
					</div>
				</div>
				<div class="form-group content-center extra-padding-v">
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-btn fa-sign-in"></i> Sign In
					</button>
				</div>
			</form>
		</div>
		<div class="welcome-panel col-xs-12 col-md-8">
			<div class="wrapper">
				<div class="welcome-message"><h2>Join Us!<br />Aitken's Virtual Saddle Fitter</h2>
				<p>Would you like to be part of the Aitken's Team,<br />please drop us a line and join the team!</p></div>
			</div>
		</div>
	</div>
	<div class="row copyright">
		<nobr>Powered By Aitken's Saddlery</nobr> | <nobr>@ Aitken's Saddlery <?php echo date('Y'); ?></nobr>
	</div>
</div>
@endsection

@section('css')
	<link href="/css/login-page.css" rel="stylesheet">
	<style>
	body {
		background-color: #FFF;
		min-width: 300px;
	}
	.content-left {
		text-align: left;
	}
	.content-right {
		text-align: right;
	}
	.content-center {
		text-align: center;
	}
	.page {
		position:relative;
	}
	.extra-padding-v {
		padding-top: 5em;
		padding-bottom: 5em;
	}
	.login-panel {
		margin-top: 0;
		padding: 2em;
		height: auto;
		text-align: center;
	}
	.login-panel .banner {
		width: 25em;
		margin: 0 auto;
	}
	.login-panel .banner>div {
		float: left;
	}
	.login-panel .banner .banner-img {
		width: 20%;
	}
	.login-panel .banner .banner-text {
		width: 80%;
		padding-left: 1em;
		margin-top: -5px;
		text-align: left;
	}
	.login-panel .banner .banner-text h3 {
		font-size: 2em;
	}
	.login-panel .banner .banner-text p {
		font-size: 1.5em;
	}
	.welcome-panel {
		background-image: none;
		height: auto;
	}
	.welcome-panel .wrapper {
		position: initial;
		width: 100%;
	}
	.welcome-message {
		display: table;
		margin: 0 auto;
	}
	.welcome-message h2 {
		font-weight: bold;
		line-height: 1.5em;
	}
	.welcome-message p {
		font-size: 1.25em;
	}
	.copyright {
		margin-top: 3em;
		padding: 1em;
		width: 100%;
		text-align: center;
	}

	@media (min-width: 30em) {
		.login-panel {
			padding-left: 5em;
			padding-right: 5em;
		}
	}

	@media (min-width: 62em) {
		.login-panel {
			height: 100vh;
		}
		.login-panel .banner {
			width: 20em;
		}
		.login-panel .banner .banner-img {
			width: 26%;
		}
		.login-panel .banner .banner-text {
			width: 74%;
		}
		.login-panel .banner .banner-text h3 {
			display: none;
		}
		.login-panel .banner .banner-text p {
			font-size: 2em;
			font-weight: bold;
		}
		.welcome-panel {
			background-image: url('/images/home.jpg');
			background-size: cover;
			background-position: center;
			height: 100vh;
			min-height:44em;
		}
		.welcome-panel .wrapper {
			position: absolute;
			top: 9.5em;
			bottom: unset;
			width: 100%;
		}
		.copyright {
			position: absolute;
			bottom: 0;
			width: 33.33%;
		}
	}
	@media (min-width: 62em) and (min-height: 36em) {
		.welcome-panel .wrapper {
			top: unset;
			bottom:50vh;
		}
	}
	@media (min-width: 93.5em) and (max-height:60em) {
		.welcome-panel {
			background-position: bottom;
		}
		.welcome-panel .wrapper {
			top: 2em;
			bottom: unset;
		}
	}
	</style>
@endsection

@section('js')
	<script>
		$(document).ready(function(){
			if ($("input[name$='email']").val().length > 0) {
				$("input[name$='email']").parent().addClass('focus');
			}

			if ($("input[name$='password']").val().length > 0) {
				$("input[name$='password']").parent().addClass('focus');
			}
			$(".form-input-placeholder").on('click', function(){
				$(this).parent().addClass('focus');
				$(this).parent().find('input').focus();

			});
			$("input").on('focus', function() {
				$(this).parent().addClass('focus');

				// check if browser auto-fill is activated, then add focus to the input's parent
				if ($(this).is(':-webkit-autofill')) {
					$("input[name$='email']").parent().addClass('focus');
					$("input[name$='password']").parent().addClass('focus');
				}
			});
			$("input").on('focusout', function() {
				if ($(this).val().length == 0) {
					$(this).parent().removeClass('focus');
				}
			});
		});
	</script>
@endsection