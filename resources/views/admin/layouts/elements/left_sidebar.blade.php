<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo">
		<a href="{{route('admin.dashboard')}}" class="app-brand-link">
			<span class="app-brand-text demo menu-text fw-bold ms-2 text-capitalize fs-4">{{ config('app.name') }} Admin</span>
		</a>

		<a href="javascript:void(0);"
			class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="bx bx-chevron-left bx-sm align-middle"></i>
		</a>
	</div>

	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">
		<li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : ''}}">
			<a href="{{route('admin.dashboard')}}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-home-circle"></i>
				<div data-i18n="Dashboard">Dashboard</div>
			</a>
		</li>

		<li class="menu-item {{ request()->routeIs('admin.location.*') || request()->routeIs('admin.branch.*') || request()->routeIs('admin.bank.*') || request()->routeIs('admin.account.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate" data-i18n="Master">Master</div>
            </a>
            <ul class="menu-sub">
                @foreach([
                    ['route' => 'admin.location.index', 'text' => 'Location'],
					['route' => 'admin.branch.index', 'text' => 'Branch'],
					['route' => 'admin.bank.index', 'text' => 'Bank'],
					['route' => 'admin.account.index', 'text' => 'Account'],
                ] as $mastermenu)
                    <li class="menu-item {{ request()->routeIs($mastermenu['route']) ? 'active' : '' }}">
                        <a href="{{ route($mastermenu['route']) }}" class="menu-link">
                            <i class="menu-icon tf-icons"></i>
                            <div data-i18n="{{ $mastermenu['text'] }}">{{ $mastermenu['text'] }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
		
	</ul>
</aside>