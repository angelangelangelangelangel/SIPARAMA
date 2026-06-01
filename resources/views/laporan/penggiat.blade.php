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
    min-width:190px;
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
</style>

<div class="wrapper">

    <div class="page-title">
        Laporan Penggiat
    </div>

    <div class="page-subtitle">
        Rekap data penggiat
    </div>

    <form method="GET" action="/laporan/penggiat">

        <div class="filter-bar">

            <div class="form-group">
                <label>Cari</label>
                <input type="text"
                       name="search"
                       placeholder="Cari nama / instansi"
                       value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <label>Jenis Lembaga</label>
                <select name="jenis_instansi">
                    <option value="">Semua</option>
                    <option value="Lingkungan Pendidikan"
                        {{ request('jenis_instansi') == 'Lingkungan Pendidikan' ? 'selected' : '' }}>
                        Pendidikan
                    </option>
                    <option value="Lingkungan Masyarakat"
                        {{ request('jenis_instansi') == 'Lingkungan Masyarakat' ? 'selected' : '' }}>
                        Masyarakat
                    </option>
                    <option value="Lingkungan Swasta"
                        {{ request('jenis_instansi') == 'Lingkungan Swasta' ? 'selected' : '' }}>
                        Swasta
                    </option>
                    <option value="Lingkungan Pemerintah"
                        {{ request('jenis_instansi') == 'Lingkungan Pemerintah' ? 'selected' : '' }}>
                        Pemerintah
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-filter">
                Filter
            </button>

            <a href="/laporan/penggiat/print?search={{ request('search') }}&jenis_instansi={{ request('jenis_instansi') }}"
               target="_blank"
               class="btn btn-print">
                Print
            </a>

            <a href="/laporan/penggiat/excel?search={{ request('search') }}&jenis_instansi={{ request('jenis_instansi') }}"
               class="btn btn-excel">
                Excel
            </a>

            <a href="/laporan/penggiat/pdf?search={{ request('search') }}&jenis_instansi={{ request('jenis_instansi') }}"
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
                        <th>Nama Penggiat</th>
                        <th>Instansi</th>
                        <th>Jabatan</th>
                       <th>Jenis Instansi</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $item)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item->nama_penggiat }}
                                </td>

                                <td>
                                    {{ $item->instansi }}
                                </td>

                                <td>
                                    {{ $item->jabatan ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->jenis_instansi }}
                                </td>

                                <td>
                                    {{ $item->kategori_pendidikan ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->keterangan ?? '-' }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>

                            @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection