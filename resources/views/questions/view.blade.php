@extends('layouts.app')
@section('title', 'View Question Details')
@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Question Details</h5>
				</div>
				<div class="card-body">
					<form method="POST">
						@csrf
						<div class="row">
							<div class="col-xl-12 col-sm-12">
								<div class="mb-3">
									<label for="exampleFormControlInput3" class="form-label text-primary">Select Chapter <span class="required">*</span></label>
									<select class="form-control @error('chapter_id') is-invalid @enderror" name="chapter_id" readonly disabled>
										<option value="">Select</option>
										@foreach($chapters as $chapter)
										<option value="{{$chapter->id}}" @if(old('chapter_id',$response->chapter_id) == $chapter->id) selected @endif>{{$chapter->name}} - {{$chapter->subject_name}} - {{$chapter->standard_name}}</option>
										@endforeach
									</select>
									
								</div>

							</div>
							<div class="col-xl-8 col-sm-8">
								<div class="mb-3">
									<label for="exampleFormControlInput1" class="form-label text-primary">Question Text <span class="required">*</span></label>
									<!--<textarea class="form-control @error('question_text') is-invalid @enderror" placeholder="Question Text" rows="4" name="question_text" id="exampleFormControlInput1">{{old('question_text',$response->question_text)}}</textarea>-->
                                    <p>{!!$response->question_text!!}</p>
									
								</div>
							</div>
							@if($response->question_image!=null)
							<div class="col-xl-4 col-sm-4">
								<div class="mb-3">
									<label class="form-label text-primary">Question Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{url('storage/app')}}/{{$response->question_image}}" id="output" style="width:100%">
											</div>
										</div>
									
									</div>
								</div>

							</div>
							@endif
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-xl-8 col-sm-8">
								<div class="mb-3">
									<label class="form-label text-primary">Option 1 <span class="required">*</span></label>
									<!--<div class="d-flex align-items-center">-->
									<!--	<div class="form-check">-->
									<!--		<input class="form-check-input" type="radio" name="option1_type" value="0" checked @if(old('option1_type',$response->option1_type) =='0') checked @endif id="flexCheckDefault">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault">-->
									<!--			Text-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="form-check ms-3">-->
									<!--		<input class="form-check-input" type="radio" name="option1_type" value="1" @if(old('option1_type',$response->option1_type)=='1') checked @endif id="flexCheckDefault1">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault1">-->
									<!--			Image-->
									<!--		</label>-->
									<!--	</div>-->
									<!--</div>-->
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
								    <p>{!!$response->option1!!}</p>
								
								</div>
								@if($response->option1_image!=null)
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{url('storage/app')}}/{{$response->option1_image}}" id="output1" style="width:100%">
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>
							
							<div class="col-xl-8 col-sm-8">
								<div class="mb-3">
									<label class="form-label text-primary">Option 2 <span class="required">*</span></label>
									<!--<div class="d-flex align-items-center">-->
									<!--	<div class="form-check">-->
									<!--		<input class="form-check-input" type="radio" name="option2_type" value="0" checked @if(old('option2_type',$response->option2_type)=='0') checked @endif id="flexCheckDefault2">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault2">-->
									<!--			Text-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="form-check ms-3">-->
									<!--		<input class="form-check-input" type="radio" name="option2_type" value="1" @if(old('option2_type',$response->option2_type)=='1') checked @endif id="flexCheckDefault3">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault3">-->
									<!--			Image-->
									<!--		</label>-->
									<!--	</div>-->
									<!--</div>-->
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
                                    <p>{!!$response->option2!!}</p>
									
								</div>
									@if($response->option2_image!=null)
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{url('storage/app')}}/{{$response->option2_image}}" id="output1" style="width:100%">
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>

							<div class="col-xl-12">
								<hr>
							</div>
							<div class="col-xl-8 col-sm-8">
								<div class="mb-3">
									<label class="form-label text-primary">Option 3 <span class="required">*</span></label>
									<!--<div class="d-flex align-items-center">-->
									<!--	<div class="form-check">-->
									<!--		<input class="form-check-input" type="radio" name="option2_type" value="0" checked @if(old('option2_type',$response->option2_type)=='0') checked @endif id="flexCheckDefault2">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault2">-->
									<!--			Text-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="form-check ms-3">-->
									<!--		<input class="form-check-input" type="radio" name="option2_type" value="1" @if(old('option2_type',$response->option2_type)=='1') checked @endif id="flexCheckDefault3">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault3">-->
									<!--			Image-->
									<!--		</label>-->
									<!--	</div>-->
									<!--</div>-->
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<p>{!!$response->option3!!}</p>
								</div>
								@if($response->option3_image!=null)
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{url('storage/app')}}/{{$response->option3_image}}" id="output1" style="width:100%">
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>

							<div class="col-xl-8 col-sm-8">
								<div class="mb-3">
									<label class="form-label text-primary">Option 4 <span class="required">*</span></label>
									<!--<div class="d-flex align-items-center">-->
									<!--	<div class="form-check">-->
									<!--		<input class="form-check-input" type="radio" name="option4_type" value="0" checked @if(old('option4_type',$response->option4_type)=='0') checked @endif id="flexCheckDefault6">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault6">-->
									<!--			Text-->
									<!--		</label>-->
									<!--	</div>-->
									<!--	<div class="form-check ms-3">-->
									<!--		<input class="form-check-input" type="radio" name="option4_type" value="1" @if(old('option4_type',$response->option4_type)=='1') checked @endif id="flexCheckDefault7">-->
									<!--		<label class="form-check-label font-w500" for="flexCheckDefault7">-->
									<!--			Image-->
									<!--		</label>-->
									<!--	</div>-->
									<!--</div>-->
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
								    <p>{!!$response->option4!!}</p>
								</div>
								@if($response->option4_image!=null)
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style=""> 	
												<img src="{{url('storage/app')}}/{{$response->option4_image}}" id="output1" style="width:100%">
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>
							<div class="col-lg-12">
								<hr>
							</div>
							<div class="col-xl-8 col-sm-8">
								<div class="mb-3">
									<label class="form-label text-primary">Solution <span class="required">*</span></label>
								</div>
								<div class="mb-3">
									<label for="exampleFormControlInput6" class="form-label text-primary">Text <span class="required">*</span></label>
									<p>{!!$response->solution_text!!}</p>
									@error('solution_text')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								@if($response->solution_image!=null)
								<div class="mb-3">
									<label class="form-label text-primary">Image <span class="required">*</span></label>
									<div class="avatar-upload">
										<div class="avatar-preview">
											<div id="imagePreview" style="width:60% !important"> 	
												<img src="{{url('storage/app')}}/{{$response->solution_image}}" id="output1" style="width:100%">
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label for="exampleFormControlInput3" class="form-label text-primary">Selected Answer Option <span class="required">*</span></label>
									<select class="form-control @error('solution') is-invalid @enderror" name="solution" readonly disabled>
										<option value="">Select</option>
										<option value="option1" @if(old('solution',$response->solution)=='option1') selected @endif>Option 1</option>
										<option value="option2" @if(old('solution',$response->solution)=='option2') selected @endif>Option 2</option>
										<option value="option3" @if(old('solution',$response->solution)=='option3') selected @endif>Option 3</option>
										<option value="option4" @if(old('solution',$response->solution)=='option4') selected @endif>Option 4</option>
										
									</select>
									@error('solution')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>

							</div>
						</div>
						<!--<div class="float-end">-->
						<!--	<button class="btn btn-primary" type="submit">Update Details</button>-->
						<!--</div>-->

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
      $('.summernote').summernote({
        height: 150
      });
    </script>
<script type="text/javascript">
	function showImagePreview(event) {
		var element = document.getElementById("imageUpload");
		var output2 = document.getElementById('output');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
	function showImagePreview1(event) {
		var element = document.getElementById("imageUpload1");
		var output2 = document.getElementById('output1');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}

	function showImagePreview2(event) {
		var element = document.getElementById("imageUpload2");
		var output2 = document.getElementById('output2');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
	function showImagePreview3(event) {
		var element = document.getElementById("imageUpload3");
		var output2 = document.getElementById('output3');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
	function showImagePreview4(event) {
		var element = document.getElementById("imageUpload4");
		var output2 = document.getElementById('output4');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}

	function showImagePreview5(event) {
		var element = document.getElementById("imageUpload5");
		var output2 = document.getElementById('output5');
		output2.src = URL.createObjectURL(event.target.files[0]);
		output2.onload = function () {
			URL.revokeObjectURL(output2.src)
		}
	}
</script>
@endsection