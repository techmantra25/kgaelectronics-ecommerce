@extends('admin.layouts.app')

@section('page', 'Product Video detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">    
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
							<p style="blod">Thumbnail Image</p>
                                    <img src="{{ asset($data->file_path) }}" height="200" width="200">
                                    <br>
                               <p style="blod">Product Video</p>
                                <video id="onn-video" style="width: 50%" autoplay muted loop controls playsinline>
                                    <source src="{{ asset($data->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product-video.update', $data->id) }}" enctype="multipart/form-data">@csrf
                        <h4 class="page__subtitle">Edit</h4>
						<div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="label-control">Title <span class="text-danger">*</span> </label>
                                    <input type="text" name="title" placeholder="" class="form-control" value="{{old('title',$data->title)}}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                             </div>
							<div class="row">
                            <div class="col-md-12 card">
                                <div class="card-header p-0 mb-3">Thumbnail Image <span class="text-danger">*</span></div>
                                <div class="card-body p-0">
                                    <div class="w-100 product__thumb">
                                        <label for="icon"><img id="iconOutput" src="{{ asset('admin/images/placeholder-image.jpg') }}" /></label>
                                    </div>
                                    <input type="file" name="image" id="icon" accept="image/*" onchange="loadIcon(event)" class="d-none">
                                    <p class="small text-muted">Click here to browse video</p>
									<p class="small text-danger">Image Size: 640px X 360px</p>
                                    <script>
                                        let loadIcon = function(event) {
                                            let iconOutput = document.getElementById('iconOutput');
                                            iconOutput.src = URL.createObjectURL(event.target.files[0]);
                                            iconOutput.onload = function() {
                                                URL.revokeObjectURL(iconOutput.src) // free memory
                                            }
                                        };
                                    </script>
                                </div>
                                @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 card">
                                <div class="card-header p-0 mb-3">Video <span class="text-danger">*</span></div>
                                <div class="card-body p-0">
                                    <div class="w-100 product__thumb">
                                        
                                    </div>
                                    <input type="file" name="video"  accept="image/*">
                                    <p class="small text-muted">Click here to browse video</p>

                                   
                                </div>
                                @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-danger">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection