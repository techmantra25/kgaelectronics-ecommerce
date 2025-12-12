@extends('admin.layouts.app')

@section('page', 'Edit Product')

@section('content')
<style>
	  .images-preview-div img
		{
		padding: 10px;
		max-width: 100px;
		}

 
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
           
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #1833FF;
            margin-top: 50px;
        }
    

    .label-control {
        color: #525252;
        font-size: 12px;
    }
    .color_holder {
        display: flex;
        border: 1px dashed #ddd;
        border-radius: 6px;
        padding: 5px;
        background: #f0f0f0;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .color_holder_single {
        margin: 5px;
    }
    .color_box {
        display: flex;
        padding: 6px 10px;
        border-radius: 3px;
        align-items: center;
        margin: 0;
        background: #fff;
    }
    .color_box p {
        margin: 0;
        margin-left: 10px;
    }
    .color_box span, .color_box img {
        display: inline-block;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        /* margin-right: 10px; */
    }
    .sizeUpload {
        margin-bottom: 10px;
    }
    .size_holder {
        padding: 10px 0;
        border-top: 1px solid #ddd;
    }
    .img_thumb img {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        object-fit: cover;
    }
    .remove_image {
        display: inline-flex;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        position: absolute;
        top: 0;
        right: 0;
    }
    .remove_image i {
        line-height: 13px;
    }
    .image_upload {
        display: inline-flex;
        padding: 0 20px;
        border:  1px solid #ccc;
        background: #ddd;
        padding: 5px 12px;
        border-radius: 3px;
        vertical-align: top;
        cursor: pointer;
    }
    .status-toggle {
        padding: 6px 10px;
        border-radius: 3px;
        align-items: center;
        background: #fff;
    }
    .status-toggle a {
        text-decoration: none;
        color: #000
    }
    .color_holder {
        display: flex;
        border: 1px dashed #ddd;
        border-radius: 6px;
        padding: 5px;
        background: #f0f0f0;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .color_holder_single {
        margin: 5px;
    }
    .color_box {
        display: flex;
        padding: 6px 10px;
        border-radius: 3px;
        align-items: center;
        margin: 0;
        background: #fff;
    }
    .sizeUpload {
        margin-bottom: 10px;
    }
    .img_thumb {
        width: 100%;
        padding-bottom: calc((4/3)*100%);
        position: relative;
        border:  1px solid #ccc;
        max-width: 80px;
        min-width: 80px;
    }
    .img_thumb img {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        object-fit: cover;
    }
    .remove_image {
        display: inline-flex;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
        position: absolute;
        top: 0;
        right: 0;
    }
    .remove_image i {
        line-height: 13px;
    }
    .image_upload {
        display: inline-flex;
        padding: 0 20px;
        border:  1px solid #ccc;
        background: #ddd;
        padding: 5px 12px;
        border-radius: 3px;
        vertical-align: top;
        cursor: pointer;
    }
    .status-toggle {
        padding: 6px 10px;
        border-radius: 3px;
        align-items: center;
        background: #fff;
    }
    .status-toggle a {
        text-decoration: none;
        color: #000
    }
    .color-fabric-image-holder {
        width: 36px;
        height: 36px;
    }
    .color-fabric-image {
        width: inherit;
        height: inherit;
        border-radius: 50%;
    }
    .change-image {
        position: absolute;
        bottom: -4px;
        right: -8px;
        background: #c1080a;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        padding: 0 0;
    }
    .change-image .badge {
        padding: 3px;
        cursor: pointer;
    }
    .croppie-container {
        height: auto;
    }
	
	.save-btn {
		width: 200px;
	}
	
	.upload__box {
	 padding: 16px;
    }
    .upload__inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .upload__btn {
        display: inline-block;
        font-weight: 600;
        color: #fff;
        text-align: center;
        min-width: 116px;
        padding: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
        background-color: #dc3545;
        border-color: #dc3545;
        border-radius: 4px;
        line-height: 26px;
        font-size: 14px;
    }
	.upload__btn p {
		margin: 0;
	}
    .upload__btn:hover {
        background-color: unset;
        color: #dc3545;
        transition: all 0.3s ease;
    }
    .upload__btn-box {
        margin-bottom: 10px;
    }
    .upload__img-wrap {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .upload__img-box {
        width: 200px;
        padding: 0 10px;
        margin-bottom: 12px;
    }
    .upload__img-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        line-height: 24px;
        z-index: 1;
        cursor: pointer;
    }
    .upload__img-close:after {
        content: '\2716';
        font-size: 14px;
        color: white;
    }
    .img-bg {
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        padding-bottom: 100%;
    }
 
