@extends('admin.layouts.app')

@section('page', 'MARKETING & SALES PROMOTION DETAILS')

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

                            <p class="text-muted small mb-1">Image</p>
                            <img src="{{asset($data->image)}}" alt="no-image" width="40%">

                            <p class="text-muted small mb-1">Description</p>
                            <p class="text-dark small">{{$data->description}}</p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.franchise.marketing.update', $data->id ) }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">EDIT MARKETING & SALES PROMOTION</h4>
                        <div class="row">
                            <div class="col-md-12 card">
                                <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                                
                                
                                <div class="card-body p-0">
                                    <div class="w-100 product__thumb">
                                        <label for="icon"><img id="iconOutput" src="{{ asset($data->image) }}" /></label>
                                    </div>
                                    <input type="file" name="image" id="icon" accept="image/*" onchange="loadIcon(event)" class="d-none">
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
                            <div class="form-group mb-3">
                                <label class="label-control">Title <span class="text-danger">*</span> </label>
                                <input type="text" name="title" placeholder="Enter Title" class="form-control" value="{{$data->title}}">
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="label-control">Description <span class="text-danger">*</span> </label>
                                <textarea type="text" name="description" id="description" placeholder="Enter description" class="form-control">{{$data->description}}</textarea>
                                @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
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
    
@endsection