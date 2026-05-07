<nav class="navbar navbar-expand-lg px-3 py-3" style="background-color: #336F97;">
    <div class="container-fluid flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <img src="/logo_bps.png" alt="Logo" width="60" class="img-fluid">
            <div class="text-white small">
                <strong>Badan Pusat Statistik</strong><br>
                <strong>Provinsi Kalimantan Selatan</strong><br>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto mt-2 mt-lg-0">
            <div class="text-end text-white small me-2">
                <div id="time"></div>
                <div id="date"></div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light btn-sm rounded-pill d-flex align-items-center gap-2 px-3 py-2">
                    <img src="/logout.png" width="18" class="img-fluid">
                    <span class="d-none d-sm-inline">Log Out</span>
                </button>
            </form>
        </div>
    </div>
</nav>