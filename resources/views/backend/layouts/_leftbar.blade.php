<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">MUTAN</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">BL</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
                <li class="active">
                    <a data-request="push" class="nav-link" href="{{ url(Config::get('gconfig.admin').'home') }}">
                        <i class="fas fa-home"></i><span>Dashboard</span>
                    </a>
                </li>
            {!! GMenuLibrary::build(4) !!}
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            {{-- <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a> --}}
        </div>
    </aside>
</div>
