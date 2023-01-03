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
                <li>
                    <a href="{{route('productos.index')}}">
                        <i class="fas fa-box"></i>Productos</a>
                </li>
                <li>
                    <a href="{{route('categorias.index')}}">
                        <i class="fas fa-box"></i>Categorias</a>
                </li>

                <!-- Mantenimiento -->
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-gears"></i>Mantenimiento</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li>
                            <a href="#"><i class="fas fa-gear"></i>Estado Civil</a>
                        </li>
                    </ul>
                </li>
                <!-- Ubigeo -->
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-qrcode"></i>Ubigeo</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li>
                            <a href="#"><i class="fas fa-map"></i>Paises</a>
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
