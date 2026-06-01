@extends('layouts.app')

@section('content')

<style>
.wrapper{
    padding:24px;
    background:#f8fafc;
    min-height:100vh;
}

.page-header{
    margin-bottom:24px;
}

.page-title{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:6px;
}

.page-subtitle{
    font-size:14px;
    color:#64748b;
}

.content-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 30px rgba(15,23,42,0.05);
    max-width:100%;
}

.filter-bar{
    padding:20px;
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:end;
    border-bottom:1px solid #e2e8f0;
}

.filter-group{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.filter-label{
    font-size:12px;
    font-weight:700;
    color:#475569;
}

.filter-input{
    height:42px;
    min-width:170px;
    padding:0 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:13px;
    outline:none;
}

.btn{
    height:42px;
    padding:0 16px;
    border:none;
    border-radius:12px;
    color:white;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
    text-decoration:none;
    display:flex;
    align-items:center;
    gap:8px;
}

.btn-filter{ background:#2563eb; }
.btn-print{ background:#16a34a; }
.btn-excel{ background:#ea580c; }
.btn-pdf{ background:#dc2626; }

.section-title{
    padding:18px 20px;
    background:#eff6ff;
    font-size:15px;
    font-weight:800;
    color:#1e3a8a;
    border-top:1px solid #e2e8f0;
}

.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#e2e8f0;
    padding:14px;
    font-size:12px;
    text-align:left;
    color:#334155;
    border-bottom:1px solid #e2e8f0;
    
}

table td{
    padding:14px;
    font-size:13px;
    vertical-align:top;
    border-bottom:1px solid #f1f5f9;
    color:#334155;
}

.total-box{
    padding:16px 20px;
    background:#f8fafc;
    font-size:13px;
    font-weight:700;
    color:#334155;
}

.empty-cell{
    text-align:center;
    color:#64748b;
    padding:20px;
}

@media(max-width:768px){
    .summary-grid{
        grid-template-columns:1fr;
    }

    @media print{

    body{
        background:white;
    }

    html, body{
    width:100%;
    height:auto;
}

    .filter-bar{
        display:none;
    }

    .wrapper{
        padding:0;
        background:white;
    }

    .content-card{
        box-shadow:none;
        border:none;
    }

}
}
</style>

<div class="wrapper">

    <div class="page-header">
        <div class="page-title">Laporan Test Urine</div>
        <div class="page-subtitle">Rekap laporan kegiatan test urine</div>
    </div>

    <div class="content-card">

        <form method="GET" action="/laporan/test-urine">

            <div class="filter-bar">

                <div class="filter-group">
                    <label class="filter-label">Cari</label>
                    <input type="text"
                        name="search"
                        class="filter-input"
                        placeholder="Pemerintah / Swasta / Pendidikan / Masyarakat"
                        value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Bulan</label>
                    <select name="bulan" class="filter-input">
                        <option value="">Semua</option>
                        @for($i=1;$i<=12;$i++)
                            <option value="{{ $i }}"
                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0,0,0,$i,1)) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Tahun</label>
                    <input type="number"
                           name="tahun"
                           class="filter-input"
                           value="{{ request('tahun') }}">
                </div>

                <button class="btn btn-filter" type="submit">
                    Filter
                </button>

                <a href="/laporan/test-urine/print?search={{ request('search') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
                        class="btn btn-print">
                            Print
                </a>

                <a href="/laporan/test-urine/excel?search={{ request('search') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
                    class="btn btn-excel">
                    Excel
                </a>

                <a href="/laporan/test-urine/pdf?search={{ request('search') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
                    target="_blank"
                    class="btn btn-pdf">
                    PDF
                </a>

            </div>

        </form>

        @php
            $sections = [
                'A. Lingkungan Pemerintah' => $pemerintah,
                'B. Lingkungan Swasta' => $swasta,
                'C. Lingkungan Pendidikan' => $pendidikan,
                'D. Lingkungan Masyarakat' => $masyarakat,
            ];
        @endphp

        @foreach($sections as $title => $items)

            <div class="section-title">
                {{ $title }}
            </div>

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Instansi</th>
                            <th>Tanggal</th>
                            <th>Sasaran</th>
                            <th>Tujuan Tes</th>
                            <th>Peserta</th>
                            <th>Reaktif</th>
                            <th>Non Reaktif</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($items->values() as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_instansi }}</td>
                            <td>{{ date('d M Y', strtotime($item->tanggal_kegiatan)) }}</td>
                            <td>{{ $item->sasaran }}</td>
                            <td>{{ $item->tujuan_test }}</td>
                            <td>{{ $item->peserta->count() }}</td>
                            <td>{{ $item->peserta->where('hasil','reaktif')->count() }}</td>
                            <td>{{ $item->peserta->where('hasil','non_reaktif')->count() }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty-cell">
                                Tidak ada data
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="total-box">
                Total Kegiatan: {{ $items->count() }}
                |
                Total Peserta:
                {{ $items->sum(function($x){ return $x->peserta->count(); }) }}
            </div>

        @endforeach

    </div>

</div>

@endsection