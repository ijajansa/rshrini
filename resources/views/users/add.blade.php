@extends('layouts.app')
@section('title', 'Add New User')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Personal Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('users/add')}}">
						@csrf
						<div class="row">
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Full Name <span class="required">*</span></label>
									<input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name')}}" placeholder="Enter Full Name" name="name">
									@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="col-xl-6 col-sm-6">

								<div class="mb-3">
									<label for="exampleFormControlInput3" class="form-label text-primary">Email Address<span class="required">*</span></label>
									<input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput3" value="{{old('email')}}" placeholder="Enter Email Address" name="email">
									@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

							</div>
							<div class="col-xl-6 col-sm-6">

								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Contact Number <span class="required">*</span></label>
									<input type="number" class="form-control @error('contact_number') is-invalid @enderror" id="exampleFormControlInput6" value="{{old('contact_number')}}" placeholder="Enter Contact Number" name="contact_number">
									@error('contact_number')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput9" class="form-label text-primary">Password <span class="required">*</span></label>
									<input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleFormControlInput9" placeholder="Enter Password" name="password" value="{{old('password')}}">
									@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

						</div>
						<div class="float-end">
							<button class="btn btn-primary" type="submit">Save Details</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection