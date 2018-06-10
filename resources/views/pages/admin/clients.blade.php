@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<router-view></router-view>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="/js/admin/clients/clients.js"></script>
@endsection