@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa-file"></i>
              <h3 class="box-title">Pages</h3>
                <a href="{{ url('admin/pages/add') }}" class="btn btn-primary pull-right">Add New Page</a>
            </div>
            
            <?php /*?><div class="box-body">
            	<a href="{{ url('admin/home-pager/add-page')}}" class="btn btn-info pull-right"> Add New page </a>
            </div><?php */?>
            
            <!-- /.box-header -->
            <div class="box-body">
             <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Title</th>
                  <th>Meta Title</th>
                  <th>Meta Keyword</th>
                  <th>Meta Description</th>
                  <th class="no-sort">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($pages as $page)
                    <tr>
                    	<td>
                         {{$page->title}}	
                        </td>
                        
                        <td>{{$page->page_title}}</td>
                         <td>{{$page->page_keyword}}</td>
                          <td>{{$page->page_description}}</td>
                        <td>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="View page" target="_blank" href="{{ url('/').'/'.$page->slug }}"> <i class="fa fa-search"></i> </a>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit page" href="{{ url('/admin/pages/edit').'/'.$page->id }}"> <i class="fa fa-edit"></i> </a>
                            <a class="btn btn-danger btn-xs deletePage" href="javascript:;" data-id="{{ $page->id }}" data-toggle="tooltip" title="Delete Page"> <i class="fa fa-remove"></i> </a> 	
                        </td>
                    </tr>
                    
                    @endforeach 

                
                </tbody>
                <tfoot>
                <tr>
                  <th>Title</th>
                  <th>Meta Title</th>
                  <th>Meta Keyword</th>
                  <th>Meta Description</th>
                  <th>&nbsp;</th>
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