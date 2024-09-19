<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center justify-content-between">
        {{-- <div class="image">
            <img src="" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
            <a href="{{ route('profile.index') }}" class="d-block">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
        </div>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
            <i class="right fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('profile.index') }}" class="nav-link">
                    <i class="fas fa-user"></i>
                    <p>Profile</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link">
                    <i class="fas fa-tablet-alt"></i>
                    <p>listings <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Active</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Moderation</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Archive</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Coins</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-header">ADMINISTRATION</li>
            <li class="nav-item {{ (request()->is('admin/categories*', 'admin/manufacturers*', 'admin/algorithm*', 'admin/coin*') ? 'menu-open' : '') }}">
                <a class="nav-link {{ (request()->is('admin/categories*', 'admin/manufacturers*', 'admin/algorithm*', 'admin/coin*') ? 'active' : '') }}">
                    <i class="far fa-file-alt"></i>
                    <p>Products <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ (request()->is('admin/categories*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Models</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.manufacturers.index') }}" class="nav-link {{ (request()->is('admin/manufacturers*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Manufacturers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.algorithm.index') }}" class="nav-link {{ (request()->is('admin/algorithm*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Algoritms</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.coin.index') }}" class="nav-link {{ (request()->is('admin/coin*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Coins</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (request()->is('admin/pages*', 'admin/sections*') ? 'menu-open' : '') }}">
                <a class="nav-link {{ (request()->is('admin/pages*', 'admin/sections*') ? 'active' : '') }}">
                    <i class="fas fa-copy"></i>
                    <p>Pages</p> <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ (request()->is('admin/pages*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sections.index') }}" class="nav-link {{ (request()->is('admin/sections*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Sections</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.support.index') }}" class="nav-link">
                    <i class="fas fa-headset"></i>
                    <p>Help requests</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ (request()->is('admin/users*') ? 'active' : '') }}">
                    <i class="fas fa-users-cog"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('admin/settings*') ? 'menu-open' : '') }}">
                <a href="#" class="nav-link {{ (request()->is('admin/settings*') ? 'active' : '') }}">
                    <i class="fas fa-cog"></i>
                    <p>Settings <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ (request()->is('admin/settings*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Variables</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>