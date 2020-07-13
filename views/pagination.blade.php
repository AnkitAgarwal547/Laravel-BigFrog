<ul class="pagination">
  @if(PaginateRoute::hasPreviousPage())
  	<li class="page-item"> <a href="{{ PaginateRoute::previousPageUrl() }}" aria-label="Previous" class="page-link">Previous</a></li>
  @else
  	<li class="disabled"><a href="javascript:void(0)" aria-label="Previous" class="page-link">Previous</a><li>
  @endif
  @php
      $last = $paginator->lastPage();
      $current = $paginator->currentPage();
      $maxPagesToShow = 10;
        if ($last <= $maxPagesToShow) {
        @endphp
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
              <a href="{{ PaginateRoute::pageUrl($i) }}" aria-label="{{ $i }}" class="page-link">{{ $i }}</a>
            </li>
            @endfor
        @php    
        } else {
            // Determine the sliding range, centered around the current page.
            $numAdjacents = (int) floor(($maxPagesToShow - 3) / 2);
            if ($current + $numAdjacents > $last ) {
                $slidingStart = $last - $maxPagesToShow + 2;
            } else {
                $slidingStart = $current - $numAdjacents;
            }
            if ($slidingStart < 2) $slidingStart = 2;
            $slidingEnd = $slidingStart + $maxPagesToShow - 3;
            if ($slidingEnd >= $last) $slidingEnd = $last - 1;
            // Build the list of pages.
        @endphp

            <li class="page-item {{ ($paginator->currentPage() == 1) ? ' c-active' : '' }}">
              <a href="{{ PaginateRoute::pageUrl(1) }}" aria-label="1" class="page-link">1</a>
            </li>
            @if ($slidingStart > 2) 
                <li class="disabled"><span>...</span></li>
            @endif
            @for ($i = $slidingStart; $i <= $slidingEnd; $i++)
            <li class="page-item {{ ($paginator->currentPage() == $i) ? ' c-active' : '' }}">
              <a href="{{ PaginateRoute::pageUrl($i) }}" aria-label="{{ $i }}" class="page-link">{{ $i }}</a>
            </li>
            @endfor
            @if ($slidingEnd < $last - 1) 
                <li class="disabled"><span>...</span></li>
            @endif
            <li class="page-item {{ ($paginator->currentPage() == $last) ? ' c-active' : '' }}">
              <a href="{{ PaginateRoute::pageUrl($last) }}" aria-label="{{ $last }}" class="page-link">{{ $last }}</a>
            </li>

          @php
        }
@endphp


  @if(PaginateRoute::hasNextPage($paginator))
  	<li class="page-item"> <a href="{{ PaginateRoute::nextPageUrl($paginator) }}" aria-label="Next" class="page-link">Next</a></li>
  @else 
    <li class="disabled"><a href="javascript:void(0)" aria-label="Next" class="page-link">Next</a></li>
  @endif

</ul>



