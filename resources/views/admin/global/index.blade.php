@extends('admin.layouts.app')

@section('page', 'Global')

@section('content')
<section>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">    
                <div class="card-body">

                   
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($global as $index => $item)
                            <tr>
                               
                                <td>
                                    {{$item->title}}
                                <div class="row__action">
                                    <a href="{{ route('admin.global.view', $item->id) }}">Edit</a>
                                    <a href="{{ route('admin.global.view', $item->id) }}">View</a>
                                    <a href="{{ route('admin.global.status', $item->id) }}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</a>
                                    <a href="{{ route('admin.global.delete', $item->id) }}" class="text-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                                </td>
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
                    <form method="POST" action="{{ route('admin.global.store') }}" enctype="multipart/form-data">
                    @csrf
                        <h4 class="page__subtitle">Add New</h4>
                        <div class="row">
                          
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