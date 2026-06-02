@extends('layouts.app')

@section('content')

<style>
.dashboard-wrapper{
    padding:8px 0 0 0;
    background:transparent;
    min-height:auto;
}

.dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:22px;
    padding:0 4px;
}

.dashboard-header h1{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin:0 0 6px 0;
    letter-spacing:-0.5px;
}

.dashboard-header p{
    margin:0;
    font-size:14px;
    color:#64748b;
}

.dashboard-date{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:12px 16px;
    font-size:13px;
    font-weight:700;
    color:#2563eb;
    display:flex;
    align-items:center;
    gap:10px;
    box-shadow:0 4px 14px rgba(15,23,42,0.04);
}

/* SUMMARY */
.summary-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
    margin-bottom:20px;
}

.summary-card{
    background:#ffffff;
    border:1px solid #edf2f7;
    border-radius:20px;
    padding:20px;
    box-shadow:0 4px 18px rgba(15,23,42,0.04);
}

.summary-top{
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:16px;
}

.summary-icon{
    width:58px;
    height:58px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    flex-shrink:0;
}

.icon-blue{
    background:#edf4ff;
    color:#2563eb;
}

.icon-orange{
    background:#fff7ed;
    color:#ea580c;
}

.icon-green{
    background:#ecfdf5;
    color:#16a34a;
}

.icon-purple{
    background:#faf5ff;
    color:#9333ea;
}

.summary-title{
    font-size:15px;
    font-weight:700;
    color:#334155;
}

.summary-value{
    font-size:36px;
    font-weight:800;
    color:#0f172a;
    line-height:1;
}

.summary-sub{
    font-size:13px;
    color:#94a3b8;
    margin-top:8px;
}

/* GRID */
.top-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:16px;
    margin-bottom:16px;
}

/* PANEL */
.panel{
    background:#ffffff;
    border:1px solid #edf2f7;
    border-radius:20px;
    box-shadow:0 4px 18px rgba(15,23,42,0.04);
    overflow:hidden;
}

.panel-header{
    padding:22px 22px 14px;
    font-size:16px;
    font-weight:800;
    color:#0f172a;
}

/* TABLE */
.activity-table-wrap{
    padding:0 18px 18px;
}

.activity-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

.activity-table thead th{
    background:#f8fafc;
    color:#64748b;
    font-size:12px;
    font-weight:700;
    padding:14px 16px;
    text-align:left;
}

.activity-table thead th:first-child{
    border-top-left-radius:12px;
    border-bottom-left-radius:12px;
}

.activity-table thead th:last-child{
    border-top-right-radius:12px;
    border-bottom-right-radius:12px;
}

.activity-table tbody td{
    padding:18px 16px;
    border-bottom:1px solid #f1f5f9;
    font-size:14px;
    color:#334155;
    vertical-align:middle;
}

.activity-table tbody tr:last-child td{
    border-bottom:none;
}

.activity-name{
    display:flex;
    align-items:center;
    gap:14px;
    min-width:260px;
}

.activity-icon{
    width:40px;
    height:40px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    flex-shrink:0;
}

.activity-title{
    font-size:14px;
    font-weight:700;
    color:#0f172a;
    line-height:1.4;
}

/* REKAP */
.rekap-wrap{
    padding:0 18px 18px;
}

.rekap-box{
    border-radius:16px;
    padding:18px 18px;
    margin-bottom:16px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
}

.rekap-box:last-child{
    margin-bottom:0;
}

.rekap-left{
    display:flex;
    align-items:flex-start;
    gap:14px;
}

.rekap-icon{
    width:46px;
    height:46px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    flex-shrink:0;
}

.rekap-title{
    font-size:15px;
    font-weight:700;
    margin-bottom:4px;
}

.rekap-sub{
    font-size:12px;
    color:#64748b;
}

.rekap-value{
    font-size:24px;
    font-weight:800;
    color:#0f172a;
}

.rekap-blue{
    background:#f3f8ff;
}

.rekap-green{
    background:#f0fbf4;
}

