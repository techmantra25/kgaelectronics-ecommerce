@extends('admin.layouts.app')

@section('page', 'Product Review')

@section('content')
<style>
    .file-holder img {
        height: 100px
    }
</style>

<section>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
								<th>#SR</th>
								<th>Product</th>
                                <th>Reviewed By</th>
								<th>Title</th>
								<th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
								<th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
								<td>{{$item->product->name ??''}}</td>
								<td>{{$item->created_by}}</td>
                                
                                   
                                
								<td>{{$item->title}}
								 <div class="row__action">
                                        <a href="{{ route('admin.product-review.view', $item->id) }}">Edit</a>
                                        <a href="{{ route('admin.product-review.view', $item->id) }}">View</a>
                                        <a href="{{ route('admin.product-review.status', $item->id) }}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</a>
                                        <a href="{{ route('admin.product-review.delete', $item->id) }}" onclick="return confirm('Are you sure?')" class="text-danger">Delete</a>
                                    </div>
								</td>
								<td>{!!$item->description!!}</td>
                                <td>Published<br/>{{date('d M Y', strtotime($item->created_at))}}</td>
                                <td><span class="badge bg-{{($item->status == 1) ? 'success' : 'danger'}}">{{($item->status == 1) ? 'Active' : 'Inactive'}}</span></td>
								<td><a href="{{ route('admin.product-review.trending', $item->id) }}" class="text-decoration-none">
								@if ($item->is_featured == 1)
									<span class="text-success fw-bold"> <i class="fi-br-check"></i> Featured</span>
								@else
									<span class="text-danger fw-bold single-line"> <i class="fi-br-plus"></i>
										Featured</span>
								@endif
									</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="100%" class="small text-muted">No data found</td></tr>
                            @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product-review.store') }}" enctype="multipart/form-data">@csrf
                        <h4 class="page__subtitle">Add New</h4>
						<div class="row">
                            <div class="col-md-12">
								<div class="form-group mb-3">
                                <label class="label-control">Product <span class="text-danger">*</span></label>
                                <select class="form-control" name="product_id">
                                    <option hidden selected>Select...</option>
                                    @foreach ($product as $index => $item)
                                        <option value="{{$item->id}}" {{ (old('product_id') == $item->id) ? 'selected' : ''}}>{{ $item->name }} </option>
                                    @endforeach
                                </select>
                                @error('product_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Title <span class="text-danger">*</span> </label>
                                    <input type="text" name="title" placeholder="" class="form-control" value="{{old('title')}}">
                                    @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
								<div class="form-group mb-3">
                                    <label class="label-control">Description <span class="text-danger">*</span> </label>
                                    <textarea type="text" id="description" name="description" placeholder="" class="form-control" value="{{old('description')}}"></textarea>
                                    @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                             </div>
							<div class="row">
                            
                        <div class="row">
                            <div class="col-md-12 card">
                                <div class="card-header p-0 mb-3">Reviewed by <span class="text-danger">*</span></div>
                                <div class="card-body p-0">
                                    <div class="w-100 product__thumb">
                                       
                                    </div>
                                    <input type="text" name="created_by" class="form-control">
                                  
                                   
                                </div>
                                @error('created_by') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
							
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-danger">Add New</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
	<script>
    ClassicEditor.create( document.querySelector( '#description' ) ).catch( error => {
        console.error( error );
    });

   
	</script>
@endsection