@extends('admin.layouts.app')

@section('page', 'Blog')

@section('content')
<section>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">    
                <div class="card-body">

                   
                    <table class="table">
                        <thead>
                            <tr>
                                
                                <th class="text-center"><i class="fi fi-br-picture"></i></th>

                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                            <tr>
                               
                                <td>
                                <img src="{{ asset($item->image) }}" height="50">
                                <div class="row__action">
                                    <a href="{{ route('admin.blog.view', $item->id) }}">Edit</a>
                                    <a href="{{ route('admin.blog.view', $item->id) }}">View</a>
                                    <a href="{{ route('admin.blog.status', $item->id) }}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</a>
                                    <a href="{{ route('admin.blog.delete', $item->id) }}" class="text-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                                </td>
                                <td>{{$item->title}}</td>
                                <td>Published<br/>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td><span class="badge bg-{{($item->status == 1) ? 'success' : 'danger'}}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Add New</h4>
                        <div class="row">
                            <div class="col-md-12 card">
                                <div class="card-header p-0 mb-3">Image <span class="text-danger">*</span></div>
                                
                                
                                <div class="card-body p-0">
                                    <div class="w-100 product__thumb">
                                        <label for="icon"><img id="iconOutput" src="{{ asset('admin/images/placeholder-image.jpg') }}" /></label>
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
                                <input type="text" name="title" placeholder="Enter Title" class="form-control" value="{{old('title')}}">
                                @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="label-control">Content <span class="text-danger">*</span> </label>
                                <textarea type="text" name="content" id="content" placeholder="" class="form-control">{{old('content')}}</textarea>
                                @error('content') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-danger">Add New</button>
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