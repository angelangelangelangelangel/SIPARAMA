@extends('layouts.app')

@section('content')

<style>
.wrapper{
    font-family:Arial, Helvetica, sans-serif;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:24px;
    gap:20px;
    flex-wrap:wrap;
}

.page-title-wrap h1{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:6px;
    letter-spacing:-0.5px;
}

.page-title-wrap p{
    font-size:14px;
    color:#64748b;
}

/* TABLE CARD */
.table-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

/* TOOLBAR */
.toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    padding:20px;
    border-bottom:1px solid #e2e8f0;
    flex-wrap:wrap;
}

.search-wrapper{
    position:relative;
}

.search-wrapper i{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#94a3b8;
}

.search-wrapper input{
    width:320px;
    padding:12px 14px 12px 42px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    outline:none;
}

.search-wrapper input:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,0.08);
}

/* TABLE */
.table-wrap{
    overflow-x:auto;
}

.data-table{
    width:100%;
    border-collapse:collapse;
}

.data-table thead th{
    background:#eff6ff;
    color:#1e3a8a;
    font-size:13px;
    font-weight:800;
    padding:18px 22px;
    text-align:left;
    border-bottom:1px solid #cbd5e1;
    border-right:1px solid #dbeafe;
    white-space:nowrap;
}

.data-table thead th:last-child{
    border-right:none;
}

.data-table tbody td{
    padding:18px 22px;
    border-bottom:1px solid #e2e8f0;
    border-right:1px solid #f1f5f9;
    vertical-align:middle;
    font-size:14px;
    color:#334155;
}

.data-table tbody td:last-child{
    border-right:none;
}

.data-table tbody tr:hover{
    background:#f8fafc;
}

/* BADGES */
.badge-desa{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border-radius:999px;
    background:#eff6ff;
    color:#2563eb;
    font-size:13px;
    font-weight:700;
}

.badge-count{
    display:inline-block;
    padding:8px 12px;
    border-radius:999px;
    background:#ecfdf5;
    color:#15803d;
    font-size:12px;
    font-weight:700;
}

/* ACTION */
.btn-action{
    width:38px;
    height:38px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    background:#dbeafe;
    color:#2563eb;
}

/* EMPTY */
.empty-box{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
    font-size:14px;
}

@media(max-width:768px){

    .toolbar{
        flex-direction:column;
        align-items:stretch;
    }

    .search-wrapper input{
        width:100%;
    }

}
</style>

<div class="wrapper">

    <div class="page-header">

        <div class="page-title-wrap">

            <h1>Dokumentasi Desa Bersinar</h1>

            <p>
                Kelola dokumentasi kegiatan berdasarkan desa pelaksanaan
            </p>

        </div>

    </div>

    <div class="table-card">

        <div class="toolbar">

            <div class="search-wrapper">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text"
                       id="searchInput"
                       placeholder="Cari nama desa...">

            </div>

        </div>

        <div class="table-wrap">

            <table class="data-table">

               <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Wilayah</th>
                        <th>Nama Wilayah</th>
                        <th>Kabupaten / Kota</th>
                        <th>Jumlah Kegiatan</th>
                        <th>Aksi</th>
                </tr>
             </thead>

                <tbody>

                    @forelse($data as $index => $item)

                        <tr class="data-row">

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $item->jenis_wilayah }}
                            </td>

                            <td>

                                <span class="badge-desa">

                                    <i class="fa-solid fa-house"></i>

                                    {{ $item->nama_desa }}

                                </span>

                            </td>

                            <td>
                                {{ $item->kab_kota }}
                            </td>

                            <td>

                                <span class="badge-count">

                                    {{ $item->detail_count }} Kegiatan

                                </span>

                            </td>

                            <td>

                                <a href="/dokumentasi/desa-bersinar/{{ $item->id }}"
                                   class="btn-action">

                                    <i class="fa-solid fa-folder-open"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="empty-box">
                                    Belum ada data desa bersinar.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');

if(searchInput){

    searchInput.addEventListener('keyup', function(){

        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('.data-row');

        rows.forEach(row => {

            row.style.display =
                row.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';

        });

    });

}
</script>

@endsection