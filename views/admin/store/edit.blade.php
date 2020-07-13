@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Edit Store</h3>
                    <a href="{{ url('/admin/stores') }}" class="btn btn-warning pull-right">Cancel</a>
                </div>
                <!-- /.box-header -->

                <form class="form-horizontal" role="form" method="POST" id="admin_login" action="{{ url('/admin/store/edit').'/'.$store->id }}" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            {{ csrf_field() }}
                            <!-- text input -->
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-sm-2 control-label">Name<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $store->name != '' ? $store->name : old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="link" class="col-sm-2 control-label">Description<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                         <textarea id="editor1" name="description" rows="10" cols="80">
                                              {{ $store->description != '' ? $store->description : old('description') }}
                                        </textarea>
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="feature_image" class="col-sm-2 control-label">Image<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        @if (file_exists(public_path($store->image)) && $store->image!='')
                                            <img src="{{URL::asset($store->image)}}" width="200"><br/>
                                        @endif
                                        <input type="file" id="image" name="image" accept="image/*" value="{{ URL::asset($store->image) }}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('gallery') ? ' has-error' : '' }}">
                                    <label for="gallery" class="col-sm-2 control-label">Gallery</label>
                                    <div class="col-sm-10">
                                        @if(!empty($storeGallery))
                                            @foreach ($storeGallery as $p)
                                                <div class="img-wrap">
                                                    <span class="delete_image">&times;</span>
                                                    <img src="{{URL::asset($p->gallery_images)}}"  width="150" data-id="{{ $p->id }}">
                                                </div>
                                            @endforeach
                                        @endif
                                        <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
                                        <small class="text-danger">Upload image of dimension 700 X 200 at least</small>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">
                                    <label for="video" class="col-sm-2 control-label">Video</label>
                                    <div class="col-sm-10">
                                        <small>Insert Url like : https://www.youtube.com/embed/tgbNymZ7vqY</small>
                                        <input type="text" id="video" name="video" class="form-control" value="{{ $store->video!=''? $store->video : old('video') }}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                                    <label for="url" class="col-sm-2 control-label">Store URL<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="url" class="form-control" id="url" name="url" value="{{ $store->url != '' ? $store->url : old('url') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="featured_store">Featured Store</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="featured_store" class="flat-red" value="1" {{ (old('featured_store') == 1 || $store->featured_store == 1) ? 'checked="checked"' : '' }}>{{ "&nbsp; Enable as a featured store " }}
                                    </div>
                                </div>

                                <hr />
                                <div class="row">

                                    <!-- /.col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="page_title" class="col-sm-2 control-label">Meta Title</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Meta Title.">{{ $store->page_title != '' ? $store->page_title : old('page_title') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="page_keyword" class="col-sm-2 control-label">Meta Keyword</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" id="page_keyword" name="page_keyword" placeholder="Meta Keyword.">{{ $store->page_keyword != '' ? $store->page_keyword : old('page_keyword') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="page_description" class="col-sm-2 control-label">Meta Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" id="page_description" name="page_description" placeholder="Meta Description.">{{ $store->page_description != '' ? $store->page_description : old('page_description') }}</textarea>
                                            </div>
                                        </div>


                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-info pull-right">Update</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                <!-- /.box-body -->
                </form>

            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->

        <!--/.col (right) -->
    </div>
    <!-- /.row -->
@endsection

@section('styles')
    <!-- CK Editor -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}">
    <style>
        span.text-block{width: 5% !important;display: inline-block;}
        .img-wrap {
            position: relative;
            display: inline-block;
            border: 1px red solid;
            font-size: 0;
        }
        .img-wrap .close {
            position: absolute;
            top: 2px;
            right: 2px;
            z-index: 100;
            background-color: #FFF;
            padding: 5px 2px 2px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            opacity: .2;
            text-align: center;
            font-size: 22px;
            line-height: 10px;
            border-radius: 50%;
        }
        .img-wrap:hover .close {
            opacity: 1;
        }
    </style>
@stop

@section('scripts')
    <!-- CK Editor -->
    <script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1',{
                extraPlugins: 'uploadimage',

                filebrowserBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html') }}",
                filebrowserImageBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html?type=Images') }}",
                filebrowserUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
                filebrowserImageUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}"
            });
        });

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>
@stop