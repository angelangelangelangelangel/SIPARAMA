<!DOCTYPE html>
<html lang="id">
<head>
    <title>SIPARAMA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html,
        body{
            width:100%;
            min-height:100%;
            font-family:'Inter', sans-serif;
            background:#f8fafc;
            color:#0f172a;
        }

        body{
            display:flex;
        }

        a{
            text-decoration:none;
        }

        button{
            font-family:'Inter', sans-serif;
        }

        /* =========================
           SIDEBAR
        ========================== */
        .sidebar{
            width:270px;
            height:100vh;
            background:linear-gradient(180deg,#020617 0%, #0f172a 100%);
            position:fixed;
            top:0;
            left:0;
            overflow-y:auto;
            z-index:1000;
            border-right:1px solid rgba(255,255,255,0.05);
        }

        .sidebar::-webkit-scrollbar{
            width:5px;
        }

        .sidebar::-webkit-scrollbar-thumb{
            background:rgba(255,255,255,0.12);
            border-radius:20px;
        }

        .sidebar-header{
            height:78px;
            padding:0 20px;
            border-bottom:1px solid rgba(255,255,255,0.06);
            display:flex;
            align-items:center;
        }

        .brand{
            display:flex;
            align-items:center;
            width:100%;
        }

        .brand-logo{
            width:100px;
            height:100px;
            object-fit:contain;
            flex-shrink:0;
        }

        .brand-text{
            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .brand-title{
            font-size:24px;
            font-weight:800;
            color:white;
            line-height:1;
            letter-spacing:-0.5px;
        }

        .brand-subtitle{
            font-size:11px;
            color:#94a3b8;
            margin-top:4px;
            line-height:1.3;
        }

        .menu-section{
            padding:14px 14px 0;
        }

        .menu-title{
            color:#64748b;
            font-size:11px;
            font-weight:700;
            text-transform:uppercase;
            letter-spacing:1.3px;
            padding:12px 12px 10px;
        }

        .sidebar a,
        .dropdown-btn{
            width:100%;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:13px 14px;
            border:none;
            background:none;
            color:#cbd5e1;
            font-size:14px;
            font-weight:500;
            border-radius:14px;
            cursor:pointer;
            transition:.2s ease;
            margin-bottom:4px;
        }

        .sidebar a:hover,
        .dropdown-btn:hover{
            background:rgba(255,255,255,0.08);
            color:#ffffff;
        }

        .sidebar a.active{
            background:linear-gradient(135deg,#2563eb,#1d4ed8);
            color:white;
            font-weight:600;
            box-shadow:0 12px 25px rgba(37,99,235,0.28);
        }

        .dropdown-btn.active{
            background:rgba(255,255,255,0.08);
            color:white;
        }

        .menu-left{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .menu-icon{
            width:18px;
            text-align:center;
            font-size:14px;
        }

        .dropdown-arrow{
            font-size:12px;
            transition:.2s;
        }

        .dropdown-btn.active .dropdown-arrow{
            transform:rotate(180deg);
        }

        .dropdown-content{
            display:none;
            padding-left:12px;
            margin-top:2px;
            margin-bottom:8px;
        }

        .dropdown-content.show{
            display:block;
        }

        .dropdown-content a{
            padding:11px 14px;
            font-size:13px;
            border-radius:12px;
        }

        /* =========================
           MAIN
        ========================== */
        .main{
            margin-left:270px;
            width:calc(100% - 270px);
            min-height:100vh;
            background:#f8fafc;
        }

        /* TOGGLE SIDEBAR */
        .menu-toggle{
            width:44px;
            height:44px;
            border:none;
            background:#f8fafc;
            border:1px solid #e2e8f0;
            border-radius:12px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
            color:#334155;
            transition:.2s;
        }

        .menu-toggle:hover{
            background:#eef2ff;
            color:#2563eb;
        }

        /* COLLAPSE SIDEBAR */
        .sidebar{
            transition:.25s ease;
        }

        .main{
            transition:.25s ease;
        }

        .sidebar.collapsed{
            width:90px;
        }

        .sidebar.collapsed .brand-text{
            display:none;
        }

        .sidebar.collapsed .menu-title{
            display:none;
        }

        .sidebar.collapsed .menu-left{
            justify-content:center;
            width:100%;
            gap:0;
        }

        .sidebar.collapsed .menu-left i{
            font-size:16px;
        }

        .sidebar.collapsed .menu-left{
            font-size:0;
        }

        .sidebar.collapsed .dropdown-arrow{
            display:none;
        }

        .sidebar.collapsed .dropdown-content{
            display:none !important;
        }

        .sidebar.collapsed .brand{
            justify-content:center;
        }

        .sidebar.collapsed .brand-logo{
            width:60px;
            height:60px;
        }

        .main.expanded{
            margin-left:90px;
            width:calc(100% - 90px);
        }

        /*TOPBAR */
        .topbar{
            height:78px;
            background:#ffffff;
            border-bottom:1px solid #e2e8f0;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 28px;
            position:sticky;
            top:0;
            z-index:999;
        }

        /* =========================
           PROFILE
        ========================== */
        .profile-dropdown{
            position:relative;
        }

        .profile-btn{
            display:flex;
            align-items:center;
            gap:12px;
            background:transparent;
            border:none;
            padding:0;
            cursor:pointer;
        }

        .profile-btn:hover{
            opacity:.85;
        }

        .profile-avatar{
            width:44px;
            height:44px;
            border-radius:50%;
            background:#2563eb;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:16px;
            box-shadow:0 10px 20px rgba(37,99,235,0.18);
        }

        .profile-info{
            text-align:left;
        }

        .profile-name{
            font-size:14px;
            font-weight:700;
            color:#0f172a;
        }

        .profile-role{
            font-size:12px;
            color:#64748b;
            margin-top:2px;
        }

        .profile-menu{
            position:absolute;
            top:58px;
            right:0;
            width:220px;
            background:white;
            border:1px solid #e2e8f0;
            border-radius:16px;
            box-shadow:0 16px 35px rgba(15,23,42,0.12);
            padding:10px;
            display:none;
        }

        .profile-menu.show{
            display:block;
        }

        .profile-menu a,
        .profile-menu button{
            width:100%;
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px 14px;
            border:none;
            background:none;
            border-radius:12px;
            color:#334155;
            font-size:14px;
            cursor:pointer;
            text-align:left;
        }

        .profile-menu a:hover,
        .profile-menu button:hover{
            background:#f8fafc;
        }

        /* =========================
           CONTENT
        ========================== */
        .page-content{
            padding:8px 20px 20px 20px;
        }

        .breadcrumb-area{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
            margin-bottom:12px;
            font-size:14px;
            color:#94a3b8;
        }

        .breadcrumb-area a{
            color:#64748b;
        }

        .separator{
            font-size:11px;
            color:#cbd5e1;
        }

        .content-area{
            width:100%;
        }

        input,
        select,
        textarea{
            width:100%;
            padding:12px 14px;
            border:1px solid #dbe2ea;
            border-radius:12px;
            font-size:14px;
            font-family:'Inter', sans-serif;
            outline:none;
            background:white;
        }

        input:focus,
        select:focus,
        textarea:focus{
            border-color:#2563eb;
            box-shadow:0 0 0 4px rgba(37,99,235,0.08);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#f8fafc;
            color:#64748b;
            font-size:12px;
            font-weight:700;
        }

        td{
            color:#334155;
            font-size:14px;
        }

        th,
        td{
            padding:14px 16px;
        }

        .swal2-popup{
            border-radius:20px !important;
            font-family:'Inter', sans-serif !important;
        }

        @media(max-width:991px){
            .sidebar{
                width:250px;
            }

            .main{
                margin-left:250px;
                width:calc(100% - 250px);
            }
        }
    </style>
</head>

<body>

@php
    $role = auth()->check() ? auth()->user()->role->name : null;
@endphp

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="sidebar-header">

        <div class="brand">

            <img src="{{ asset('images/bnn-logo.png') }}"
                 alt="BNN Logo"
                 class="brand-logo">

            <div class="brand-text">

                <div class="brand-title">
                    SIPARAMA
                </div>

            </div>

        </div>

    </div>

    <!-- MAIN MENU -->
    <div class="menu-section">

        <div class="menu-title">
            Main Menu
        </div>

        <a href="/dashboard"
           class="{{ Request::is('dashboard') ? 'active' : '' }}">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-house"></i>
                </span>
                Dashboard
            </div>

        </a>

        <a href="/analytics"
           class="{{ Request::is('analytics') ? 'active' : '' }}">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
                Analytics
            </div>

        </a>

    </div>

    @if($role == 'Admin' || $role == 'Pegawai')

    <!-- DATA MASTER -->
    <div class="menu-section">

        <div class="menu-title">
            Data Master
        </div>

        <a href="/test-urine"
           class="{{ Request::is('test-urine*') ? 'active' : '' }}">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-vial"></i>
                </span>
                Test Urine
            </div>

        </a>

        <a href="/penyuluhan"
           class="{{ Request::is('penyuluhan*') ? 'active' : '' }}">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
                Penyuluhan
            </div>

        </a>

        <a href="/penggiat"
           class="{{ Request::is('penggiat*') ? 'active' : '' }}">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-users"></i>
                </span>
                Penggiat
            </div>

        </a>

        <a href="/desa-bersinar"
           class="{{ Request::is('desa-bersinar*') ? 'active' : '' }}">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-house-user"></i>
                </span>
                Desa Bersinar
            </div>

        </a>

    </div>
    @endif

    @if($role == 'Admin' || $role == 'Pegawai')

    <!-- DOKUMEN -->
    <div class="menu-section">

        <div class="menu-title">
            Dokumen
        </div>

        <button class="dropdown-btn {{ Request::is('dokumentasi*') ? 'active' : '' }}"
                id="dokDropdownBtn">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-folder-open"></i>
                </span>
                Dokumentasi
            </div>

            <span class="dropdown-arrow">
                <i class="fa-solid fa-chevron-down"></i>
            </span>

        </button>

        <div class="dropdown-content {{ Request::is('dokumentasi*') ? 'show' : '' }}"
             id="dokDropdown">

            <a href="/dokumentasi/test-urine">Test Urine</a>
            <a href="/dokumentasi/penyuluhan">Penyuluhan</a>
            <a href="/dokumentasi/desa-bersinar">Desa Bersinar</a>

        </div>

        @if($role == 'Admin')

        <button class="dropdown-btn {{ Request::is('laporan*') ? 'active' : '' }}"
                id="laporanDropdownBtn">

            <div class="menu-left">
                <span class="menu-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </span>
                Laporan
            </div>

            <span class="dropdown-arrow">
                <i class="fa-solid fa-chevron-down"></i>
            </span>

        </button>

        <div class="dropdown-content {{ Request::is('laporan*') ? 'show' : '' }}"
             id="laporanDropdown">

            <a href="/laporan/test-urine">Test Urine</a>
            <a href="/laporan/penyuluhan">Penyuluhan</a>
            <a href="/laporan/desa-bersinar">Desa Bersinar</a>
            <a href="/laporan/penggiat">Penggiat</a>

        </div>

        @endif

    </div>

    @endif

    @if($role == 'Admin')
<div class="menu-section">

    <div class="menu-title">
        System
    </div>

    <a href="/users"
       class="{{ Request::is('users*') ? 'active' : '' }}">

        <div class="menu-left">
            <span class="menu-icon">
                <i class="fa-solid fa-user-gear"></i>
            </span>
            Users
        </div>

    </a>

</div>
@endif

@if(auth()->check())
<div class="menu-section">

    <div class="menu-title">
        Informasi
    </div>

    <a href="/tentang-p2m"
       class="{{ Request::is('tentang-p2m') ? 'active' : '' }}">

        <div class="menu-left">
            <span class="menu-icon">
                <i class="fa-solid fa-circle-info"></i>
            </span>
            Tentang P2M
        </div>

    </a>

</div>
@endif

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

    <button class="menu-toggle" id="menuToggle">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="profile-dropdown">

            <button class="profile-btn" id="profileBtn">

                <div class="profile-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="profile-info">

                    <div class="profile-name">
                        {{ auth()->check() ? auth()->user()->name : 'User' }}
                    </div>

                    <div class="profile-role">
                        {{ $role }}
                    </div>

                </div>

                <i class="fa-solid fa-chevron-down"
                   style="font-size:12px; color:#64748b;"></i>

            </button>

            <div class="profile-menu" id="profileMenu">

                <form action="/logout"
                      method="POST"
                      id="logoutForm">

                    @csrf

                    <button type="submit">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="page-content">

        @if(!Request::is('dashboard'))

        <div class="breadcrumb-area">

            <a href="/dashboard">
                Dashboard
            </a>

            @php
                $segments = Request::segments();
                $skip = ['dashboard'];
                $url = '';
            @endphp

            @foreach($segments as $segment)

                @if(is_numeric($segment))
                    @continue
                @endif

                @if(!in_array($segment, $skip))

                    @php
                        $url .= '/' . $segment;
                        $label = ucwords(str_replace('-', ' ', $segment));
                    @endphp

                    <span class="separator">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>

                    @if($loop->last)
                            <span>{{ $label }}</span>
                        @else
                            @if($segment == 'dokumentasi' || $segment == 'laporan')
                                <span>{{ $label }}</span>
                            @else
                                <a href="{{ $url }}">
                                    {{ $label }}
                                </a>
                            @endif
                        @endif

                @endif

            @endforeach

        </div>

        @endif

        <div class="content-area">
            @yield('content')
        </div>

    </div>

</div>

<script>
/* DOKUMENTASI DROPDOWN */
const dokDropdownBtn = document.getElementById('dokDropdownBtn');
const dokDropdown = document.getElementById('dokDropdown');

if(dokDropdownBtn && dokDropdown){

    dokDropdownBtn.addEventListener('click', function(){

        dokDropdown.classList.toggle('show');
        dokDropdownBtn.classList.toggle('active');

    });

}

/*  LAPORAN DROPDOWN */
const laporanDropdownBtn = document.getElementById('laporanDropdownBtn');
const laporanDropdown = document.getElementById('laporanDropdown');

if(laporanDropdownBtn && laporanDropdown){

    laporanDropdownBtn.addEventListener('click', function(){

        laporanDropdown.classList.toggle('show');
        laporanDropdownBtn.classList.toggle('active');

    });

}

/* PROFILE DROPDOWN */
const profileBtn = document.getElementById('profileBtn');
const profileMenu = document.getElementById('profileMenu');

if(profileBtn && profileMenu){

    profileBtn.addEventListener('click', function(e){

        e.stopPropagation();
        profileMenu.classList.toggle('show');

    });

    profileMenu.addEventListener('click', function(e){

        e.stopPropagation();

    });

    document.addEventListener('click', function(e){

        if(
            !profileBtn.contains(e.target) &&
            !profileMenu.contains(e.target)
        ){
            profileMenu.classList.remove('show');
        }

    });

}

/* LOGOUT CONFIRM */
const logoutForm = document.getElementById('logoutForm');

if(logoutForm){

    logoutForm.addEventListener('submit', function(e){

        e.preventDefault();

        Swal.fire({
            title: 'Logout dari sistem?',
            text: 'Anda yakin ingin keluar dari SIPARAMA?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#94a3b8',
            background: '#ffffff',
            backdrop: 'rgba(15,23,42,0.55)',
            allowOutsideClick: false
        }).then((result) => {

            if(result.isConfirmed){
                logoutForm.submit();
            }

        });

    });

}

/* DELETE CONFIRM */
document.querySelectorAll('form').forEach(form => {

    const deleteMethod =
        form.querySelector('input[name="_method"][value="DELETE"]');

    if(!deleteMethod) return;

    form.addEventListener('submit', function(e){

        if(form.dataset.confirmed === 'true'){
            return;
        }

        e.preventDefault();

        let modul = 'Data';

        const action = form.getAttribute('action') || '';

        if(action.includes('/users')){
            modul = 'User';
        }
        else if(action.includes('/dokumentasi')){
            modul = 'Dokumentasi';
        }
        else if(action.includes('/test-urine')){
            modul = 'Data Test Urine';
        }
        else if(action.includes('/penyuluhan')){
            modul = 'Data Penyuluhan';
        }
        else if(action.includes('/penggiat')){
            modul = 'Data Penggiat';
        }
        else if(action.includes('/desa-bersinar')){
            modul = 'Data Desa Bersinar';
        }
        else if(action.includes('/detail-desa-bersinar')){
            modul = 'Kegiatan Desa Bersinar';
        }

        Swal.fire({
            title: 'Yakin hapus data?',
            text: modul + ' akan dihapus secara permanen dan tidak dapat dipulihkan kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#2563eb'
        }).then((result) => {

            if(result.isConfirmed){
                form.dataset.confirmed = 'true';
                form.submit();
            }

        });

    });

});

        /* SIDEBAR TOGGLE */
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const main = document.querySelector('.main');

        if(menuToggle){

            menuToggle.addEventListener('click', function(){

                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expanded');

            });

        }
</script>

</body>
</html>