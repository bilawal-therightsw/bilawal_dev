<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="media user-profile mt-2 mb-2">
        

        <div class="media-body">
            <h6 class="pro-user-name mt-0 mb-0">{{auth()->user()->user_name ?? ucwords(auth()->user()->name)}}</h6>
            <span class="pro-user-desc">{{ucwords(getUserRole(auth()->user()) ? getUserRole(auth()->user())->title : null)}}</span>
        </div>
        <div class="dropdown align-self-center profile-dropdown-menu">
            <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                aria-expanded="false">
                <span data-feather="chevron-down"></span>
            </a>
            <div class="dropdown-menu profile-dropdown">
                

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
    <div class="sidebar-content">
       
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Navigation</li>
                <li>
                    <a href="{{route('dashboard.')}}">
                        <i data-feather="home"></i>
                        <span class="badge badge-success float-right"></span>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.products.index')}}">
                        <i data-feather="tag"></i>
                        <span class="badge badge-success float-right"></span>
                        <span> Products </span>
                    </a>
                </li>
                @hasrole('admin')
                    <li>
                        <a href="{{ route('dashboard.staff.index')}}">
                            <i data-feather="users"></i>
                            <span class="badge badge-success float-right"></span>
                            <span> Staff </span>
                        </a>
                    </li>
                @endhasrole
                @hasrole('admin|staff')
                    <li>
                        <a href="{{ route('dashboard.users.index') }}">
                            <i data-feather="user"></i>
                            <span class="badge badge-success float-right"></span>
                            <span> Users </span>
                        </a>
                    </li>
                @endhasrole
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
