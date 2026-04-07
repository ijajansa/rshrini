@extends('layouts.app')
@section('title', 'Update Chapter Format')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Chapter Details</h5>
				</div>
				<div class="card-body">
					<form method="POST" action="{{url('chapters/format/edit')}}/{{$record->id}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">
							<input type="hidden" name="type" value="{{$record->type}}">
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Select Chapters <span class="required">*</span></label>
										<select id="inputState1" name="chapter_id" class=" form-control form-control-sm @error('chapter_id') is-invalid @enderror" tabindex="null">
											@foreach($chapters as $chapter)
											<option value="{{$chapter->id}}" @if(old('chapter_id',$record->chapter_id)==$chapter->id) selected @endif>{{$chapter->name. " - ".$chapter->subject_name." (".$chapter->standard_name. " ".$chapter->medium_name.")"}}</option>
											@endforeach
										</select>
									@error('chapter_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
								    
								    <label for="exampleFormControlInput5" class="form-label">Upload File <span class="required">*</span></label>
									<input type="file" class="form-control form-control-sm @error('file') is-invalid @enderror" id="exampleFormControlInput5" value="{{old('file')}}" name="file">
									@error('file')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
									<div>
										@if($record->type==0)
										<label class="form-label" style="margin-top: 10px;">Uploaded Audio</label><br>
										<a target="_blank" href="{{url('storage/app')}}/{{$record->link}}">{{$record->link}}</a>
										@elseif($record->type ==1)
										<label class="form-label" style="margin-top: 10px;">Uploaded Video</label><br>
										<a target="_blank" href="{{url('storage/app')}}/{{$record->link}}">{{$record->link}}</a>
										@else
										<label class="form-label" style="margin-top: 10px;">Uploaded PDF</label><br>
										<a target="_blank" href="{{url('storage/app')}}/{{$record->link}}">{{$record->link}}</a>									
										@endif
									</div>
								</div>
							</div>
							
						</div>
						<div class="float-end">
							<button class="btn btn-primary" type="submit">Update Details</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection