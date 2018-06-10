@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<div class="ibox-title">
				<h5>{{ $title or '' }}</h5>
				<div class="ibox-tools">
					<a href="/global-admin/styles/create" class="btn btn-primary btn-xs">Create Style</a>
				</div>
			</div>
			<div class="ibox-content">
				<div class="row">
					<form method="GET" action="/global-admin/styles">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" placeholder="Search Styles" class="input form-control" name="phrase"
									   value="{{ Request::get('phrase') }}">
								<span class="input-group-btn">
									<button type="submit" class="btn btn btn-primary "> <i class="fa fa-search"></i> Search</button>
								</span>
							</div>
						</div>
					</form>
				</div>
				@if (count($styles) > 0)
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Name</th>
							<th>Brand</th>
							<th>Created At</th>
						</tr>
						</thead>
						<tbody class="table_body">
						@foreach($styles as $style)
							<tr>
								<td>{{ $style->name }}</td>
								<td>{{ $style->brand->name }}</td>
								<td>{{ $style->created_at }}</td>
								<td>
									<a href="javascript:show_modal('/global-admin/styles/edit/{{ $style->id }}')"
									   class="btn btn-success btn-xs">Edit</a>
									<a href="javascript:show_modal('/global-admin/styles/delete/{{ $style->id }}')"
									   class="btn btn-danger btn-xs">Delete</a>
								</td>
							</tr>
						@endforeach
						<tr>
							<td colspan="6" align="right">
								{{ $styles->render() }}
							</td>
						</tr>
						</tbody>
					</table>
				@else
					<div class="text-center">
						<p>No Styles to display. Please <a href="/global-admin/styles/create">add</a> one.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
@section('scripts')

@endsection
