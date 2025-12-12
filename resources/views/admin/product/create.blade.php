@extends('admin.layouts.app')
@section('page', 'Create Product')
@section('content')
<style>
	.save-btn {
		width: 200px;
	}
    .label-control {
        color: #525252;
        font-size: 12px;
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
    <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">@csrf
		@if ($errors->any())
										<div class="alert alert-danger">
											<ul>
												@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									@endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label class="label-control">Category <span class="text-danger">*</span></label>
                                <select class="form-control" name="cat_id">
                                    <option hidden selected>Select...</option>
                                    @foreach ($categories as $index => $item)
                                        <option value="{{$item->id}}" {{ (old('cat_id') == $item->id) ? 'selected' : ''}}>{{ $item->name }} </option>
                                    @endforeach
                                </select>
                                @error('cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                           {{-- <div class="col-sm-6">
                                <label class="label-control">Sub-Category </label>
                                <select class="form-control" name="sub_cat_id">
                                    <option hidden selected>Select...</option>
                                    @foreach ($sub_categories as $index => $item)
                                        <option value="{{$item->id}}" {{ (old('cat_id') == $item->id) ? 'selected' : ''}}>{{ $item->name }} </option>
                                    @endforeach
                                </select>
                                @error('sub_cat_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>--}}
                        </div>
            
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <label class="label-control">Product Title <span class="text-danger">*</span></label>
                                <div class="form-group mb-3">
                                    <input type="text" name="product_name" placeholder="Add Product Title" class="form-control" value="{{old('name')}}">
                                    @error('product_name') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
						<div class="row align-items-center">
                            <div class="col-sm-12">
                                <label class="label-control">Product Sub Heading </label>
                                <div class="form-group mb-3">
                                    <input type="text" name="sub_heading" placeholder="Add Product sub heading" class="form-control" value="{{old('sub_heading')}}">
                                    @error('sub_heading') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="label-control">Short Description </label>
                        <textarea id="product_short_des" name="short_desc">{{old('short_desc')}}</textarea>
                        @error('short_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="label-control">Description </label>
                        <textarea id="product_des" name="desc">{{old('desc')}}</textarea>
                        @error('desc') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="label-control">Short Content </label>
                        <textarea id="short_content" name="short_content">{{old('short_content')}}</textarea>
                        @error('short_content') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="label-control">Long Content </label>
                        <textarea id="long_content" name="long_content">{{old('long_content')}}</textarea>
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
                                    <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="price" value="{{old('price')}}">
                                    @error('price') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-3">
                                    <label for="inputprice6" class="col-form-label">Offer Price</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="offer_price" value="{{old('offer_price')}}">
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
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="meta_title" value="{{old('meta_title')}}">
                                        @error('meta_title') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    {{-- <div class="col-auto">
                                        <span id="priceHelpInline" class="form-text">
                                        Must be 8-20 characters long.
                                        </span>
                                    </div> --}}
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-3">
                                        <label for="inputprice6" class="col-form-label">Description</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="meta_desc" value="{{old('meta_desc')}}">
                                        @error('meta_desc') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    {{-- <div class="col-auto">
                                        <span id="passwordHelpInline" class="form-text">
                                        Must be 8-20 characters long.
                                        </span>
                                    </div> --}}
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-3">
                                        <label for="inputprice6" class="col-form-label">Keyword</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="meta_keyword" value="{{old('meta_keyword')}}">
                                        @error('meta_keyword') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                                    {{-- <div class="col-auto">
                                        <span id="passwordHelpInline" class="form-text">
                                        Must be 8-20 characters long.
                                        </span>
                                    </div> --}}
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
                                    <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="style_no" value="{{old('style_no')}}">
                                    @error('style_no') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                                {{-- <div class="col-auto">
                                    <span id="priceHelpInline" class="form-text">
                                    Must be 8-20 characters long.
                                    </span>
                                </div> --}}
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
                                        <input type="text" id="inputprice6" class="form-control" aria-describedby="priceHelpInline" name="pack" value="{{ old('pack') ? old('pack') : '1 PC' }}">
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
                                                    <option value="{{$colorValue->id}}" {{ (old('color_id') == $colorValue->id) ? 'selected' : '' }}><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="{{$colorValue->code}} " stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>
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

               
            </div>
            <div class="card shadow-sm">
                    <div class="card-header">
                        Primary Image <span class="text-danger">*</span>
                    </div>
                    <div class="card-body">
                        <div class="w-100 product__thumb">
                        <label for="image"><img id="primaryimage" src="{{ asset('admin/images/placeholder-image.jpg') }}"/></label>
                        @error('image') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <input type="file" id="image" accept="image/*" name="image" onchange="loadPrimaryImage(event)" class="d-none">
                        <small>Image Size: 870px X 1160px</small>
                        <script>
                        var loadPrimaryImage = function(event) {
                            var output = document.getElementById('primaryimage');
							//alert(output1);
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
                        <label for="banner_image"><img id="bannerimage" src="{{ asset('admin/images/placeholder-image.jpg') }}"/></label>
                        @error('banner_image') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <input type="file" id="banner_image" accept="image/*" name="banner_image" onchange="loadBannerImage(event)" class="d-none">
                        <small>Image Size: 870px X 1160px</small>
                        <script>
                        var loadBannerImage = function(event) {
                            var output1 = document.getElementById('bannerimage');
							//alert(output1);
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
                        <label for="thumbnail_image"><img id="thumbnailimage" src="{{ asset('admin/images/placeholder-image.jpg') }}"/></label>
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
                        <input type="file" accept="image/*" name="product_images[]" onchange="loadFile(event)" multiple>
						<input type="hidden" name="type" value="video">
                        <small class="text-danger">Video Size: 870px X 1160px(not more than 1 MB)</small>
					</div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Product Specification</h3>
                        <p class="small text-muted m-0">Add Specification from here</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm" id="timeSpecTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Icon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-control" type="text" name="specname[]">
                                            </td>
                                            <td>
                                                <textarea class="form-control" type="text" name="specdescription[]"></textarea>
                                            </td>
                                            <td>
                                                <input type="file" accept="image/*" name="specicon[]"  multiple>
                                                   
                                            </td>
                                            <td><a class="btn btn-success actionTimebtn addNewSpec">+</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>
                    </div>
                </div>
			<div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Product Feature</h3>
                        <p class="small text-muted m-0">Add Feature from here</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm" id="timePriceTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Icon</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-control" type="text" name="featurename[]">
                                            </td>
                                            <td>
                                                <input type="file" accept="image/*" name="icon[]"  multiple>
                                                   
                                            </td>
                                            <td><a class="btn btn-success actionTimebtn addNewTime">+</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>
                    </div>
                </div>
			<div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Product Wise Video Link</h3>
                        
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm" id="VideoPriceTable">
                                    <thead>
                                        <tr>
                                            <th>Link</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-control" type="text" name="product_video_link[]">
                                            </td>
                                            
                                            <td><a class="btn btn-success actionTimebtn addNewVideo">+</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>
                    </div>
                </div>
			
			<div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Product Wise Feature Image</h3>
                        
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm" id="FeatureImagePriceTable">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-control" type="file" name="product_feature_image[]">
                                            </td>
                                            
                                            <td><a class="btn btn-success actionTimebtn addNewFeatureImage">+</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>
                    </div>
                </div>
			
			
				
                <div class="card shadow-sm" style="position: sticky;top: 60px;">
                    <div class="card-body text-end">
                        <button type="submit" class="btn btn-danger save-btn">Save changes</button>
                    </div>
                </div>
            
        </div>
    </form>
</section>
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
    ClassicEditor.create( document.querySelector( '#product_des' ) ).catch( error => {
        console.error( error );
    });

    ClassicEditor.create( document.querySelector( '#product_short_des' ) ).catch( error => {
        console.error( error );
    });

    ClassicEditor.create( document.querySelector( '#short_content' ) ).catch( error => {
        console.error( error );
    });

    ClassicEditor.create( document.querySelector( '#long_content' ) ).catch( error => {
        console.error( error );
    });

    $(document).on('click','.addNewTime',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.removeClass(['addNewTime','btn-success']);
		thisClickedBtn.addClass(['removeTimePrice','btn-danger']).text('X');

		var toAppend = `
        <tr>
            <td>
                <input class="form-control" type="text" name="featurename[]">
            </td>
            <td>
                <input type="file" accept="image/*" name="icon[]"  multiple>
            </td>
            <td><a class="btn btn-success actionTimebtn addNewTime">+</a></td>
        </tr>
        `;

		$('#timePriceTable').append(toAppend);
	});

	$(document).on('click','.removeTimePrice',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.closest('tr').remove();
	});


    $(document).on('click','.addNewSpec',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.removeClass(['addNewSpec','btn-success']);
		thisClickedBtn.addClass(['removeTimeSpec','btn-danger']).text('X');

		var toAppend = `
        <tr>
            <td>
                <input class="form-control" type="text" name="specname[]">
            </td>
            <td>
                <textarea class="form-control" type="text" name="specdescription[]"></textarea>
            </td>
            <td>
                <input type="file" accept="image/*" name="specicon[]"  multiple>
            </td>
            <td><a class="btn btn-success actionTimebtn addNewSpec">+</a></td>
        </tr>
        `;

		$('#timeSpecTable').append(toAppend);
	});

	$(document).on('click','.removeTimeSpec',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.closest('tr').remove();
	});
	
	    $(document).on('click','.addNewVideo',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.removeClass(['addNewVideo','btn-success']);
		thisClickedBtn.addClass(['removeTimeVideo','btn-danger']).text('X');

		var toAppend = `
        <tr>
            <td>
                <input class="form-control" type="text" name="product_video_link[]">
            </td>
            
            <td><a class="btn btn-success actionTimebtn addNewVideo">+</a></td>
        </tr>
        `;

		$('#VideoPriceTable').append(toAppend);
	});
	$(document).on('click','.removeTimeVideo',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.closest('tr').remove();
	});
	
	
	
	
	 $(document).on('click','.addNewFeatureImage',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.removeClass(['addNewFeatureImage','btn-success']);
		thisClickedBtn.addClass(['removeTimeFeatureImage','btn-danger']).text('X');

		var toAppend = `
        <tr>
            <td>
                <input class="form-control" type="file" name="product_feature_image[]">
            </td>
            
            <td><a class="btn btn-success actionTimebtn addNewFeatureImage">+</a></td>
        </tr>
        `;

		$('#FeatureImagePriceTable').append(toAppend);
	});
	$(document).on('click','.removeTimeFeatureImage',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.closest('tr').remove();
	});
	
	
	$(document).on('click','.addNewReview',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.removeClass(['addNewReview','btn-success']);
		thisClickedBtn.addClass(['removeTimeReview','btn-danger']).text('X');

		var toAppend = `
        <tr>
            <td>
                <input class="form-control" type="text" name="review_title[]">
            </td>
			<td>
                <textarea class="form-control" type="text" name="review_content[]"></textarea>
            </td>
			<td>
                <input class="form-control" type="text" name="review_created_by[]">
            </td>
            
            <td><a class="btn btn-success actionTimebtn addNewReview">+</a></td>
        </tr>
        `;

		$('#ReviewPriceTable').append(toAppend);
	});
	$(document).on('click','.removeTimeReview',function(){
		var thisClickedBtn = $(this);
		thisClickedBtn.closest('tr').remove();
	});
</script>
@endsection
