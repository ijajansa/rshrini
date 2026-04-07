@extends('layouts.app')
@section('title', 'Add New Subject')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Subject Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('subjects/add')}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">

							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Name <span class="required">*</span></label>
									<input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" id="exampleFormControlInput1" value="{{old('name')}}" placeholder="Enter Name" name="name">
									@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Select Standard/Medium <span class="required">*</span></label>
									<div class="dropdown bootstrap-select default-select form-control wide">
										<select id="inputState" name="standard_id" class="default-select form-control form-control-sm wide @error('standard_id') is-invalid @enderror" tabindex="null">
											@foreach($data as $ans)
											<option value="{{$ans->id}}" @if(old('standard_id')==$ans->id) selected @endif>{{$ans->standard_name}} ({{$ans->name}})</option>
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
							<!-- <div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label text-primary">Subject Type <span class="required">*</span></label>
									<div class="d-flex align-items-center">
									    @if(request()->type=='pdf')
										<div class="form-check">
											<input class="form-check-input" type="radio" name="type" value="PDF" checked @if(old('type')=='PDF') checked @endif id="flexCheckDefault">
											<label class="form-check-label font-w500" for="flexCheckDefault">
												PDF
											</label>
										</div>
										@else
										<div class="form-check">
											<input class="form-check-input" type="radio" name="type" value="MCQ" @if(old('type')=='MCQ') checked @endif checked id="flexCheckDefault1">
											<label class="form-check-label font-w500" for="flexCheckDefault1">
												MCQ
											</label>
										</div>
                                        @endif

									</div>
								</div>
							</div> -->


							<div class="col-xl-6 col-sm-6">
								
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{asset('assets/images/default.svg')}}" id="output" style="width:90px;height:90px">
											</div>
										</div>
										<div class="change-btn mt-2 mb-lg-0 mb-3">
											<input type="file" class="form-control d-none @error('image') is-invalid @enderror" id="imageUpload" name="image" onchange="showImagePreview(event)" accept=".png, .jpg, .jpeg">
											<label for="imageUpload" class="dlab-upload mb-0 btn btn-primary btn-sm">Choose File</label>
											@error('image')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
										</div>
										
									</div>	
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