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
							
								<th>Product</th>
                                <th>Reviewed by</th>
								<th>Title</th>
								<th>Description</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr>
                               
								
								<td>{{$data->product->name ??''}}</td>
                                <td>
                                   		{{$data->created_by}}
                                   
                                </td>
								<td>{{$data->title}}</td>
								<td>{!!$data->description!!}</td>
                               
                            </tr>
                            
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product-review.update',$data->id) }}" enctype="multipart/form-data">@csrf
                        <h4 class="page__subtitle">Add New</h4>
						<div class="row">
                            <div class="col-md-12">
								<div class="form-group mb-3">
                                <label class="label-control">Product <span class="text-danger">*</span></label>
                                <select class="form-control" name="product_id">
                                    <option hidden selected>Select...</option>
                                    @foreach ($product as $index => $item)
                                        <option value="{{$item->id}}" {{ ($data->product_id == $item->id) ? 'selected' : ''}}>{{ $item->name }} </option>
                                    @endforeach
                                </select>
                                @error('product_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                                <div class="form-group mb-3">
                                    <label class="label-control">Title <span class="text-danger">*</span> </label>
                                    <input type="text" name="title" placeholder="" class="form-control" value="{{old('title',$data->title)}}">
                                    @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
								<div class="form-group mb-3">
                                    <label class="label-control">Description <span class="text-danger">*</span> </label>
                                    <textarea type="text" id="description" name="description" placeholder="" class="form-control"> {{old('description',$data->description)}}</textarea>
                                    @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                             </div>
							<div class="row">
                            <div class="col-md-12 card">
                                <div class="card-header p-0 mb-3">Reviewed by <span class="text-danger">*</span></div>
                                <div class="card-body p-0">
                                    
                                    <input type="text" name="created_by" class="form-control" value="{{old('title',$data->created_by)}}">
                                   
                                </div>
                                @error('thumbnail_image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="row">
                            
							
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