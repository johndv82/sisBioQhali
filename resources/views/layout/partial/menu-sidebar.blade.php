<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="{{url('/')}}">
            <img src="{{asset('img/logo_bioqhali.jpg')}}" alt="BioQhali" width="120px"/>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">

                <!-- Mantenimiento -->
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-gears"></i>Mantenimiento</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li>
                            <a href="{{route('productos.index')}}">
                                <i class="fas fa-inbox"></i>Productos</a>
                        </li>
                        <li>
                            <a href="{{route('categorias.index')}}">
                                <i class="fas fa-tags"></i>Categorías</a>
                        </li>
                        <li>
                            <a href="{{route('membresias.index')}}">
                                <i class="fas fa-star"></i>Membresias</a>
                        </li>
                        <li>
                            <a href="{{route('clientes.index')}}">
                                <i class="fas fa-users"></i>Clientes</a>
                        </li>
                        <li>
                            <a href="{{route('proveedores.index')}}">
                                <i class="fas fa-user-md"></i>Proveedores</a>
                        </li>
                    </ul>
                </li>
                <!-- Ventas -->
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-dollar"></i>Ventas</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li>
                            <a href="{{route('ventas.create')}}"><i class="fas fa-plus-circle"></i>Nueva Venta</a>
                        </li>
                        <li>
                            <a href="{{route('ventas.index')}}"><i class="fas fa-file-text"></i>Consulta de Ventas</a>
                        </li>
                        <li>
                            <a href="{{route('acumulados.index')}}"><i class="fas fa-th"></i>Acumulados</a>
                        </li>
                    </ul>
                </li>
                <!-- Compras -->
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-shopping-cart"></i>Compras</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li>
                            <a href="{{route('compras.create')}}"><i class="fas fa-plus-circle"></i>Nueva Compra</a>
                        </li>
                        <li>
                            <a href="{{route('compras.index')}}"><i class="fas fa-file-text"></i>Consulta de Compras</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-file-excel"></i>Reportes</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
