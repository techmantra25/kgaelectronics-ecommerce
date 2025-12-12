@extends('admin.layouts.app')

@section('page', 'Settings detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">    
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted small mb-1">Page</p>
                            <p class="text-dark small">{{strtoupper($data->page_heading)}}</p>

                            <p class="text-muted small mb-1">Content</p>
                            <p class="text-dark small">{!!$data->content!!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Edit</h4>
                    @if ($data->page_heading == 'about')
                        <div class="form-group mb-3">
                            <label class="label-control">Content </label>
                            <textarea name="content" id="content" class="form-control">{{$data->content}}</textarea>
                            @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Image 1 </label>
                            <img src="{{asset($data->about_image_1)}}" alt="no-image" width="85px">
                            <input type="file" name="about_image_1" id="about_image_1" class="form-control">
                            @error('about_image_1') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Image 2 </label>
                            <img src="{{asset($data->about_image_2)}}" alt="no-image" width="85px">
                            <input type="file" name="about_image_2" id="about_image_1" class="form-control">
                            @error('about_image_2') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Company Title </label>
                            <input type="text" name="about_company_info_title" id="about_company_info_title" class="form-control" value="{{$data->about_company_info_title}}">
                            @error('about_company_info_title') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Company Description </label>
                            <textarea  name="about_company_info_desc" id="about_company_info_desc" class="form-control">{{$data->about_company_info_desc}}</textarea>
                            @error('about_company_info_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- @else
                        <div class="form-group mb-3">
                            <label class="label-control">Content </label>
                            <textarea name="content" id="content" class="form-control">{{$data->content}}</textarea>
                            @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div> --}}

                    @endif

                    @if ($data->page_heading == 'contact_us')
                    <div class="card">
                        <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                        <div class="card-body p-0">
                            <div class="w-100 product__thumb">
                                <label for="thumbnail"><img id="output" src="{{ asset($data->contact_image) }}" /></label>
                            </div>
                            <input type="hidden" name="content_all" value="">
                            <input type="file" name="contact_image" id="thumbnail" accept="image/*" onchange="loadFile(event)" class="d-none">
                            <script>
                                var loadFile = function(event) {
                                    var output = document.getElementById('output');
                                    output.src = URL.createObjectURL(event.target.files[0]);
                                    output.onload = function() {
                                        URL.revokeObjectURL(output.src) // free memory
                                    }
                                };
                            </script>
                        </div>
                        @error('contact_image') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Google Map Link</label>
                            <textarea name="google_map_link" id="google_map_link" class="form-control" placeholder="Enter google map link">{{$data->google_map_link}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Contact Information</label>
                            <input type="hidden" name="content_all" value="">
                            <textarea type="text" name="contact_info" id="contact_info" class="form-control" value="" placeholder="Enter contact number">{{$data->contact_info}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Address</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Enter full address" >{{$data->address}}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-control">Inquiries & Feedback </label>
                            <textarea name="inqueries_and_feedback" id="inqueries_and_feedback" class="form-control" placeholder="Enter inquiries and feedback">{{$data->inqueries_and_feedback}}</textarea>
                        </div>

                        @else
                        <div class="form-group mb-3">
                            <label class="label-control">Content </label>
                            <textarea name="content_all" id="content_all" class="form-control">{{$data->content}}</textarea>
                            @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    

                    @if ($data->page_heading == 'blog' || $data->page_heading == 'news' || $data->page_heading == 'global')
                    <div class="card">
                        <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                        <div class="card-body p-0">
                            <div class="w-100 product__thumb">
                                <label for="thumbnail"><img id="output" src="{{ asset($data->blog_image) }}" /></label>
                            </div>
                            <input type="hidden" name="content_all" value="">
                            <input type="file" name="blog_image" id="thumbnail" accept="image/*" onchange="loadFile(event)" class="d-none">
                            <script>
                                var loadFile = function(event) {
                                    var output = document.getElementById('output');
                                    output.src = URL.createObjectURL(event.target.files[0]);
                                    output.onload = function() {
                                        URL.revokeObjectURL(output.src) // free memory
                                    }
                                };
                            </script>
                        </div>
                        @error('blog_image') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                    {{-- @else 
                        <div class="form-group mb-3">
                            <label class="label-control">Content </label>
                            <textarea name="content_all" id="content_all" class="form-control">{{$data->content}}</textarea>
                            @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div> --}}
                    @endif

                   
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <button type="submit" class="btn btn-sm btn-danger">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        });

        // Create the second CKEditor instance
       ClassicEditor
    .create( document.querySelector( '#about_company_info_desc' ) )
    .catch( error => {
        console.error( error );
    });

       ClassicEditor
    .create( document.querySelector( '#contact_info' ) )
    .catch( error => {
        console.error( error );
    });
       ClassicEditor
    .create( document.querySelector( '#address' ) )
    .catch( error => {
        console.error( error );
    });
       ClassicEditor
    .create( document.querySelector( '#inqueries_and_feedback' ) )
    .catch( error => {
        console.error( error );
    });
});


 
    </script>
@endsection