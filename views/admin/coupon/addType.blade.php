@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Coupon Type</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" action="{{ url('/admin/coupons/types') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <!-- text input -->
                        <div class="form-group{{ $errors->has('typename') ? ' has-error' : '' }}">
                            <label>Name<span style="color: red;"> *</span></label>
                            <input type="text" class="form-control" name="typename" value="{{ old('typename') }}" placeholder="The name is how it appears on your site.">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="The 'slug' is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.">
                        </div>


{{--                        <div class="form-group">--}}
{{--                            <label>Coupon Categories</label><br/>--}}
{{--                            @foreach ($categories as $category)--}}
{{--                                <input type="checkbox" name="categories[]" class="flat-red" value="{{ $category->id }}">{{ "&nbsp; ".$category->name }} <br/>--}}

{{--                            @endforeach--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" name="description" placeholder="The description is not prominent by default; however, some themes may show it.">{{ old('description') }}</textarea>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label>Thumbnail</label>--}}
{{--                            <input type="file" id="exampleInputFile" name="thumbnail" accept="image/*">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label>Main Image</label>--}}
{{--                            <input type="file" name="main_image" accept="image/*">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label>Featured Image</label>--}}
{{--                            <input type="file" name="featured_image" accept="image/*">--}}
{{--                        </div>--}}

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Add New Coupon Type</button>
                        </div>


                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-8">
            <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="no-sort">Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Slug</th>
                                <th class="no-sort">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>

                                        @if (file_exists(public_path($type->thumbnail)) && $type->thumbnail!='')
                                            <img src="{{URL::asset($type->thumbnail)}} " alt="{{$type->thumbnail}}" width="50">
                                        @else
                                            <img src="{{ asset('assets/uploads/no_img.gif') }}" alt="" width="50">
                                        @endif
                                    </td>
                                    <td>{{$type->title}}</td>
                                    <td>{{$type->description}}
                                    </td>
                                    <td>{{$type->slug}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Type" href="{{ url('/admin/coupons/edit-type').'/'.$type->id }}"> <i class="fa fa-edit"></i> </a>
                                        <a class="btn btn-danger btn-xs deleteCouponType" href="javascript:;" data-id="{{ $type->id }}" data-toggle="tooltip" title="Delete Type"> <i class="fa fa-remove"></i> </a>
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Slug</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
@endsection
@section('styles')
    <style>
        span.text-block{width: 5% !important;display: inline-block;}
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/select2.min.css') }}">
@stop

@section('scripts')
    <script src="{{ asset('assets/admin/plugins/select2/select2.full.min.js') }}"></script>
    <script>

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });

        $('input').on('ifChanged', function (event) { $(event.target).trigger('change'); });
        $(document).on('change','input[type="checkbox"].attr_check', function() {
            var id =$(this).attr('data-id');
            if($(this).is(':checked'))
            {
                $('.attr_values_'+id).show();
            }else{
                $('.attr_values_'+id).hide();
            }
        });



    </script>
@stop