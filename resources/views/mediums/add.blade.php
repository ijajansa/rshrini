@extends('layouts.app')
@section('title', 'Add New Medium')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Medium Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('mediums/add')}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Select Standard <span class="required">*</span></label>
									<div class="dropdown bootstrap-select default-select form-control wide">
										<select id="inputState" name="standard_id" class="default-select form-control form-control-sm wide @error('standard_id') is-invalid @enderror" tabindex="null">
											@foreach($standards as $standard)
											<option value="{{$standard->id}}" @if(old('standard_id')==$standard->id) selected @endif>{{$standard->name}}</option>
											@endforeach
										</select>
									</div>
									@error('standard_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>	

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Medium Name</label>
									<input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name')}}" placeholder="e.g. English" name="name">
									@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
								
							
						</div>
						<div class="float-start">
							<button class="btn btn-primary" type="submit">Save Details</button>
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