.rekap-red{
    background:#fff4f4;
}

/* SYSTEM ACTIVITY */
.system-wrap{
    padding:8px 22px 22px;
}

.system-item{
    position:relative;
    display:flex;
    justify-content:space-between;
    gap:20px;
    padding:16px 0 16px 56px;
    border-bottom:1px solid #f1f5f9;
}

.system-item:last-child{
    border-bottom:none;
}

.system-line{
    position:absolute;
    left:20px;
    top:0;
    bottom:0;
    width:2px;
    background:#e2e8f0;
}

.system-dot{
    position:absolute;
    left:0;
    top:16px;
    width:40px;
    height:40px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
    z-index:2;
}

.system-title{
    font-size:14px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:4px;
    line-height:1.5;
}

.system-meta{
    font-size:13px;
    color:#64748b;
}

.system-time{
    font-size:13px;
    color:#64748b;
    white-space:nowrap;
    flex-shrink:0;
}

/* RESPONSIVE */
@media(max-width:1200px){
    .summary-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .top-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){
    .dashboard-header{
        flex-direction:column;
        align-items:flex-start;
        gap:16px;
    }

    .summary-grid{
        grid-template-columns:1fr;
    }

    .dashboard-wrapper{
        padding:14px;
    }
}
</style>

<div class="dashboard-wrapper">

    <div class="dashboard-header">

    <div>
        <h1>Dashboard</h1>
        <p>
            Sistem Informasi Kegiatan Pencegahan dan Pemberdayaan Masyarakat
        </p>
    </div>

    <div class="dashboard-date">
        <i class="fa-regular fa-calendar"></i>
        {{ date('d F Y') }}
    </div>

