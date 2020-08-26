@php
$user = Auth::user();
$menuData = [];
//array_push($menuData, ['home', 'Dashboard', 'fa-home']);


//array_push($menuData, ['logout', 'Logout', 'fa-sign-out']);
@endphp
<link rel="stylesheet" href="css/navbarside.css" type="text/css">

<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500" >

        <ul class="m-menu__nav ">
        <!--Navbar-->
                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="home" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-tachometer"></i>
                    <span class="m-menu__link-text">
                        Dashboard
                    </span>
                </a>
                </li>

                <li data-toggle="collapse" data-target="#mrp" class="m-menu__item" aria-haspopup="true">
                  <a href="#" class="m-menu__link">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-calculator"></i>
                    <span class="m-menu__link-text">
                        <span id="mrpstyle">
                         MRP
                         </span>
                         <span id="iconplus" class="white-text">
                            <i   class="fa fa-plus-circle"></i>
                        </span>
                    </span>
                    </a>
                </li>


                <ul class="sub-menu collapse" id="mrp">

                        <ul id="dropbar" class="m-menu__nav ">
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="home" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-home fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Home
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="mrponhand" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-gift fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Onhand Master
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="dailyplan" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-black-tie fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            PSI Function
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="#" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-btc fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Pricing
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="bomlist" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-sellsy fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Bom List
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="itemstatic" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-line-chart fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Item Static
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="mrp" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-bar-chart fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Launch  MRP
                                        </span>
                                    </a>
                                </li>
                        </ul>
                </ul>

                <li data-toggle="collapse" data-target="#producti" class="m-menu__item" aria-haspopup="true">
                  <a href="#" class="m-menu__link">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-briefcase"></i>

                    <span class="m-menu__link-text">
                    <span id="mrpstyle">
                     Production
                    </span>
                         <span  id="iconplusi" class="white-text">
                            <i  class="fa fa-plus-circle"></i>
                        </span>
                    </span>

                    </a>
                </li>

                <ul class="sub-menu collapse" id="producti">

                        <ul id="dropbar" class="m-menu__nav ">
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="line" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-exchange fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Line
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="production" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-cubes fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Production Output
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="transfer" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-archive fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Transfer
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="receipt" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-dropbox fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Receipt
                                        </span>
                                    </a>
                                </li>
                        </ul>
                </ul>



                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="allocation" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-arrows-alt"></i>
                    <span class="m-menu__link-text">
                        Allocation
                    </span>
                </a>

                </li>

                <!--<li class="m-menu__item " aria-haspopup="true" >
                
                <a href="delivery" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-truck"></i>
                    <span class="m-menu__link-text">
                        Delivery
                    </span>
                </a>

                </li>-->


                <li data-toggle="collapse" data-target="#delivered" class="m-menu__item" aria-haspopup="true">
                  <a href="#" class="m-menu__link">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-truck"></i>

                    <span class="m-menu__link-text">
                    <span id="mrpstyle">
                     Delivery
                    </span>
                         <span  id="iconplusii" class="white-text">
                            <i  class="fa fa-plus-circle"></i>
                        </span>
                    </span>

                    </a>
                </li>

                <ul class="sub-menu collapse" id="delivered">

                        <ul id="dropbar" class="m-menu__nav ">
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="delivery" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-exchange fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Delivery Order
                                        </span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="preparation" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-cubes fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Preparation
                                        </span>
                                    </a>
                                </li>

                                <li class="m-menu__item " aria-haspopup="true" >
                                    <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                                    <a href="loading" class="m-menu__link">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon fa fa-archive fa-lg" style="font-size: 14px;"></i>
                                        <span class="m-menu__link-text">
                                            Loading
                                        </span>
                                    </a>
                                </li>
                        </ul>
                </ul>


                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="stock" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-search"></i>
                    <span class="m-menu__link-text">
                        Stock
                    </span>
                </a>

                </li>

                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="warehouse" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-building"></i>
                    <span class="m-menu__link-text">
                        Warehouse
                    </span>
                </a>

                </li>

                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="area" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-fort-awesome"></i>
                    <span class="m-menu__link-text">
                        Area
                    </span>
                </a>

                </li>
                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="material" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-sort-numeric-asc"></i>
                    <span class="m-menu__link-text">
                        Material
                    </span>
                </a>

                </li>
                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="product" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-tags"></i>
                    <span class="m-menu__link-text">
                        Product
                    </span>
                </a>

                </li>


                @php
                if($user->user_username=='admin')
                {
                @endphp
                <li class="m-menu__item " aria-haspopup="true" >
                <!--<nav class="navbar navbar-dark red lighten-1 mb-4">-->
                <a href="user" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-users"></i>
                    <span class="m-menu__link-text">
                        User
                    </span>
                </a>

                </li>
                @php
                }
                @endphp

            @php

            @endphp

            @foreach($menuData as $menu)
            <li class="m-menu__item " aria-haspopup="true" >
                <a href="{{ $menu['0'] }}" class="m-menu__link ">
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


