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
					<form id="uploadForm" method="POST" action="{{url('chapters/format/edit')}}/{{$record->id}}"  enctype="multipart/form-data">
						@csrf
						<div class="row">
							<input type="hidden" name="type" value="{{$record->type}}">
							<div class="col-xl-6 col-sm-6">
								<div class="mb-3">
									<label class="form-label">Select Chapters <span class="required">*</span></label>
										<select id="chapterId" name="chapter_id" class=" form-control form-control-sm @error('chapter_id') is-invalid @enderror" tabindex="null">
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
								    
								    <label for="fileInput" class="form-label">Upload File <span class="required">*</span></label>
									<input type="file" class="form-control form-control-sm @error('file') is-invalid @enderror" id="fileInput" name="file">
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

						<!-- Progress Bar Section -->
						<div id="progressSection" class="mb-3" style="display: none;">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<label class="form-label mb-0">Upload Progress</label>
								<span id="progressPercentage" class="badge bg-primary">0%</span>
							</div>
							<div class="progress" style="height: 25px; background-color: #f0f0f0; border-radius: 5px; overflow: hidden;">
								<div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%; background: linear-gradient(90deg, #4D44B5 0%, #FB7D5B 100%); height: 100%; transition: width 0.3s ease; display: flex; align-items: center; justify-content: center;">
									<small style="color: white; font-weight: 500; font-size: 12px;">0%</small>
								</div>
							</div>
							<small id="uploadStatus" class="text-muted d-block mt-2">Preparing upload...</small>
						</div>

						<!-- Alert Messages -->
						<div id="alertContainer" class="mb-3"></div>

						<div class="float-end">
							<button id="submitBtn" class="btn btn-primary" type="submit">Update Details</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{asset('assets/js/file-upload-progress.js')}}"></script>

@endsection