</style>

<section>
    
		@if($errors->any())
								
			@foreach($errors->all() as $error)
											
				<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
					<script type="text/javascript">
						swal({
                                title: "Error!",
                                text: "{{ $error }}",
                                type: "error",
                                icon: "error",
                                
                                })
				</script>
			@endforeach
		@endif
		<form method="POST" action="{{ route('admin.product.update') }}" enctype="multipart/form-data" name="images-upload-form">
        <div class="row">
            <div class="col-sm-9">

                    @csrf
                    @if (Session::has('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row mb-3">
                                
                                <div class="col-sm-12">
                                    <label class="label-control">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" name="cat_id">
                                        <option hidden selected>Select...</option>
                                        @foreach ($categories as $index => $item)
                                            <option value="{{$item->id}}" {{ ($data->cat_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="label-control">Product Title <span class="text-danger">*</span></label>
                                <input type="text" name="product_name" placeholder="Add Product Title" class="form-control" value="{{$data->name}}">
                                @error('product_name') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
							<div class="row align-items-center">
                            <div class="col-sm-12">
                                <label class="label-control">Product Sub Heading <span class="text-danger">*</span></label>
                                <div class="form-group mb-3">
                                    <input type="text" name="sub_heading" placeholder="Add Product sub heading" class="form-control" value="{{old('sub_heading',$data->sub_heading)}}">
                                    @error('sub_heading') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <label class="label-control">Short Description </label>
                            <textarea id="product_short_des" name="short_desc">{{$data->short_desc}}</textarea>
                            @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <label class="label-control">Description </label>
                            <textarea id="product_des" name="desc">{{$data->desc}}</textarea>
                            @error('desc') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <label class="label-control">Short Content </label>
                            <textarea id="short_content" name="short_content">{{$data->short_content}}</textarea>
                            @error('short_content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <label class="label-control">Long Content </label>
                            <textarea id="long_content" name="long_content">{{$data->long_content}}</textarea>
                            @error('long_content') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body pt-0">
                            <div class="admin__content">
                                <aside>
                                    <nav>Price <span class="text-danger">*</span></nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                    <div class="col-3">
                                        <label for="inputPassword6" class="col-form-label">MRP</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="price" value="{{$data->price}}">
                                        @error('price') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                    <div class="col-3">
                                        <label for="inputprice6" class="col-form-label">Offer Price</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="offer_price" value="{{$data->offer_price}}">
                                        @error('offer_price') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    </div>
                                </content>
                            </div>
                            <div class="admin__content">
                                <aside>
                                    <nav>Meta</nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="inputPassword6" class="col-form-label">Title</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="meta_title" value="{{$data->meta_title}}">
                                            @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="inputprice6" class="col-form-label">Description</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="meta_desc" value="{{$data->meta_desc}}">
                                            @error('meta_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="inputprice6" class="col-form-label">Keyword</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="meta_keyword" value="{{$data->meta_keyword}}">
                                            @error('meta_keyword') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </content>
                            </div>
                            <div class="admin__content">
                                <aside>
                                    <nav>Data </nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                    <div class="col-3">
                                        <label for="inputPassword6" class="col-form-label">Model No</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="style_no" value="{{$data->style_no}}">
                                        @error('style_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    </div>
                                </content>
                            </div>
                            <div class="admin__content">
                                <aside>
                                    <nav>Pack </nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="inputPassword6" class="col-form-label">Net Qty</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="pack" value="{{ old('pack') ? old('pack') : $data->pack }}">
                                            @error('pack') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </content>
                            </div>
							<div class="admin__content">
                                <aside>
                                    <nav>Variation </nav>
                                </aside>
                                <content>
                                    <div class="row mb-2 align-items-center">
                                        <div class="col-3">
                                            <label for="inputPassword6" class="col-form-label">Color</label>
                                        </div>
                                        <div class="col-9">
                                            <select class="form-control" name="color_id">
                                                <option value="" disabled hidden selected>Select...</option>
                                                @foreach($colors as $colorIndex => $colorValue)
                                                    <option value="{{$colorValue->id}}" {{ ($data->color_id == $colorValue->id) ? 'selected' : '' }}><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{$colorValue->code}} " stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>
                                       {{$colorValue->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('color_id') <p class="small text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </content>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-header">
                                Primary Image
                        </div>
                        <div class="card-body">
                            <div class="w-100 product__thumb">
                                <label for="thumbnail"><img id="output" src="{{ asset($data->image) }}"/></label>
                                @error('product_image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <input type="file" id="thumbnail" accept="image/*" name="product_image" onchange="loadFile(event)" class="d-none">
                            <small>Image Size: 870px X 1160px</small>
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
                    </div>
				<div class="card shadow-sm">
                        <div class="card-header">
                                Banner Image
                        </div>
                        <div class="card-body">
                            <div class="w-100 product__thumb">
                                <label for="banner_image"><img id="bannerimage" src="{{ asset($data->banner_image) }}"/></label>
                                @error('banner_image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <input type="file" id="banner_image" accept="image/*" name="banner_image" onchange="loadPrimary(event)" class="d-none">
                            <small>Image Size: 870px X 1160px</small>
                            <script>
                                var loadPrimary = function(event) {
                                    var output1 = document.getElementById('bannerimage');
                                    output1.src = URL.createObjectURL(event.target.files[0]);
                                    output1.onload = function() {
                                    URL.revokeObjectURL(output1.src) // free memory
                                    }
                                };
                            </script>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Thumbnail Image
                        </div>
                        <div class="card-body">
                            <div class="w-100 product__thumb">
                                <label for="thumbnail_image"><img id="thumbnailimage" src="{{ asset($data->thumbnail_image) }}"/></label>
                                @error('thumbnail_image') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                            <input type="file" id="thumbnail_image" accept="image/*" name="thumbnail_image" onchange="loadThumbnail(event)" class="d-none">
                            <small>Image Size: 870px X 1160px</small>
                            <script>
                                var loadThumbnail = function(event) {
                                    var output2 = document.getElementById('thumbnailimage');
                                    output2.src = URL.createObjectURL(event.target.files[0]);
                                    output2.onload = function() {
                                    URL.revokeObjectURL(output2.src) // free memory
                                    }
                                };
                            </script>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        
                        <div class="upload__box">
                            <div class="upload__btn-box">
                                <label class="upload__btn">
                                    {{--@error('images') <p class="small text-danger">{{ $message }}</p> @enderror--}}
                                <p>Upload more images</p>
                                <input type="file" name="images[]" multiple="" data-max_length="20" class="upload__inputfile">
                                    
                                </label>
                            </div>
                            <div class="upload__img-wrap"></div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header">
                            Upload more Videos
                        </div>
                        <div class="card-body">
                            {{-- @error('video') <p class="small text-danger">{{ $message }}</p> @enderror--}}
                            <input type="file" accept="image/*" name="video[]" onchange="loadFile(event)" multiple>
                            
                            <small class="text-danger">Video Size: 870px X 1160px(not more than 1 MB)</small>
                        </div>
                    </div>
           
          


                
                
            </div>
			
                    <div class="col-sm-3">
                        <div class="card shadow-sm" style="position: sticky;top: 60px;">
                            <div class="card-body text-end">
                                <input type="hidden" name="product_id" value="{{$data->id}}">
                                <button type="submit" class="btn btn-danger save-btn">Save changes</button>
                            </div>
                        </div>
                    </div>
			
        </div>
	</form>
	<div class="col-12">
	  <div class="card shadow-sm">
                    <div class="card-body text-end">
                        @foreach($images as $index => $singleImage)
                        <div class="gallery_item"> 
                        @if($singleImage->type=="video")
                            <video width="320" height="240" controls>
                                <source src="{{ asset($singleImage->image) }}" type="video/mp4"></video>
                        @elseif($singleImage->type=="image")
                        <img src="{{ asset($singleImage->image) }}" class="img-thumbnail mb-3"/>
                        @endif
                            <a href="{{ route('admin.product.image.delete', $singleImage->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure ?')">&times;</a>
                        </div>
                        @endforeach
                    </div>
                </div>
	</div>
    <div class="col-12">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3>Product specification</h3>
            <p class="small text-muted m-0"></p>
            <div class="col-sm-auto position: relative  float: right">
                <a href="#addSpecModal" data-bs-toggle="modal" class="btn btn-sm btn-success  float: right;">Add</a>
            </div>
        </div>
        <div class="card-body pt-0">
           
            <div class="admin__content">
                <content>
                    <div class="row">
                        <div class="col-sm-auto ">
                            <strong>#</strong>
                        </div>
                        <div class="col-sm-auto ">
                            <strong>Title</strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm-auto ">
                            <strong>Description</strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong>Icon</strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <strong>Action</strong>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <hr>
                    @forelse ($spec as $index => $item)
                    <div class="row">
                        <div class="col-sm-auto">
                            <label for="inputPassword6" class="col-form-label">{{ $index + 1 }}</label>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="color_box">
                                <p >{{ $item->name }}</p>
                            </div>
                        </div>
						
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    {!!$item->description!!}
                                </div>
                            </div>
                        </div>
						@if(!empty($item->icon))
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <img id="output" src="{{ asset($item->icon) }}" height="50" width="50"/>
                                </div>
                            </div>
                        </div>
						@endif
                        <div class="col-sm-auto">
                            {{-- <a href="javascript: void(0)" class="btn btn-sm btn-success" onclick="editColorModalOpen({{$item->id}})">Edit</a> --}}
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editColorModal_{{$item->id}}">
                                Edit
                              </button>
                            <a href="{{ route('admin.product.specification.delete',$item->id,['product_id' =>$data->id]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </div>

                    {{-- edit color modal --}}
                    <div class="modal fade" id="editColorModal_{{$item->id}}" tabindex="-1" aria-labelledby="editColorModal({{$item->id}})" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Specification</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.product.specification.edit',$item->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="product_id" value="{{$data->id}}">
                                        @php
                                            $spec = \App\Models\ProductSpecification::where('id',$item->id)->first();
                                            //dd($id);
                                        
                                        @endphp
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="text" name="specname" placeholder="Add Title" value="{{$item->name ?? ''}}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <textarea class="form-control" type="text" name="specdescription" placeholder="Add Description">{{$item->description ?? ''}}</textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="card-body">
                                                <div class="w-100 product__thumb">
                                                    <label for="icon"><img id="output" src="{{ asset($item->icon) }}"/></label>
                                                    @error('icon') <p class="small text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <input type="file" id="icon" accept="image/*" name="spec_icon" >
                                               
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </content>
            </div>
            

        </div>
    </div>



    <div class="card shadow-sm">
        <div class="card-header">
            <h3>Product Features</h3>
            <p class="small text-muted m-0"></p>
            <div class="col-sm-auto position: relative  float: right">
                <a href="#addFeatureModal" data-bs-toggle="modal" class="btn btn-sm btn-success  float: right;">Add</a>
            </div>
        </div>
        <div class="card-body pt-0">
           
            <div class="admin__content">
                <content>
                    <div class="row">
                        <div class="col-sm-auto ">
                            <strong>#</strong>
                        </div>
                        <div class="col-sm-auto ">
                            <strong>Title</strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm-auto ">
                            <strong>Icon</strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <strong>Action</strong>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <hr>
                    @forelse ($feature as $index => $item)
                    <div class="row">
                        <div class="col-sm-auto">
                            <label for="inputPassword6" class="col-form-label">{{ $index + 1 }}</label>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="color_box">
                                <p >{{ $item->name }}</p>
                            </div>
                        </div>
                        @if(!empty($item->icon))
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <img id="output" src="{{ asset($item->icon) }}" height="50" width="50"/>
                                </div>
                            </div>
                        </div>
						@endif
                        <div class="col-sm-auto">
                            {{-- <a href="javascript: void(0)" class="btn btn-sm btn-success" onclick="editColorModalOpen({{$item->id}})">Edit</a> --}}
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editFeatureModal_{{$item->id}}">
                                Edit
                              </button>
                            <a href="{{ route('admin.product.feature.delete',$item->id,['product_id' =>$data->id]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </div>

                    {{-- edit color modal --}}
                    <div class="modal fade" id="editFeatureModal_{{$item->id}}" tabindex="-1" aria-labelledby="editFeatureModal({{$item->id}})" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Features</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.product.feature.edit',$item->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="product_id" value="{{$data->id}}">
                                        @php
                                            $spec = \App\Models\ProductFeature::where('id',$item->id)->first();
                                            //dd($id);
                                        
                                        @endphp
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="text" name="featurename" placeholder="Add Title" value="{{$item->name ?? ''}}">
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <div class="card-body">
                                                <div class="w-100 product__thumb">
                                                    <label for="icon"><img id="output" src="{{ asset($item->icon) }}"/></label>
                                                    @error('icon') <p class="small text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <input type="file" id="icon" accept="image/*" name="feature_icon" >
                                               
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </content>
            </div>
            

        </div>
    </div>
</div>
   
	
	<div class="card shadow-sm">
        <div class="card-header">
            <h3>Product Review Video</h3>
            <p class="small text-muted m-0"></p>
            <div class="col-sm-auto position: relative  float: right">
                <a href="#addReviewVideoModal" data-bs-toggle="modal" class="btn btn-sm btn-success  float: right;">Add</a>
            </div>
        </div>
        <div class="card-body pt-0">
           
            <div class="admin__content">
                <content>
                    <div class="row">
                        <div class="col-sm-auto ">
                            <strong>#</strong>
                        </div>
                        <div class="col-sm-auto ">
                            <strong>Link</strong>
                        </div>
                        
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <strong>Action</strong>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <hr>
                    @forelse ($videolink as $index => $item)
                    <div class="row">
                        <div class="col-sm-auto">
                            <label for="inputPassword6" class="col-form-label">{{ $index + 1 }}</label>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="color_box">
                                <p >{{ $item->link }}</p>
                            </div>
                        </div>
                       
                        <div class="col-sm-auto">
                            
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editReviewVideoModal_{{$item->id}}">
                                Edit
                              </button>
                            <a href="{{ route('admin.product.videolink.delete',$item->id,['product_id' =>$data->id]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </div>

                    {{-- edit color modal --}}
                    <div class="modal fade" id="editReviewVideoModal_{{$item->id}}" tabindex="-1" aria-labelledby="editReviewVideoModal({{$item->id}})" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Review Video</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.product.videolink.edit',$item->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="product_id" value="{{$data->id}}">
                                        @php
                                            $spec = \App\Models\ProductFeature::where('id',$item->id)->first();
                                            //dd($id);
                                        
                                        @endphp
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="text" name="link" placeholder="Add Title" value="{{$item->link ?? ''}}">
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </content>
            </div>
            

        </div>
    </div>
	
	
	
	
	<div class="card shadow-sm">
        <div class="card-header">
            <h3>Product Feature Image</h3>
            <p class="small text-muted m-0"></p>
            <div class="col-sm-auto position: relative  float: right">
                <a href="#addFeatureImageModal" data-bs-toggle="modal" class="btn btn-sm btn-success  float: right;">Add</a>
            </div>
        </div>
        <div class="card-body pt-0">
           
            <div class="admin__content">
                <content>
                    <div class="row">
                        <div class="col-sm-auto ">
                            <strong>#</strong>
                        </div>
                        <div class="col-sm-auto ">
                            <strong>Image</strong>
                        </div>
                        
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm ">
                            <strong></strong>
                        </div>
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <strong>Action</strong>
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <hr>
                    @forelse ($featureimage as $index => $item)
                    <div class="row">
                        <div class="col-sm-auto">
                            <label for="inputPassword6" class="col-form-label">{{ $index + 1 }}</label>
                        </div>
                        
                        @if(!empty($item->image))
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-sm-11">
                                    <img id="output" src="{{ asset($item->image) }}" height="50" width="50"/>
                                </div>
                            </div>
                        </div>
						@endif
                       
                        <div class="col-sm-auto">
                            
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editFeatureImageModal_{{$item->id}}">
                                Edit
                              </button>
                            <a href="{{ route('admin.product.featureImage.delete',$item->id,['product_id' =>$data->id]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </div>

                    {{-- edit color modal --}}
                    <div class="modal fade" id="editFeatureImageModal_{{$item->id}}" tabindex="-1" aria-labelledby="editFeatureImageModal({{$item->id}})" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Feature Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.product.featureImage.edit',$item->id)}}" method="POST" enctype="multipart/form-data">@csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="product_id" value="{{$data->id}}">
                                        @php
                                            $spec = \App\Models\ProductFeature::where('id',$item->id)->first();
                                            //dd($id);
                                        
                                        @endphp
                                        <div class="form-group mb-3">
                                            <div class="card-body">
                                                <div class="w-100 product__thumb">
                                                    <label for="icon"><img id="output" src="{{ asset($item->image) }}"/></label>
                                                    @error('icon') <p class="small text-danger">{{ $message }}</p> @enderror
                                                </div>
                                                <input type="file" id="icon" accept="image/*" name="feature_image" >
                                               
                                                
                                            </div>
                                        </div>
                                        
                                       
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </content>
            </div>
            

        </div>
    </div>
</section>
<div class="modal fade" id="addSpecModal" tabindex="-1" aria-labelledby="addSpecModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.specification.add')}}" enctype="multipart/form-data" method="POST">@csrf
                    <input type="hidden" name="product_id" value="{{$data->id}}">
                    <div class="form-group mb-3">
                        <input class="form-control" type="text" name="specname" placeholder="Add Title">
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" type="text" name="specdescription" placeholder="Add Description"></textarea>
                    </div>
                    <div class="col-md-6 card">
                        <div class="card-header p-0 mb-3">Icon </div>
                        <div class="card-body p-0">
                           
                            <input type="file" name="spec_icon" id="icon" accept="image/*">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">+ Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addFeatureModal" tabindex="-1" aria-labelledby="addFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">Add Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.feature.add')}}" enctype="multipart/form-data" method="post">@csrf
                    <input type="hidden" name="product_id" value="{{$data->id}}">
                    <div class="form-group mb-3">
                        <input class="form-control" type="text" name="featurename" placeholder="Add Title">
                    </div>
                    
                    <div class="col-md-6 card">
                        <div class="card-header p-0 mb-3">Icon</div>
                        <div class="card-body p-0">
                           
                            <input type="file" name="feature_icon" id="icon" accept="image/*">
                        
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">+ Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="addReviewVideoModal" tabindex="-1" aria-labelledby="addaddReviewVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">Add product wise review video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.videolink.add')}}" enctype="multipart/form-data" method="post">@csrf
                    <input type="hidden" name="product_id" value="{{$data->id}}">
                    <div class="form-group mb-3">
                        <input class="form-control" type="text" name="link" placeholder="Add Title">
                    </div>
                    
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">+ Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="addFeatureImageModal" tabindex="-1" aria-labelledby="addFeatureImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">Add Feature Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.product.featureImage.add')}}" enctype="multipart/form-data" method="post">@csrf
                    <input type="hidden" name="product_id" value="{{$data->id}}">
                    
                    
                    <div class="col-md-6 card">
                        <div class="card-header p-0 mb-3">Image</div>
                        <div class="card-body p-0">
                           
                            <input type="file" name="feature_image" id="feature_image" accept="image/*">
                        
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">+ Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    
  
<script >
jQuery(document).ready(function () {
  ImgUpload();
});

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}
</script>
    <script>
    

        ClassicEditor
        .create( document.querySelector( '#product_des' ) )
        .catch( error => {
            console.error( error );
        });
        ClassicEditor
        .create( document.querySelector( '#product_short_des' ) )
        .catch( error => {
            console.error( error );
        });
        ClassicEditor.create( document.querySelector( '#short_content' ) ).catch( error => {
        console.error( error );
        });

        ClassicEditor.create( document.querySelector( '#long_content' ) ).catch( error => {
            console.error( error );
        });
        
        
    </script>
@endsection
