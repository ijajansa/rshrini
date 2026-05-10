@extends('layouts.app')
@section('title', 'Update Standard Details')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Standard Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('standards/edit')}}/{{$data->id}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Standard Name <span class="required">*</span></label>
									<input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name',$data->name)}}" placeholder="e.g. 11th" name="name">
									@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Other Name</label>
									<input type="text" class="form-control form-control-sm @error('other_name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('other_name',$data->other_name)}}" placeholder="e.g. XI" name="other_name">
									@error('other_name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
								
							
						</div>
						<div class="float-start">
							<button class="btn btn-primary" type="submit">Update Details</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function showImagePreview(event) {
		var element = document.getElementById("imageUpload");
		var output2 = document.getElementById('output');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
</script>
@endsection
