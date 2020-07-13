@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-ticket"></i> Add Coupon</h3>
                    <a href="{{ url('/admin/coupons') }}" class="btn btn-warning pull-right">Cancel</a>
                </div>
                <!-- /.box-header -->

                <form class="form-horizontal" role="form" method="POST" id="admin_login" action="{{ url('/admin/coupon/add') }}" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            {{ csrf_field() }}
                            <!-- text input -->
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-sm-2 control-label">Name<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="link" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                         <textarea id="editor1" name="description" rows="10" cols="80">
                                              {{ old('description') }}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('feature_image') ? ' has-error' : '' }}">
                                    <label for="feature_image" class="col-sm-2 control-label">Brand Logo Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" id="feature_image" name="feature_image" accept="image/*">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('coupon_code') ? ' has-error' : '' }}">
                                    <label for="coupon_code" class="col-sm-2 control-label">Coupon Code<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="coupon_code" name="coupon_code" class="form-control" value="{{ old('coupon_code') }}">
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('valid_till') ? ' has-error' : '' }}">
                                    <label for="valid_till" class="col-sm-2 control-label">Expiration Date<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="date" id="valid_till" name="valid_till" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('coupon_type') ? ' has-error' : '' }}">
                                    <label for="coupon_type" class="col-sm-2 control-label">Coupon Type<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="coupon_type" name="coupon_type">
                                            <option value="">Select Type</option>
                                            @foreach ($couponTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('store_id') ? ' has-error' : '' }}">
                                    <label for="store_id" class="col-sm-2 control-label">Store<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="store_id" name="store_id">
                                            <option value="">Select Type</option>
                                            @foreach ($stores as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('link_to_go') ? ' has-error' : '' }}">
                                    <label for="link_to_go" class="col-sm-2 control-label">Destination URL<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="url" id="link_to_go" name="link_to_go" class="form-control" value="{{ old('link_to_go') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="related_coupon">Related Coupon</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="related_coupon" class="flat-red" value="1" {{ old('related_coupon') == 1 ? 'checked="checked"' : '' }}>{{ "&nbsp; Enable as a Related Coupon " }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="featured_coupon">Featured Coupon</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" name="featured_coupon" class="flat-red" value="1" {{ old('featured_coupon') == 1 ? 'checked="checked"' : '' }}>{{ "&nbsp; Enable as a Featured Coupon " }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <hr />
                                        <div class="form-group{{ $errors->has('page_title') ? ' has-error' : '' }}">
                                            <label for="page_title" class="col-sm-2 control-label">Meta Title</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Meta Title.">{{ old('page_title') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('page_keyword') ? ' has-error' : '' }}">
                                            <label for="page_keyword" class="col-sm-2 control-label">Meta Keyword</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" id="page_keyword" name="page_keyword" placeholder="Meta Keyword.">{{ old('page_keyword') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('page_description') ? ' has-error' : '' }}">
                                            <label for="page_description" class="col-sm-2 control-label">Meta Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" rows="3" id="page_description" name="page_description" placeholder="Meta Description.">{{ old('page_description') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-info pull-right">Save</button>
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
    </div>
    <!-- /.row -->
@endsection

@section('styles')
    <!-- CK Editor -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/select2.min.css') }}">
@stop

@section('scripts')
    <!-- CK Editor -->
    <script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/select2/select2.full.min.js') }}"></script>
    <script>

        $(function () {
            $(".select2").select2();
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