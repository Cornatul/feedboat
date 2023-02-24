<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.imported') ? 'active'  : '' }}"
           href="{{ route('feeds.index') }}">{{ __('Feeds') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.search') ? 'active'  : '' }}"
           href="{{ route('feeds.search') }}">{{ __('Search') }}</a>
    </li>
</ul>
