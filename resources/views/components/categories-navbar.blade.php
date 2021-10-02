<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle active" href="#" id="categoriesNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{__("app.categories")}}
    </a>
    <ul class="dropdown-menu overflow-auto" style="max-height: 200px" aria-labelledby="categoriesNavigation">
        @foreach ($categories as $category)
            <li><a class="dropdown-item text-center" href="/seller/category/{{$category->id}}">{{ $category->name }}</a></li>
            @if (!$loop->last)
            <li><hr class="dropdown-divider"></li>
            @endif
        @endforeach
    </ul>
</li>