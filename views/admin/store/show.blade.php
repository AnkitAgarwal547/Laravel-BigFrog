@extends('layouts.adminapp')



@section('content')



    <div class="row">

        <!-- left column -->



        <!--/.col (left) -->

        <!-- right column -->

        <div class="col-md-12">

            <div class="box box-info">

                <div class="box-header">

                    <i class="fa fa-ticket"></i>

                    <h3 class="box-title">Stores</h3>
                    <a href="{{ url('admin/store/add')}}" class="btn btn-info pull-right"> Add Store </a>

                </div>

                <!-- /.box-header -->

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                            <tr>

                                <th class="no-sort">Image</th>

                                <th>Name</th>

                                <th>Rating</th>

                                <th class="no-sort">Actions</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach ($stores as $store)

                                <tr>

                                    <td>

                                        @if (file_exists(public_path($store->image)) && $store->image!='')

                                            <img src="{{URL::asset($store->image)}}" width="100">

                                        @else

                                            <img src="{{ asset('assets/uploads/no_img.gif') }}" width="100">

                                        @endif

                                    </td>

                                    <td>{{$store->name}}</td>


                                    <td>
                                        @if(count($store->storeReview) > 0)
                                            @php $sum = 0; @endphp
                                            @foreach ($store->storeReview as $key=>$review)
                                                @php $sum = $sum + $review['stars'] @endphp
                                            @endforeach
                                            @php
                                                $total = $sum/($key+1);
                                                round($total).'.0';
                                            @endphp
                                        @else
                                            @php $total = '0.0'; @endphp
                                        @endif
                                        @if(round($total) > 0)
                                            @for($i=1; $i<= 5; $i++)
                                                <i class="@if(round($total) >= $i) fa fa-star @else fa fa-star-o @endif" style="color: #AE0701"></i>
                                            @endfor
                                        @else
                                            <i class="fa fa-star-o" style="color: #AE0701"></i>
                                            <i class="fa fa-star-o" style="color: #AE0701"></i>
                                            <i class="fa fa-star-o" style="color: #AE0701"></i>
                                            <i class="fa fa-star-o" style="color: #AE0701"></i>
                                            <i class="fa fa-star-o" style="color: #AE0701"></i>
                                        @endif

                                    </td>

                                    <td>

                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Store" href="{{ url('/admin/store/edit').'/'.$store->id }}"> <i class="fa fa-edit"></i> </a>

                                        <a class="btn btn-danger btn-xs deleteStore" href="javascript:;" data-id="{{ $store->id }}" data-toggle="tooltip" title="Delete Store"> <i class="fa fa-remove"></i> </a>

                                    </td>

                                </tr>



                            @endforeach



                            </tbody>

                            <tfoot>

                            <tr>

                                <th>Image</th>

                                <th>Name</th>

                                <th>Rating</th>

                                <th>Actions</th>

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

