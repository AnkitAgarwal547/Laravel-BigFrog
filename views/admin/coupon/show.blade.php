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

                    <h3 class="box-title">Coupons</h3>
                    <a href="{{ url('admin/coupon/add')}}" class="btn btn-info pull-right"> Add Coupon </a>

                </div>

                <!-- /.box-header -->

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                            <tr>

                                <th>Title</th>

                                <th class="no-sort">Coupon Code</th>

                                <th>Store Name</th>

                                <th>Valid Till</th>

                                <th>Total Clicks</th>

                                <th>Featured</th>

                                <th class="no-sort">Actions</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach ($coupons as $coupon)

                                <tr>

                                    <td>{{ $coupon->name }}</td>

                                    <td>{{ $coupon->coupon_code }}</td>
                                    
                                    <td>{{ ($coupon->store) ? $coupon->store->name: '' }}</td>

                                    <td>{{ date('d-M-Y', strtotime($coupon->valid_till)) }}</td>

                                    <td>{{ $coupon->clicks }}</td>

                                    <td>{{ $coupon->featured == 1 ? 'Yes' : 'No' }}</td>

                                    <td>

                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Coupon" href="{{ url('/admin/coupon/edit').'/' .$coupon->id }}"> <i class="fa fa-edit"></i> </a>

                                        <a class="btn btn-danger btn-xs deleteStoreCoupon" href="javascript:;" data-id="{{ $coupon->id }}" data-toggle="tooltip" title="Delete Coupon"> <i class="fa fa-remove"></i> </a>

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                            <tfoot>

                            <tr>

                                <th>Title</th>

                                <th class="no-sort">Coupon Code</th>

                                <th>Valid Till</th>

                                <th>Total Clicks</th>

                                <th>Featured</th>

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

