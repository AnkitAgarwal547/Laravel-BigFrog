@extends('layouts.adminapp')



@section('content')



    <div class="row">

        <!-- left column -->



        <!--/.col (left) -->

        <!-- right column -->

        <div class="col-md-12">

            <div class="box box-info">

                <div class="box-header">

                    <i class="fa fa-film"></i>

                    <h3 class="box-title">Video Guide</h3>
                    <a href="{{ url('admin/guide/video/add')}}" class="btn btn-info pull-right"> Add Video Guide </a>

                </div>

                <!-- /.box-header -->

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                            <tr>

                                <th>Video Link</th>

                                <th class="no-sort">Actions</th>


                            </tr>

                            </thead>

                            <tbody>

                            @foreach ($links as $link)

                                <tr>

                                    <td>{{ $link->video_link }}</td>

                                    <td>

                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Video Guide" href="{{ url('/admin/guide/video/edit').'/' .$link->id }}"> <i class="fa fa-edit"></i> </a>

                                        <a class="btn btn-danger btn-xs deleteVideoGuide" href="javascript:;" data-id="{{ $link->id }}" data-toggle="tooltip" title="Delete Video Guide"> <i class="fa fa-remove"></i> </a>

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                            <tfoot>

                            <tr>

                                <th>Video Link</th>

                                <th class="no-sort">Actions</th>

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