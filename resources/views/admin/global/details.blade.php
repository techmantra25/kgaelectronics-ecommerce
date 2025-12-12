@extends('admin.layouts.app')

@section('page', 'Global detail')

@section('content')
<section>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">    
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted small mb-1">Title</p>
                            <p class="text-dark small">{{$data->title}}</p>

                            <p class="text-muted small mb-1">Content</p>
                            <p class="text-dark small">{!!$data->content!!}</p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.global.update',$data->id) }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Edit Global</h4>
                        <div class="row">
                            <div class="form-group mb-3">
                                <label class="label-control">Title <span class="text-danger">*</span> </label>
                                <input type="text" name="title" placeholder="Enter Title" class="form-control" value="{{$data->title}}">
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="label-control">Content <span class="text-danger">*</span> </label>
                                <textarea type="text" name="content" id="content" placeholder="" class="form-control">{{strip_tags($data->content)}}</textarea>
                                @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
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
       ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        });
    </script>
@endsection