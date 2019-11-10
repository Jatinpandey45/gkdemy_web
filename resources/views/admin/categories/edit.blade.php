@extends('layouts.admin')

@section('content')
    <div class="card card-default">
        <div class="card-header h3">Edit Categories</div>
        <div class="card-body">
        
            <form action="{{route('categories.update',$decrypt)}}" id="category_form_id" method="POST" enctype="multipart/form-data">
               
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="category_name">Name</label>
                    <input type="text" id="category_name" value="{{old('category_name',$categoryData->category_name)}}" class="form-control" placeholder="Name field must be unique" name="category_name">

                    @if($errors->has('category_name'))
                        <span class="error">{{ $errors->first('category_name') }}</span>
                    @endif

                </div>

                


                <div class="form-group">
                    <label for="category_slug">Slug</label>
                    <input type="text" id="category_slug" value="{{old('category_slug',$categoryData->category_slug)}}" class="form-control" name="category_slug">
                    @if($errors->has('category_slug'))
                        <span class="error">{{ $errors->first('category_slug') }}</span>
                    @endif

                </div>

            

                <div class="form-group">
                    <label for="category_description">Description</label>
                    <textarea name="category_description" class="form-control"> 
                        {{old('category_description',$categoryData->category_description)}}
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="status">
                        Status
                        <input data-toggle="switch" class="" id="status" data-inverse="true" type="checkbox" name="status" checked>
                    </label>
                </div>
                <div class="form-group">
                     <img src="data:image/png;base64, {{$categoryData->category_icon}}" width="100" height="100">
                </div>
                <div class="form-group">
                   
                    <label for="icon">
                        Upload New Logo
                    </label>
                    <input type="file" class="form-control" name="category_icon">
                    @if($errors->has('category_icon'))
                        <span class="error">{{ $errors->first('category_icon') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Add Category</button>
                </div>
            </form>
        </div>
    </div>
    
@section('pagescript')
<script src="{{asset('js/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/jquery-validation/dist/additional-methods.min.js')}}"></script>

@endsection




@endsection