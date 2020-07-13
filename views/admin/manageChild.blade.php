
@foreach($childs as $child)

	<option value="{{ $child->id }}" {{ $selectCategory > 0 && $child->id == $selectCategory ?  'selected="selected"' : ""}} >{{ "&nbsp;&nbsp;&nbsp;&nbsp;".$child->name }}
	@if(count($child->childs))
            @include('admin/manageChild',['childs' => $child->childs])
        @endif
	</option>
@endforeach
