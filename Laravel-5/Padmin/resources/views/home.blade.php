@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading"><h2>Lista de Usuarios</h2></div>
					<div class="panel-body">
						<table class="table table-hover" id="userlist">
						<thead>
							<td class="info">General Information</td>
							<td class="info">Other Information</td>
						</thead>
						<tbody>
							@foreach($Users as $user)
							<tr>
								<td>
									<b>Name: </b>{{ $user-> name}}<br>
									<b>User name:</b>  {{ $user-> username}}<br>
									<b>Email:</b> {{ $user-> email}}
								</td>
								<td>
									<ul>
										<li><b>Phone: </b>{{ $user-> phone}}</li>
										<li><b>Website: </b><a href="http://www.{{ $user-> website}}">{{ $user-> website}}</a></li>

										<li> <b>Address</b>
											<ul>
												<li><b>City: </b>{{ $user-> address->city }}</li>
												<li><b>Zipcode:</b> {{ $user-> address->zipcode }}</li>
												<li><b>Street:</b> {{ $user-> address->street }}</li>
												<li><b>Suite: </b>{{ $user-> address->suite }}</li>
											</ul>
										</li>

										<li> <b>Company</b>
											<ul>
												<li><b>Name:</b> {{ $user-> company->name }}</li>
												<li><b>Slogan:</b> {{ $user-> company->catchPhrase }}</li>
												<li><b>BS: </b>{{ $user-> company->bs }}</li>
											</ul>
										</li>
									</ul>

								</td>
							</tr>
							@endforeach
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


