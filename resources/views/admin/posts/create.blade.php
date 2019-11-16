@extends('layouts.admin')

@section('content')
<form action="{{route('posts.store')}}" id="post_form_id" class="row" method="POST" enctype="multipart/form-data">

    <div class="col-md-9">
        <div class="card card-default form-group">
            <div class="card-header h3">Create Post</div>
            <div class="card-body">

                @csrf
                <div class="form-group">
                    <label for="post_title">Title</label>
                    <input type="text" id="post_title" value="{{old('post_title')}}" class="form-control" placeholder="Name field must be unique" name="post_title">

                    @if($errors->has('post_title'))
                    <span class="error">{{ $errors->first('post_title') }}</span>
                    @endif

                </div>

                <div class="form-group">
                    <label for="category_slug">Slug</label>
                    <input type="text" id="post_slug" value="{{old('post_slug')}}" class="form-control" name="post_slug">
                    @if($errors->has('post_slug'))
                    <span class="error">{{ $errors->first('post_slug') }}</span>
                    @endif

                </div>



                <div class="form-group">
                    <label for="post_desc">Description</label>
                    <!-- <input id="post_desc" type="hidden" name="post_desc">
                        <trix-editor input="post_desc"></trix-editor> -->
                    <textarea class="gk_tinymce" class="validate[required]" rows="30" name="post_desc">{{old('post_desc')}}</textarea>
                    @if($errors->has('post_desc'))
                    <span class="error">{{ $errors->first('post_desc') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-default form-group">
            <div class="card-header h3">SEO Settings</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="post_seo_title">Title Tag</label>
                    <!-- <input type="text" id="post_seo_title" value="{{old('post_seo_title')}}" class="form-control" placeholder="Name field must be unique" name="post_seo_title"> -->
                    <select id="tag_listing_data" name="post_seo_title[]" multiple="multiple"></select>
                    <div class="help-block">Most search engine use upto 70</div>
                    @if($errors->has('post_seo_title'))
                    <span class="error">{{ $errors->first('post_seo_title') }}</span>
                    @endif

                </div>

                <div class="form-group">
                    <label for="meta_desc">Meta Description</label>
                    <textarea id="meta_desc" class="form-control" name="seo_desc">{{old('seo_desc')}}</textarea>
                    <div class="help-block">Most search engine use upto 140</div>
                    @if($errors->has('seo_desc'))
                    <span class="error">{{ $errors->first('seo_desc') }}</span>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-default form-group ">
            <div class="card-header h3">Publish</div>
            <div class="card-body">
                <div class="form-group row gk-space-between">
                    <button type="submit" class="btn btn-success float-left">Save Draft</button>
                    <a href="javascript:void(0)" class="btn btn-secondary float-right">Preview</a>
                </div>
                <div class="form-group row gk-align-center">
                    <label for="visibility" class="col-md-4 pl-1 pr-1">Visibility</label>
                    <select name="visibility" value="" id="visibility" class="form-control col-md-7">
                        <option value="1">All</option>
                        <option value="1">Android</option>
                        <option value="1">IOS</option>
                        <option value="1">Web</option>
                    </select>
                </div>
                <div class="form-group row gk-align-center">
                    <label for="publish_at" class="col-md-4 pl-1 pr-1">Publish</label>
                    <input type="text" id="published_at" value="{{old('published_at')}}" class="form-control col-md-7" name="published_at">
                    @if($errors->has('published_at'))
                    <span class="error">{{ $errors->first('published_at') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card card-default form-group ">
            <div class="card-header h3">Tag</div>
            <div class="card-body">
                {{-- <label for="tag_name">Name</label> --}}
                {{-- <div class="form-group">
                        <input type="text" id="tag_name" value="" class="form-control" placeholder="" name="tag_name">
                        <img id="loader_element_id" width="100" height="100" style="display:none;position: absolute;margin: -67px 203px -7px;" src="{{asset('images/Spinner-1s-200px.gif')}}">
            </div> --}}


            <div class="input-group mb-3">
                <input type="text" class="form-control" name="tag_name" id="tag_name">
                <img id="loader_element_id" width="100" height="100" style="display:none;position: absolute;margin: -67px 203px -7px;" src="{{asset('images/Spinner-1s-200px.gif')}}">
                <div class="input-group-append">
                    <a class="btn btn-primary" id="add_tag" href="javascript:void(0)">Add</a>
                </div>
            </div>
            <input type="hidden" name="selected_tag" id="selected_tag"/>
            <input type="hidden" name="selected_tag" id="selected_tag_name"/>
        </div>
    </div>

    <div class="card card-default form-group">
        <div class="card-header h3">Categories</div>
        <div class="card-body">
            <div class="form-group">
                @if($category)
                    @foreach($category as $val)

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="{{$val->id}}" name="category[]" id="category_{{$val->id}}">
                            <span class="cr">
                                <i class="cr-icon material-icons rtl-no-flip checkbox"></i></span>
                            </span>
                            <span class="gk_name">
                                {{ $val->category_name }}
                            </span>
                        </label>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="card card-default form-group">
        <div class="card-header h3">Featured Image</div>
        <div class="card-body">
            <div class="form-group">
                {{-- <label for="featured_image">Feature Image</label> --}}
                <div>
                            <a href="javscript:void(0)"  class="btn btn-primary" data-toggle="modal" data-target="#cropperModal">Upload</a>
                                @include('modal.imagecropper', ['name' => 'featured_image'])
                        </div>
                @if($errors->has('featured_image'))
                <span class="error">{{ $errors->first('featured_image') }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="card card-default form-group">
        <div class="card-header h3">Monthly Categories</div>
        <div class="card-body">
            <div class="form-group">
                {{-- <label for="tag_name">Name</label> --}}
                @if($month)
                @foreach($month as $val)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="{{$val->id}}" name="month[]" id="monthly_{{$val->id}}">
                        <span class="cr">
                            <i class="cr-icon material-icons rtl-no-flip checkbox-checked"></i></span>
                        </span>
                        <span class="gk_name">
                            {{ $val->month_name }}
                        </span>
                    </label>
                </div>

                @endforeach

                @endif

            </div>
        </div>
    </div>
    {{-- <div class="card card-defaut">
                
            </div>
            <div class="card card-defaut">
            </div>
            <div class="card card-defaut">
            </div>
            <div class="card card-defaut">
            </div> --}}
    </div>
</form>
<!-- public/js/tiny_mce/plugins/responsivefilemanager -->
<input type="hidden" value="{{asset('js/tiny_mce/plugins/responsivefilemanager')}}" id="filemanagerlink" />
<input type="hidden" value="{{route('post.search.tags')}}" id="tag_search_request_route">
<input type="hidden" value="{{route('post.admin.search.search')}}" id="serrach_tag_seo">

@section('pagescript')

<script src="{{asset('js/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/jquery-validation/dist/additional-methods.min.js')}}"></script>
<script src="{{asset('js/category.js')}}"></script>
<script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{asset('js/jquery.autocomplete.js')}}"></script>
<script src="{{asset('js/tokenized/tokenize2.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.slugify.js')}}"></script>
<script type="text/javascript" src="{{asset('node_modules/darkroom/vendor/fabric.js')}}"></script>
<script type="text/javascript" src="{{asset('node_modules/darkroom/build/darkroom.js')}}"></script>
<script src="{{asset('js/posts/createpost.js')}}"></script>
<script src="{{asset('js/imageCropper.js')}}"></script>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('node_modules/darkroom/build/darkroom.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{ asset('css/custom_checkbox.css')}}">
<link rel="stylesheet" href="{{ asset('css/theme.css')}}">
<link rel="stylesheet" href="{{asset('js/tokenized/tokenize2.css')}}">
 @endsection 
 @endsection