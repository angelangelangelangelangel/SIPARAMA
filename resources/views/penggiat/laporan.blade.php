@extends('layouts.app')

@section('content')

<h2>Laporan Penggiat</h2>

<button onclick="window.print()">Cetak</button>
<a href="/laporan/penggiat/print" target="_blank" class="btn btn-success">
    Cetak
</a>

<br><br>

<!-- STYLE KHUSUS LAPORAN -->
<style>
table {
    width:100% !important;
    border-collapse: collapse !important;
    background: white !important;
}

table th, table td {
    border:1px solid black !important;
    padding:8px !important;
    text-align:center;
}

table th {
    background:#f2f2f2 !important;
    color:black !important;
    font-weight:bold;
}

td {
    height:35px;
}

/* KHUSUS PRINT */
@media print {
    button, .btn {
        display:none;
    }

    body {
        margin:0;
    }

    table {
        font-size:12px;
    }
}
</style>

<table>
    <tr>
        <th>No</th>
        <th>Nama Penggiat</th>
        <th>Instansi</th>
        <th>Jabatan</th>
        <th>Pendidikan</th>
        <th>Masyarakat</th>
        <th>Swasta</th>
        <th>Pemerintah</th>
        <th>Keterangan</th>
    </tr>

    @foreach($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_penggiat }}</td>
        <td>{{ $item->instansi }}</td>
        <td>{{ $item->jabatan }}</td>

        <td>{{ $item->lembaga == 'Pendidikan' ? '✔' : '' }}</td>
        <td>{{ $item->lembaga == 'Masyarakat' ? '✔' : '' }}</td>
        <td>{{ $item->lembaga == 'Swasta' ? '✔' : '' }}</td>
        <td>{{ $item->lembaga == 'Pemerintah' ? '✔' : '' }}</td>

        <td>{{ $item->keterangan }}</td>
    </tr>
    @endforeach
</table>

@endsection