@extends('layouts.app')

@section('content')

<style>
.wrapper{
    padding:24px;
    background:#f8fafc;
    min-height:100vh;
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
    margin-bottom:24px;
}

.content-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 30px rgba(15,23,42,0.05);
}

.filter-bar{
    padding:20px;
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:end;
    border-bottom:1px solid #e2e8f0;
}

.form-group{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.form-group label{
    font-size:12px;
    font-weight:700;
    color:#475569;
}

.form-group input,
.form-group select{
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

.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f8fafc;
    padding:14px;
    font-size:12px;
    text-align:left;
    color:#334155;
    border-bottom:1px solid #e2e8f0;
    white-space:nowrap;
}

table td{
    padding:14px;
    font-size:13px;
    border-bottom:1px solid #f1f5f9;
    color:#334155;
    vertical-align:top;
}

tbody tr:hover{
    background:#f8fafc;
}

.empty-cell{
    text-align:center;
    color:#64748b;
    padding:20px;
}

.kegiatan-list{
    line-height:1.8;
    min-width:420px;
}
</style>

<div class="wrapper">

    <div class="page-title">
        Laporan Desa Bersinar
    </div>

    <div class="page-subtitle">
        Rekap data desa bersinar
    </div>

    <form method="GET" action="/laporan/desa-bersinar">

        <div class="filter-bar">

            <div class="form-group">
                <label>Cari</label>
                <input type="text"
                       name="search"
                       placeholder="Desa atau Kelurahan"
                       value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label>Bulan</label>
                <select name="bulan">
                    <option value="">Semua</option>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0,0,0,$i,1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Tahun</label>
                <input type="number"
                       name="tahun"
                       value="{{ request('tahun') }}"
                       placeholder="2026">
            </div>

            <button type="submit" class="btn btn-filter">
                Filter
            </button>

            <a href="/laporan/desa-bersinar/print?search={{ request('search') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
               target="_blank"
               class="btn btn-print">
                Print
            </a>

            <a href="/laporan/desa-bersinar/excel?search={{ request('search') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
               class="btn btn-excel">
                Excel
            </a>

            <a href="/laporan/desa-bersinar/pdf?search={{ request('search') }}&bulan={{ request('bulan') }}&tahun={{ request('tahun') }}"
               target="_blank"
               class="btn btn-pdf">
                PDF
            </a>

        </div>

    </form>

    <div class="content-card">

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Satker</th>
                        <th>Nama Desa Bersinar</th>
                        <th>Jumlah</th>
                        <th>Status Kerawanan</th>
                        <th>Alasan Perhitungan</th>
                        <th>Kegiatan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->satker }}</td>
                            <td>{{ $item->nama_desa }}</td>
                            <td>1</td>
                            <td>{{ $item->status_kerawanan }}</td>
                            <td>{{ $item->alasan_perhitungan ?? '-' }}</td>

                            <td class="kegiatan-list">
                                @forelse($item->detail as $detail)
                                    {{ $loop->iteration }}.
                                    {{ $detail->kegiatan }}
                                    <br>
                                @empty
                                    -
                                @endforelse
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-cell">
                                Data tidak tersedia
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection