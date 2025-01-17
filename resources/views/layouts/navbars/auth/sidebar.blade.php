<aside data-color="info"
       class="sidenav navbar bg-gray-200 navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
       id="sidenav-main">
    <div class="sidenav-header bg-gray-200 pb-4">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <h6 class="ms-3 font-weight-bold">Part Quoting System</h6>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto bg-gray-200" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ url('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-house ps-2 pe-2 text-center text-dark {{ (Request::is('dashboard') ? 'text-white' : 'text-dark') }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            @if (Auth::user() && Auth::user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link {{ (Request::is('user-management') ? 'active' : '') }}"
                    href="{{ url('user-management') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-user ps-2 pe-2 text-center text-dark {{ (Request::is('user-management') ? 'text-white' : 'text-dark') }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{ (Route::currentRouteNamed('quote-requests.*') ? 'active' : '') }}"
                    href="{{ url('quote-requests') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-truck-front ps-2 pe-2 text-center text-dark {{ (Request::is('quote-requests') ? 'text-white' : 'text-dark') }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Quote Requests</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (Route::currentRouteNamed('part-quotes.*') ? 'active' : '') }}"
                    href="{{ url('part-quotes') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-truck-fast ps-2 pe-2 text-center text-dark {{ (Request::is('part-quotes') ? 'text-white' : 'text-dark') }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Completed Quotes</span>
                </a>
            </li>
        </ul>
    </div>

</aside>
