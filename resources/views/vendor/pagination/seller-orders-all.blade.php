@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo; prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="<?php if(request()->query("sort_by") || request()->query("sort_by") === "0") {echo url()->full() . "&page=" . ($paginator->currentPage() - 1);} else {echo "?page=".($paginator->currentPage() - 1) ;} ?>" rel="prev" aria-label="@lang('pagination.previous')"> &lsaquo; prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="<?php if(request()->query("sort_by") || request()->query("sort_by") === "0") {echo url()->full() . "&page=" . ($paginator->currentPage() + 1);} else {echo "?page=".($paginator->currentPage() + 1) ;} ?>" rel="next" aria-label="@lang('pagination.next')">next &rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">next &rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
