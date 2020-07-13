@foreach($childs as $child)
	<tr>
                    	<td>
                        	@if (file_exists(public_path($child->image)) && $child->image!='')
                        		<img src="{{URL::asset($child->image)}} " alt="{{$child->name}}" width="50">
                            @else
                                <img src="{{ asset('assets/uploads/no_img.gif') }}" alt="{{$child->name}}" width="50">
                            @endif    
                        </td>
                        <td>{{ '-----&nbsp;'.$child->name}}</td>
                        <td>{{$child->description}}
                        </td>
                        <td>{{$child->slug}}</td>
                        <td>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Category" href="{{ url('/admin/product-categories/edit').'/'.$child->id }}"> <i class="fa fa-edit"></i></a>
                        	<a class="btn btn-danger btn-xs deleteCategory" href="javascript:;" data-id="{{ $category->id }}" data-toggle="tooltip" title="Delete Category"> <i class="fa fa-remove"></i></a> 	
                        </td>
                    
	@if(count($child->childs))
            @include('admin/listChild',['childs' => $child->childs])
        @endif
	</tr>
@endforeach
