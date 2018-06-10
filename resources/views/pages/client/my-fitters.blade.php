@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<router-view></router-view>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="/js/client/my-fitters/my-fitters.js"></script>
@endsection