</div>

    <!-- SUMMARY -->
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon icon-blue">
                    <i class="fa-solid fa-vial"></i>
                </div>
                <div>
                    <div class="summary-title">Test Urine</div>
                    <div class="summary-value">{{ $total_test_urine }}</div>
                    <div class="summary-sub">Total kegiatan</div>
                </div>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon icon-orange">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <div class="summary-title">Penyuluhan</div>
                    <div class="summary-value">{{ $total_penyuluhan }}</div>
                    <div class="summary-sub">Total kegiatan</div>
                </div>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon icon-green">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="summary-title">Penggiat</div>
                    <div class="summary-value">{{ $total_penggiat }}</div>
                    <div class="summary-sub">Total data</div>
                </div>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-top">
                <div class="summary-icon icon-purple">
                    <i class="fa-solid fa-house"></i>
                </div>
                <div>
                    <div class="summary-title">Desa Bersinar</div>
                    <div class="summary-value">{{ $total_desa_bersinar }}</div>
                    <div class="summary-sub">Total wilayah</div>
                </div>
            </div>
        </div>

    </div>

    <!-- TOP GRID -->
    <div class="top-grid">

        <!-- KEGIATAN TERBARU -->
        <div class="panel">
            <div class="panel-header">
                Kegiatan Terbaru
            </div>

            <div class="activity-table-wrap">
                <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Nama Instansi</th>
                                <th>Modul</th>
                                <th>Tanggal</th>
                                <th>Sasaran</th>
                            </tr>
                        </thead>

                    <tbody>
                        @forelse($recent_activities as $item)

                        <tr>
                            <td>
                                <div class="activity-name">

                                    @php
                                        $icon = 'fa-file';
                                        $bg = '#f1f5f9';
                                        $color = '#64748b';

                                        if($item['modul'] == 'Test Urine'){
                                            $icon = 'fa-vial';
                                            $bg = '#edf4ff';
                                            $color = '#2563eb';
                                        }

                                        if($item['modul'] == 'Penyuluhan'){
                                            $icon = 'fa-users';
                                            $bg = '#ecfdf5';
                                            $color = '#16a34a';
                                        }

                                        if($item['modul'] == 'Desa Bersinar'){
                                            $icon = 'fa-house';
                                            $bg = '#faf5ff';
                                            $color = '#9333ea';
                                        }
                                    @endphp

                                    <div class="activity-icon"
                                        style="
                                            background:{{ $bg }};
                                            color:{{ $color }};
                                        ">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>

                                    <div class="activity-title">
                                        {{ $item['nama'] }}
                                    </div>
                                </div>
                            </td>

                            <td>{{ $item['modul'] }}</td>

                            <td>
                                {{ date('d M Y', strtotime($item['tanggal'])) }}
                            </td>

                            <td>{{ $item['sasaran'] ?? '-' }}
                            </td>
                        </tr>

                        @empty

                        <tr>
                           <td colspan="4" style="text-align:center;">
                                Belum ada data
                            </td>
                        </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        <!-- REKAP -->
        <div class="panel">
            <div class="panel-header">
                Rekap Test Urine
            </div>

            <div class="rekap-wrap">

                <div class="rekap-box rekap-blue">
                    <div class="rekap-left">
                        <div class="rekap-icon" style="color:#2563eb;">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>
                            <div class="rekap-title" style="color:#2563eb;">
                                Total Diperiksa
                            </div>
                        </div>
                    </div>

                    <div class="rekap-value">
                        {{ number_format($total_diperiksa, 0, ',', '.') }}
                    </div>
                </div>

                <div class="rekap-box rekap-green">
                    <div class="rekap-left">
                        <div class="rekap-icon" style="color:#16a34a;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div>
                            <div class="rekap-title" style="color:#16a34a;">
                                Non Reaktif
                            </div>

                            <div class="rekap-sub">
                                {{ $persen_negatif }}% dari total diperiksa
                            </div>
                        </div>
                    </div>

                    <div class="rekap-value">
                        {{ number_format($total_negatif, 0, ',', '.') }}
                    </div>
                </div>

                <div class="rekap-box rekap-red">
                    <div class="rekap-left">
                        <div class="rekap-icon" style="color:#ef4444;">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>

                        <div>
                            <div class="rekap-title" style="color:#ef4444;">
                                Reaktif
                            </div>

                            <div class="rekap-sub">
                                {{ $persen_positif }}% dari total diperiksa
                            </div>
                        </div>
                    </div>

                    <div class="rekap-value">
                        {{ number_format($total_positif, 0, ',', '.') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
@if(auth()->user()->role->name == 'Admin')

<!-- ACTIVITY SYSTEM -->
<div class="panel">
    <div class="panel-header">
        Aktivitas Sistem
    </div>

    <div class="system-wrap">

        @forelse($system_logs as $log)

        <div class="system-item">

            <div class="system-line"></div>

            @php
                $icon = 'fa-file';
                $bg = '#f1f5f9';
                $color = '#64748b';

                if($log->modul == 'Test Urine'){
                    $icon = 'fa-vial';
                    $bg = '#edf4ff';
                    $color = '#2563eb';
                }

                if($log->modul == 'Penyuluhan'){
                    $icon = 'fa-users';
                    $bg = '#ecfdf5';
                    $color = '#16a34a';
                }

                if($log->modul == 'Desa Bersinar'){
                    $icon = 'fa-house';
                    $bg = '#faf5ff';
                    $color = '#9333ea';
                }

                if($log->modul == 'Penggiat'){
                    $icon = 'fa-users';
                    $bg = '#ecfdf5';
                    $color = '#16a34a';
                }
            @endphp

            <div class="system-dot"
                style="
                    background:{{ $bg }};
                    color:{{ $color }};
                ">
                <i class="fa-solid {{ $icon }}"></i>
            </div>

            <div style="flex:1;">
                <div class="system-title">
                    {{ $log->aktivitas }}
                </div>

                <div class="system-meta">
                    oleh {{ $log->user->name ?? 'Admin' }}
                </div>
            </div>

            <div class="system-time">
                {{ $log->created_at->diffForHumans() }}
            </div>

        </div>

        @empty

        <div style="padding:20px;color:#64748b;">
            Belum ada aktivitas sistem
        </div>

        @endforelse

    </div>
</div>

@endif
</div>

@endsection