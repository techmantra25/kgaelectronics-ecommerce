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
    <form method="POST" action="{{ route('admin.product.update') }}" enctype="multipart/form-data" name="images-upload-form">
        @csrf
		@if($errors->any())
									{{--<div class="alert alert-danger" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>--}}

										@foreach($errors->all() as $error)
											{{--{{ $error }}<br/>--}}
								            {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js">                                                 </script>--}}
								<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
												<script type="text/javascript">
												swal({
  title: "Error!",
  text: "{{ $error }}",
  type: "error",
													 icon: "error",
  
})
												//timer: 1500
													
													
												</script>
										@endforeach
									</div>
								@endif
        <div class="row">
            <div class="col-sm-9">

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

                            {{-- <div class="col-sm-4">
                                <select class="form-control" name="sub_cat_id">
                                    <option hidden selected>Select sub-category...</option>
                                    @foreach ($sub_categories as $index => $item)
                                        <option value="{{$item->id}}" {{ ($data->sub_cat_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div> --}}
                        </div>

                        <div class="form-group mb-3">
                            <label class="label-control">Product Title <span class="text-danger">*</span></label>
                            <input type="text" name="name" placeholder="Add Product Title" class="form-control" value="{{$data->name}}">
                            @error('name') <p class="small text-danger">{{ $message }}</p> @enderror
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
                    </div>
                </div>
				       <div class="card shadow-sm">
						<div class="card-header">
							Primary Image
						</div>
                    <div class="card-body">
                        <div class="w-100 product__thumb">
                            <label for="thumbnail"><img id="output" src="{{ asset($data->image) }}"/></label>
                            @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
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
                    {{--<div class="card-header">
                        Upload more images
                    </div>--}}
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

            <div class="card shadow-sm" style="position: sticky;top: 60px;">
                <div class="card-body text-end">
                    <input type="hidden" name="product_id" value="{{$data->id}}">
                    <button type="submit" class="btn btn-danger save-btn">Save changes</button>
                </div>
            </div>
            </div>
			
            <div class="col-sm-3">
         

                
						{{-- <div class="w-100 product__thumb">
                            <label for="thumbnail"><img id="data" src="{{ asset($data->image) }}"/></label>
                            @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <input type="file"  id="images" accept="image/*" name="images[]" multiple>
						
                        <small class="text-danger">Image Size: 870px X 1160px</small><br>
                          <script>
                            var loadFile = function(event) {
                                var output = document.getElementById('data');
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                URL.revokeObjectURL(output.src) // free memory
                                }
                            };
                        </script>--}}
					
				
				

                

                <div class="card shadow-sm">
                    <div class="card-body text-end">
                        @foreach($images as $index => $singleImage)
						 @if($singleImage->type=="video")
                            <video width="320" height="240" controls>
								<source src="{{ asset($singleImage->image) }}" type="video/mp4"></video>
						@elseif($singleImage->type=="image")
						<img src="{{ asset($singleImage->image) }}" class="img-thumbnail mb-3"/>
						@endif
                            <a href="{{ route('admin.product.image.delete', $singleImage->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure ?')">&times;</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>




</section>

{{-- add new color modal --}}
<div class="modal fade" tabindex="-1" id="addColorModal">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add new color</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('admin.product.variation.color.add')}}" method="post">@csrf
                <input type="hidden" name="product_id" value="{{$id}}">
                {{-- <input type="hidden" name="color" value="{{$productColorGroupVal->color}}"> --}}
                <div class="form-group mb-3">
                <select class="form-control" name="color" id="">
                    <option value="" selected>Select color...</option>
                    @php
                        $color = \App\Models\Color::orderBy('name', 'asc')->get();
                        foreach ($color as $key => $value) {
                            echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                        }
                    @endphp
                </select>
                </div>
                <div class="form-group mb-3">
                <select class="form-control" name="size" id="">
                    <option value="" selected>Select size...</option>
                    @php
                        $sizes = \App\Models\Size::get();
                        foreach ($sizes as $key => $value) {
                            echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                        }
                    @endphp
                </select>
                </div>
              
                <div class="form-group mb-3">
                    <input class="form-control" type="text" name="price" id="" placeholder="Price">
                </div>
                <div class="form-group mb-3">
                    <input class="form-control" type="text" name="sku_code" id="" placeholder="SKU code">
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
        function renameColorModalOpen(colorId, colorName) {
            $('#colorName2').text(colorName);
            $('input[name="update_color_name"]').val(colorName);
            $('input[name="current_color2"]').val(colorId);
            $('#renameColorModal').modal('show');
        }

		function editColorModalOpen(colorId, colorName) {
            $('#colorName').text(colorName);
            $('input[name="current_color"]').val(colorId);
            $('#editColorModal').modal('show');
        }

		function editSizeFunc(size, id, name, price, code) {
            $('#sizeNameDetail').text(size);
            $('#colorName3').text(name);
            $('input[name="id"]').val(id);
            $('input[name="size_details"]').val(name);
            $('input[name="price"]').val(price);
            $('input[name="code"]').val(code);
            $('#sizeDetailModal').modal('show');
        }

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

        $(document).on('click','.removeTimePrice',function(){
            var thisClickedBtn = $(this);
            thisClickedBtn.closest('tr').remove();
        });

        function sizeCheck(productId, colorId) {
            $.ajax({
                url : '{{route("admin.product.size")}}',
                method : 'POST',
                data : {'_token' : '{{csrf_token()}}', productId : productId, colorId : colorId},
                success : function(result) {
                    if (result.error === false) {
                        let content = '<div class="btn-group" role="group" aria-label="Basic radio toggle button group">';

                        $.each(result.data, (key, val) => {
                            content += `<input type="radio" class="btn-check" name="productSize" id="productSize${val.sizeId}" autocomplete="off"><label class="btn btn-outline-primary px-4" for="productSize${val.sizeId}">${val.sizeName}</label>`;
                        })

                        content += '</div>';

                        $('#sizeContainer').html(content);
                    }
                },
                error: function(xhr, status, error) {
                    // toastFire('danger', 'Something Went wrong');
                }
            });
        }

        function deleteImage(imgId, id1, id2) {
            $.ajax({
                url : '{{route("admin.product.variation.image.delete")}}',
                method : 'POST',
                data : {'_token' : '{{csrf_token()}}', id : imgId},
                beforeSend : function() {
                    $('#img__holder_'+id1+'_'+id2+' a').text('Deleting...');
                },
                success : function(result) {
                    $('#img__holder_'+id1+'_'+id2).hide();
                    toastFire('success', result.message);
                },
                error: function(xhr, status, error) {
                    // toastFire('danger', 'Something Went wrong');
                }
            });
        }

        $(".row_position").sortable({
            delay: 150,
            stop: function() {
                var selectedData = new Array();
                $('.row_position > .single-color-holder').each(function() {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });

        function updateOrder(data) {
            // $('.loading-data').show();
            $.ajax({
                url : "{{route('admin.product.variation.color.position')}}",
                type : 'POST',
                data: {
                    _token : '{{csrf_token()}}',
                    position : data
                },
                success:function(data) {
                    // toastFire('success', 'Color position updated successfully');
                    // $('.loading-data').hide();
                    if (result.status == 200) {
                        toastFire('success', result.message);
                    } else {
                        toastFire('error', result.message);
                    }
                }
            });
        }

        // product color status change
        function colorStatusToggle(id, productId, colorId) {
            $.ajax({
                url : '{{route("admin.product.variation.color.status.toggle")}}',
                method : 'POST',
                data : {
                    _token : '{{csrf_token()}}',
                    productId : productId,
                    colorId : colorId,
                },
                success : function(result) {
                    if (result.status == 200) {
                        // toastFire('success', result.message);

                        if (result.type == 'active') {
                            $('#'+id+' .color_box').css('background', '#fff');
                        } else {
                            $('#'+id+' .color_box').css('background', '#c1080a59');
                        }
                    } else {
                        toastFire('error', result.message);
                    }
                }
            });
        }

        function addSizeModal(colorId, colorName) {
            $('#addColorModal .modal-title').text('Add new size');
            $('#addColorModal select[name="color"]').html('<option value="'+colorId+'">'+colorName+'</option>');
            $('#addColorModal').modal('show');
        }

        function addColorModal() {
            var contentData = `
            @php
                $color = \App\Models\Color::orderBy('name', 'asc')->get();
                foreach ($color as $key => $value) {
                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                }
            @endphp
            `;
            $('#addColorModal .modal-title').text('Add new color');
            $('#addColorModal select[name="color"]').html('<option value="" selected>Select color...</option>'+ contentData);
            $('#addColorModal').modal('show');
        }

        // image fabric upload
        $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 150,
                height: 150,
                type: 'circle'
            },
            boundary: {
                width: 200,
                height: 200
            }
        });

        // $('#upload_image').on('change', function () {
        $('input[name=upload_image]').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        });

        function fabricUploadFunc(color_id) {
            $('input[name=color_fabric_color_id]').val(color_id)
        }

        $('.crop_image').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                $.ajax({
                    url: "{{ route('admin.product.variation.color.fabric.upload') }}",
                    type: "POST",
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "image": response,
                        "product_id": '{{$id}}',
                        "color_id": $('input[name=color_fabric_color_id]').val(),
                    },
                    beforeSend: function() {
                        $('.crop_image').html('Please wait').attr('disabled', true);
                    },
                    success: function (result) {
                        $('#uploadimageModal').modal('hide');
                        $('.crop_image').html('Crop & Upload Image').attr('disabled', false);
                        if(result.error == true){
                            toastFire('warning', result.message);
                        } else {
                            const img = `<img src="${result.image}" alt="">`;

                            $('#image_demo').html('');
                            $('#fabric_id_'+result.color_id).attr('src', result.image);
                            $('#color_box_down_'+result.color_id+' div').html(img);
                            $('#color_box_up_'+result.color_id+' div').html(img);
                            toastFire('success', result.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastFire('warning', error);
                    }
                });
            })
        });

        // bulk action
        $('select[name="bulkAction"]').on('change', function() {
            $('#bulkActionForm').submit();
        });

        // bulk select all checkbox
        // $('.bulkSelectAll').on();
    </script>
@endsection
