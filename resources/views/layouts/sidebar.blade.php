@php
$user = Auth::user();
$menuData = [];
array_push($menuData, ['home', 'Dashboard', 'fa-home']);
array_push($menuData, ['production', 'Production', 'fa-briefcase']);
array_push($menuData, ['transfer', 'Transfer', 'fa-archive']);
array_push($menuData, ['receipt', 'Receipt', 'fa-dropbox']);
array_push($menuData, ['allocation', 'Allocation', 'fa-arrows-alt']);
array_push($menuData, ['delivery', 'Deliery', 'fa-truck']);
array_push($menuData, ['stock', 'Stock', 'fa-search']);
array_push($menuData, ['warehouse', 'Warehouse', 'fa-building']);
array_push($menuData, ['area', 'Area', 'fa-square']);
array_push($menuData, ['line', 'Line', 'fa-exchange']);
array_push($menuData, ['product', 'Product', 'fa-tags']);
if($user->user_username=='admin')
{
array_push($menuData, ['user', 'User', 'fa-users']);
}
//array_push($menuData, ['logout', 'Logout', 'fa-sign-out']);
@endphp
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500" >

        <ul class="m-menu__nav ">
        <!--Navbar-->
                <nav class="navbar navbar-dark red lighten-1 mb-4">
                <!-- Navbar brand -->
                <a class="navbar-brand fas fa-archive" href="#" > Navbar </a>
                <!-- Collapse button -->
                <button class="navbar-toggler second-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent23"
                aria-controls="navbarSupportedContent23" aria-expanded="false" aria-label="Toggle navigation">
                <span class="white-text"><i class="fas fa-bars fa-1x"></i></span>
                </button>
                <!-- Collapsible content -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent23">
                <!-- Links -->
                    <li class="nav-item active">
                          <a class="nav-link" class="m-menu__link " href="#">
                                <span class="m-menu__item-here"></span>
                                <i class="m-menu__link-icon fa "></i>
                                <span class="m-menu__link-text">Home
                                </span>
                           </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                <!-- Links -->
                </div>
                <!-- Collapsible content -->
                </nav>

            @foreach($menuData as $menu)
            <li class="m-menu__item " aria-haspopup="true" >
                <a  href="{{ $menu['0'] }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa {{ $menu['2'] }}"></i>
                    <span class="m-menu__link-text">
                        {{ $menu['1'] }}

                    </span>
                </a>
            </li>
            @endforeach

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>


