@extends('layouts.adminapp')

@section('content')
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-eye"></i></span>

            <div class="info-box-content">
              <span class="info-box-text no-word-wrap">Coupons Total Clicks</span>
                <span class="info-box-number">
                @php $total = 0; @endphp
                @foreach ($coupon_clicks as $coupon)
                    @php
                        $total = $coupon->clicks + $total;
                    @endphp
                @endforeach
                {{ $total }}
{{--              <span class="info-box-number"><small><i class="fa fa-rupee"></i></small>{{ $order_stats->total_amount > 0 ? $order_stats->total_amount : 0 }} - {{ $order_stats->total_orders > 0 ? $order_stats->total_orders : 0 }}</span>--}}
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-ticket"></i></span>

            <div class="info-box-content">
              <span class="info-box-text no-word-wrap">Total Coupons</span>
              <span class="info-box-number">{{ count($coupon_clicks) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text no-word-wrap">Total Stores</span>
              <span class="info-box-number">{{ $store }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-comment-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text no-word-wrap">Total Blogs</span>

              <span class="info-box-number">{{ $totalBlogs }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
                 
                    
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Posts</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Posted On</th>
                    <th>Total Views</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($blogs as $blog)
                  		<tr>
                            <td>
                                @if (file_exists(public_path($blog->featured_image)) && $blog->featured_image!='')
                                    <img src="{{URL::asset($blog->featured_image)}}" width="100">
                                @else
                                    <img src="{{ asset('assets/uploads/no_img.gif') }}" width="100">
                            @endif
                            </td>
                            <td>{{ $blog->title }}</td>
                            <td>
                                {{ date('M d, Y', strtotime($blog->created_at)) }} | {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}
                            </td>
                            <td>
                                {{ $blog->view_count }}
                            </td>
                  		</tr>
                  @endforeach

                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <a href="{{ url('admin/blogs')}}" class="btn btn-sm btn-default btn-flat pull-right">View All Posts</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
          
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <form action="{{ url('admin/quick-mail') }}" method="post" id="quick_email">
            <div class="box-body">
              	 {{ csrf_field() }}
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" id="emailto" placeholder="Email to:">
                  <span class="help-block emailto-error"></span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
                  <span class="help-block subject-error"></span>
                </div>
                <div class="form-group">
                    <textarea class="form-control" placeholder="Message" name="message" id="message"></textarea>
                    <span class="help-block message-error"></span>
                </div>
              
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-default"> Send <i class="fa fa-spinner fa-pulse fa-1x fa-fw processing-icon" style="display: none;"></i><span class="sr-only">Loading...</span><i class="fa fa-arrow-circle-right send-icon"></i></button>
            </div>
            </form>
          </div>
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          
          <!-- PRODUCT LIST -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Recently Added Coupons</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                  @foreach ($coupons as $coupon)
                      <li class="item">
                          <div class="product-img">
                            @if($coupon->store)
                              @if (file_exists(public_path($coupon->store->image)) && $coupon->store->image!='')
                                  <img src="{{ URL::asset($coupon->store->image) }}" width="50">
                              @endif
                            @else
                                <img src="{{ asset('assets/uploads/no_img.gif') }}" width="50">
                            @endif
                          </div>
                          <div class="product-info">
                              <a href="javascript:void(0)" class="product-title">{{ $coupon->name }}
                                  <span class="label label-warning pull-right">
                                    <small><i class="fa fa-calendar"></i></small>&nbsp;{{ date('Y-m-d', strtotime($coupon->valid_till)) }}
                                  </span>
                              </a>
                          </div>
                      </li>
                  @endforeach
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="{{ url('admin/coupons') }}" class="uppercase">View All Coupons</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection  
  
@section('scripts')
<!-- jvectormap -->
<script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('assets/admin/plugins/chartjs/Chart.min.js') }}"></script>
<script>
	$(document).ready(function () {
 
		var form = $('#quick_email');
		form.submit(function(e) {
		    $('.processing-icon').show();
		    $('.send-icon').hide();

			e.preventDefault();
			$.ajax({
				url     : form.attr('action'),
				type    : form.attr('method'),
				data    : form.serialize(),
				dataType: 'json',
				success : function ( data )
				{
					if(data.errors) {
						$.each(data.errors, function (key, value) {
							$('.'+key+'-error').html(value);
							$('.'+key+'-error').closest('div.form-group').addClass('has-error');
						});
                        $('.processing-icon').hide();
                        $('.send-icon').show();
                	}
					if(data.success == 1){
                        form.prepend('<div class="msg-component"><div class="alert alert-success alert-fill alert-close alert-dismissable show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</button><strong>Email Sent Succesfully!</strong></div></div>');
						form[0].reset();
                        $('.processing-icon').hide();
                        $('.send-icon').show();
            setTimeout(function(){ $('div.msg-component').remove(); }, 5000);
					}
				},
				error: function( json )
				{
					if(json.status === 422) {
						$.each(json.responseJSON, function (key, value) {
							$('.'+key+'-error').html(value);
							$('.'+key+'-error').closest('div.form-group').addClass('has-error');
						});
					} else {
						// Error
                    	
                    	// alert('Incorrect credentials. Please try again.')
					}
				}
			});
		});
	 
	});
</script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/admin/dist/js/pages/dashboard2.js') }}"></script>

@stop
