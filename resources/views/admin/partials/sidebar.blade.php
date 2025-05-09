<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
            @if (Auth::user()->images->count() > 0)
                <img class="img-circle elevation-2" src="{{ asset('storage/'.Auth::user()->images->first()->link) }}" alt="{{ Auth::user()->name }}">
            @else
                <img class="img-circle elevation-2" src="{{ asset('images/common/no-photo-user.png') }}" alt="{{ Auth::user()->name }}">
            @endif
        </div>
        <div class="info">
            <a href="{{ route('profile.index') }}" class="d-block">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
        </div>
        <a href="{{ route('logout') }}" class="pl-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="right fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('profile.index') }}" class="nav-link {{ (request()->is('profile') ? 'active' : '') }}">
                    <i class="fas fa-user"></i>
                    <p>Profile</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.contacts.index') }}" class="nav-link {{ (request()->is('profile/contacts*') ? 'active' : '') }}">
                    <i class="fas fa-phone-square-alt"></i>
                    <p>Contacts</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.messages.index') }}" class="nav-link {{ (request()->is('profile/messages*') ? 'active' : '') }}">
                    <i class="fas fa-comments"></i>
                    <p>Messages</p>
                    <?php $count = Auth::user()->newThreadsCount(); ?>
                    @if($count > 0)
                        <span class="badge badge-danger">{{ $count }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item {{ (request()->is('profile/listings*') ? 'menu-open' : '') }}">
                <a class="nav-link {{ (request()->is('profile/listings*') ? 'active' : '') }}">
                    <i class="fas fa-server"></i>
                    <p>Listings <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('profile.listings.index') }}" class="nav-link {{ (request()->is('profile/listings') ? 'active' : '') }}">
                            <i class="fas fa-server nav-icon"></i>
                            <p>All</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('profile.listings.create') }}" class="nav-link {{ (request()->is('profile/listings/create') ? 'active' : '') }}">
                            <i class="fas fa-plus nav-icon"></i>
                            Create
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.listings.active') }}" class="nav-link {{ (request()->is('profile/listings/active') ? 'active' : '') }}">
                            <i class="far fa-check-square nav-icon"></i>
                            <p>Active</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.listings.moderation') }}" class="nav-link {{ (request()->is('profile/listings/moderation') ? 'active' : '') }}">
                            <i class="fas fa-user-shield nav-icon"></i>
                            <p>Moderation</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.listings.archive') }}" class="nav-link {{ (request()->is('profile/listings/archive') ? 'active' : '') }}">
                            <i class="fas fa-archive nav-icon"></i>
                            <p>Archive</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.notifications.index') }}" class="nav-link {{ (request()->is('profile/notifications') ? 'active' : '') }}">
                    <i class="fas fa-bell"></i>
                    <p>Notifications</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.supports.index') }}" class="nav-link {{ (request()->is('profile/supports*') ? 'active' : '') }}">
                    <i class="fas fa-headset"></i>
                    <p>Support</p>
                </a>
            </li>

            @canany(['admin', 'moder'])
            <li class="nav-header">MODERATION</li>
            <li class="nav-item">
                <a href="{{ route('admin.listings.index') }}" class="nav-link">
                    <i class="fas fa-user-lock"></i>
                    <p>Listings</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.companies.index') }}" class="nav-link">
                    <i class="fas fa-building"></i>
                    <p>Companies</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.supports.index') }}" class="nav-link {{ (request()->is('admin-panel/supports*') ? 'active' : '') }}">
                    <i class="fas fa-headset"></i>
                    <p>Support</p>
                </a>
            </li>
            @endcanany

            @can('admin')
            <li class="nav-header">ADMINISTRATION</li>
            <li class="nav-item {{ (request()->is('admin-panel/categories*', 'admin-panel/products*', 'admin-panel/manufacturers*', 'admin-panel/algorithms*', 'admin-panel/coins*', 'admin-panel/statuses*', 'admin-panel/properties*', 'admin-panel/property-values*') ? 'menu-open' : '') }}">
                <a class="nav-link {{ (request()->is('admin-panel/categories*', 'admin-panel/products*', 'admin-panel/manufacturers*', 'admin-panel/algorithms*', 'admin-panel/coins*', 'admin-panel/statuses*', 'admin-panel/properties', 'admin-panel/property-values') ? 'active' : '') }}">
                    <i class="far fa-file-alt"></i>
                    <p>Products <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ (request()->is('admin-panel/products*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Product Models</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ (request()->is('admin-panel/categories*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.properties.index') }}" class="nav-link {{ (request()->is('admin-panel/properties*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Properties</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.property-values.index') }}" class="nav-link {{ (request()->is('admin-panel/property-values*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Property values</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.manufacturers.index') }}" class="nav-link {{ (request()->is('admin-panel/manufacturers*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Manufacturers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.algorithms.index') }}" class="nav-link {{ (request()->is('admin-panel/algorithms*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Algoritms</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.coins.index') }}" class="nav-link {{ (request()->is('admin-panel/coins*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Coins</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.statuses.index') }}" class="nav-link {{ (request()->is('admin-panel/statuses*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Statuses</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (request()->is('admin-panel/pages*', 'admin-panel/sections*') ? 'menu-open' : '') }}">
                <a class="nav-link {{ (request()->is('admin-panel/pages*', 'admin-panel/sections*') ? 'active' : '') }}">
                    <i class="fas fa-copy"></i>
                    <p>Pages</p> <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ (request()->is('admin-panel/pages*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sections.index') }}" class="nav-link {{ (request()->is('admin-panel/sections*') ? 'active' : '') }}">
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
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ (request()->is('admin-panel/users*') ? 'active' : '') }}">
                    <i class="fas fa-users-cog"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item {{ (request()->is('admin-panel/settings*') ? 'menu-open' : '') }}">
                <a href="#" class="nav-link {{ (request()->is('admin-panel/settings*') ? 'active' : '') }}">
                    <i class="fas fa-cog"></i>
                    <p>Settings <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ (request()->is('admin-panel/settings*') ? 'active' : '') }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Variables</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

        </ul>
    </nav>
</div>
