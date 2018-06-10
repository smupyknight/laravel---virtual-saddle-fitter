<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="expires" content="0" />
		<title>{{ $title }} - Virtual Saddle Fitter</title>

		<!-- site icon -->
		<link rel="icon" type="image/png" sizes="32x32" href="/images/icon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/images/icon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/images/icon/favicon-16x16.png">

		{{--<link href="/css/bootstrap.min.css" rel="stylesheet">--}}
		<link href="/css/app.css" rel="stylesheet">
		<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="/css/daterangepicker.css" rel="stylesheet"/>
		<link href="/css/datetimepicker.css" rel="stylesheet"/>
		<link href="/css/animate.css" rel="stylesheet">
		<link href="/css/style.css" rel="stylesheet">
		<link href="/css/tooltip-under-the-box.css" rel="stylesheet">


		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	<body>
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav metismenu" id="side-menu">
					<li class="nav-header">
						<div class="dropdown profile-element">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="clear">
									<span class="block m-t-xs">
										<h1 style="color: #2980b9;">VSF</h1>
										<p>Welcome, <strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</strong></p>
									</span>
								</span>
							</a>
						</div>
						<div class="logo-element">
							VSF
						</div>
					</li>
					@if (Auth::user()->isFitter())
						<li{!! Request::is('admin/dashboard*') ? ' class="active"' : '' !!}><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a></li>
						<li{!! Request::is('admin/clients*') ? ' class="active"' : '' !!}><a href="/admin/clients"><i class="fa fa-user"></i> <span class="nav-label">Clients</span></a></li>
						<li{!! Request::is('admin/horses*') ? ' class="active"' : '' !!}><a href="/admin/horses"><i class="fa fa-car"></i> <span class="nav-label">Horses</span></a></li>
						<li{!! Request::is('admin/riders*') ? ' class="active"' : '' !!}><a href="/admin/riders"><i class="fa fa-users"></i> <span class="nav-label">Riders</span></a></li>
						<li{!! Request::is('admin/saddles*') ? ' class="active"' : '' !!}><a href="/admin/saddles"><i class="fa fa-wheelchair"></i> <span class="nav-label">Saddles</span></a></li>
						<li{!! Request::is('admin/bookings*') ? ' class="active"' : '' !!}><a href="/admin/bookings"><i class="fa fa-list"></i> <span class="nav-label">Bookings</span></a></li>
						<li{!! Request::is('admin/fitchecks*') ? ' class="active"' : '' !!}><a href="/admin/fitchecks"><i class="fa fa-list-ol"></i> <span class="nav-label">Fit Checks</span></a></li>
					@endif
					@if (Auth::user()->isGlobalAdmin())
						<li{!! Request::is('global-admin/dashboard*') ? ' class="active"' : '' !!}><a href="/global-admin/dashboard"><i class="fa fa-briefcase"></i> <span class="nav-label">Dashboard</span></a></li>
						<li{!! Request::is('global-admin/fitters*') ? ' class="active"' : '' !!}><a href="/global-admin/fitters"><i class="fa fa-briefcase"></i> <span class="nav-label">Organisations</span></a></li>
					@endif
					@if (Auth::user()->isClientUser())
						<li{!! Request::is('client/dashboard*') ? ' class="active"' : '' !!}><a href="/client/dashboard"><i class="fa fa-briefcase"></i> <span class="nav-label">Dashboard</span></a></li>
						<li{!! Request::is('client/horses*') ? ' class="active"' : '' !!}><a href="/client/horses"><i class="fa fa-car"></i> <span class="nav-label">Horses</span></a></li>
						<li{!! Request::is('client/riders*') ? ' class="active"' : '' !!}><a href="/client/riders"><i class="fa fa-users"></i> <span class="nav-label">Riders</span></a></li>
						<li{!! Request::is('client/my-fitters*') ? ' class="active"' : '' !!}><a href="/client/my-fitters"><i class="fa fa-briefcase"></i> <span class="nav-label">My Fitters</span></a></li>
						<li{!! Request::is('client/bookings*') ? ' class="active"' : '' !!}><a href="/client/bookings"><i class="fa fa-list"></i> <span class="nav-label">Bookings</span></a></li>
					@endif
				</ul>
			</div>
		</nav>

		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
					<ul class="nav navbar-top-links navbar-right">
						<li><a href="/logout" onclick="event.preventDefault();$('#logout-form').submit();"><i class="fa fa-sign-out"></i> Log out</a></li>
					</ul>
					<form id="logout-form" action="/logout" method="POST" style="display:none">
						{{ csrf_field() }}
					</form>
				</nav>
			</div>

			<div id="app">
				@yield('content')
			</div>
			<div class="footer">
				<div>
					<strong>Copyright</strong> Virtual Saddle Fitter &copy; {{ date('Y') }}
				</div>
			</div>
		</div>
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>

		<script src="{{ mix('/js/manifest.js') }}"></script>
		<script src="{{ mix('/js/vendor.js') }}"></script>

		<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="/js/inspinia.js"></script>
		<script src="/js/plugins/pace/pace.min.js"></script>
		<script src="/js/common.js"></script>
		<script src="/js/bootbox.min.js"></script>
		<script src="/js/moment.min.js"></script>
		<script src="/js/daterangepicker.js"></script>

		@yield('scripts')
	</body>
</html>
