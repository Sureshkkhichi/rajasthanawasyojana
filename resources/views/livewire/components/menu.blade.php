<div>
    <ul class="navbar-nav" id="navbar-nav">
        @php
            $sectionTitles = [
                'dashboard' => 'Dashboard',
                'projects' => 'Projects',
                'leads' => 'Lead Management',
                'finance' => 'Finance',
                'reports' => 'Reports',
            ];
        @endphp
        @foreach ($sidebar as $section => $menus)
            @php
                $visibleMenus = collect($menus)
                    ->filter(function ($menu) {
                        $hasPermission =
                            !isset($menu['permission']) ||
                            (auth()->check() && auth()->user()->can($menu['permission']));
                        $isVisible = !isset($menu['visible']) || value($menu['visible']);
                        return $hasPermission && $isVisible;
                    })
                    ->values();
            @endphp
            @continue($visibleMenus->isEmpty())
            <li class="menu-title {{ $loop->first ? '' : 'mt-3' }}">
                <span>{{ $sectionTitles[$section] ?? ucfirst($section) }}</span>
            </li>
            @foreach ($visibleMenus as $menu)
                @php
                    $routeName = $menu['route'];
                    $routeParams = $menu['params'] ?? [];
                    $menuUrl = $menu['is_route'] ?? true ? route($routeName, $routeParams) : 'javascript:void(0);';
                    $isActive = $menu['is_route'] ?? true ? request()->routeIs($routeName) : false;
                    $badge = $menu['badge'] ?? null;
                    $badgeValue = $badge ? $counts[$badge['key']] ?? 0 : null;
                @endphp
                <li class="nav-item">
                    <a href="{{ $menuUrl }}"
                        class="nav-link menu-link {{ $isActive ? 'active' : '' }} {{ $badge ? 'd-flex align-items-center justify-content-between' : '' }}">
                        <div>
                            <i class="{{ $menu['icon'] }}"></i>
                            <span>{{ $menu['title'] }}</span>
                        </div>
                        @if ($badge)
                            <span class="badge rounded-pill {{ $badge['class'] }}">
                                {{ $badgeValue }}
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        @endforeach
        <li class="nav-item">
            <a href="javascript:void(0);" wire:click="logout" class="nav-link menu-link">
                <div>
                    <i class="ri-logout-box-r-line"></i>
                    <span>Logout</span>
                </div>
            </a>
        </li>
    </ul>
</div>