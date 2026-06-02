@extends('layouts.app')

@section('content')

<style>
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

.btn-add{
    background:#16a34a;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:10px;
    transition:.2s;
}

.btn-add:hover{
    background:#15803d;
}

.btn-primary{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 16px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.btn-secondary{
    background:#64748b;
    color:white;
    border:none;
    padding:12px 16px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.btn-danger{
    background:#dc2626;
    color:white;
    border:none;
    padding:12px 16px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.toolbar-left{
    display:flex;
    align-items:center;
    gap:12px;
}

.toolbar select{
    padding:11px 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    background:white;
    outline:none;
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

.table-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

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

.detail-link{
    color:#2563eb;
    font-weight:700;
    text-decoration:none;
}

.detail-link:hover{
    text-decoration:underline;
}

.action{
    display:flex;
    gap:8px;
    align-items:center;
}

.btn-icon{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    border:none;
    cursor:pointer;
    border-radius:10px;
    transition:.2s;
}

.btn-edit{
    background:#0f766e;
}

.btn-delete{
    background:#dc2626;
}

.btn-icon:hover{
    transform:translateY(-1px);
}

.pagination-wrap{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 20px;
    flex-wrap:wrap;
    gap:14px;
}

.pagination-info{
    font-size:14px;
    color:#64748b;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
    font-size:14px;
}

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(15,23,42,0.55);
    z-index:9999;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.modal-content{
    background:white;
    width:720px;
    max-width:95%;
    max-height:90vh;
    overflow-y:auto;
    padding:25px;
    border-radius:20px;
    box-shadow:0 25px 60px rgba(15,23,42,0.18);
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:22px;
}

.modal-header h3{
    margin:0;
    font-size:20px;
    font-weight:800;
    color:#0f172a;
}

.close{
    width:40px;
    height:40px;
    border:none;
    background:#f8fafc;
    border-radius:12px;
    cursor:pointer;
    font-size:18px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.form-grid input,
.form-grid select,
.form-grid textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    box-sizing:border-box;
    font-size:14px;
    outline:none;
}

.form-grid textarea{
    min-height:110px;
    resize:none;
}

.full{
    grid-column:span 2;
}

.modal-footer{
    margin-top:20px;
    display:flex;
    justify-content:flex-end;
    gap:12px;
}

@media(max-width:768px){

    .toolbar{
        flex-direction:column;
        align-items:stretch;
    }

    .search-wrapper input{
        width:100%;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full{
        grid-column:span 1;
    }
}
</style>

<div class="page-header">
    <div class="page-title-wrap">
        <h1>Penyuluhan</h1>
        <p>Kelola data kegiatan penyuluhan SIPARAMA</p>
    </div>

    <button type="button"
            onclick="openModal()"
            class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Tambah Data
    </button>
</div>

<form method="GET" id="filterForm">

    <div class="toolbar">

        <div class="toolbar-left">

            <select name="rows" onchange="submitFilter()">
                <option value="10" {{ $rows == 10 ? 'selected' : '' }}>Show 10</option>
                <option value="25" {{ $rows == 25 ? 'selected' : '' }}>Show 25</option>
                <option value="50" {{ $rows == 50 ? 'selected' : '' }}>Show 50</option>
            </select>

        </div>

        <div class="search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input type="text"
                   name="search"
                   id="searchInput"
                   value="{{ $search }}"
                   placeholder="Cari tempat / sasaran...">
        </div>

    </div>

</form>

<div class="table-card">
    <div class="table-wrap">
        <table class="data-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Tempat</th>
                    <th>Jenis Media</th>
                    <th>Instansi</th>
                    <th>Sasaran</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data as $item)

    @php
        $mediaList = $item->detail
            ->pluck('jenis_media')
            ->unique()
            ->implode(', ');
    @endphp

    <tr>

        <td>
            {{ $loop->iteration + ($data->firstItem() - 1) }}
        </td>

        <td>
            {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}
        </td>

        <td>
            <a href="/penyuluhan/{{ $item->slug }}"
               class="detail-link">
                {{ $item->nama_tempat }}
            </a>
        </td>

        <td>
            {{ $mediaList ?: '-' }}
        </td>

        <td style="font-weight:600;">
            {{ $item->jenis_instansi }}
        </td>

        <td>
            {{ $item->sasaran }}
        </td>

        <td>{{ $item->keterangan ?: '-' }}</td>

        <td class="action-cell">

            <div style="display:flex; justify-content:center; gap:8px;">

                <button type="button"
                       onclick='editData(
                                "{{ $item->id }}",
                                @json($item->tanggal_kegiatan),
                                @json($item->nama_tempat),
                                @json($item->jenis_instansi),
                                @json($item->kategori_pendidikan),
                                @json($item->sasaran),
                                @json($item->jumlah_sebaran),
                                @json($item->keterangan),

                                @json(optional($item->detail->first())->jenis_media),
                                @json(optional($item->detail->first())->jenis_kegiatan),
                                @json(optional($item->detail->first())->jumlah_paket)
                            )'
                        style="
                            width:38px;
                            height:38px;
                            border:none;
                            border-radius:10px;
                            background:#dbeafe;
                            color:#2563eb;
                            cursor:pointer;
                        ">
                    <i class="fa-solid fa-pen"></i>
                </button>

                <form action="/penyuluhan/{{ $item->id }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="
                                width:38px;
                                height:38px;
                                border:none;
                                border-radius:10px;
                                background:#fee2e2;
                                color:#dc2626;
                                cursor:pointer;
                            ">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>

            </div>

        </td>

    </tr>

@empty

    <tr>
        <td colspan="7" class="empty-state">
            Data penyuluhan tidak ditemukan
        </td>
    </tr>

@endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrap">

        <div class="pagination-info">
            Showing {{ $data->firstItem() ?? 0 }}–{{ $data->lastItem() ?? 0 }}
            of {{ $data->total() }} results
        </div>

        <div style="display:flex; gap:8px; align-items:center;">

            @if ($data->onFirstPage())
                <span style="
                    padding:10px 14px;
                    border:1px solid #dbe2ea;
                    background:#f8fafc;
                    color:#94a3b8;
                    border-radius:10px;
                    font-size:14px;
                    font-weight:600;
                ">
                    Previous
                </span>
            @else
                <a href="{{ $data->previousPageUrl() }}" style="
                    padding:10px 14px;
                    border:1px solid #dbe2ea;
                    background:white;
                    color:#334155;
                    text-decoration:none;
                    border-radius:10px;
                    font-size:14px;
                    font-weight:600;
                ">
                    Previous
                </a>
            @endif

            @for ($i = 1; $i <= $data->lastPage(); $i++)
                <a href="{{ $data->url($i) }}" style="
                    padding:10px 14px;
                    border:1px solid #dbe2ea;
                    background:{{ $data->currentPage() == $i ? '#2563eb' : 'white' }};
                    color:{{ $data->currentPage() == $i ? 'white' : '#334155' }};
                    text-decoration:none;
                    border-radius:10px;
                    font-size:14px;
                    font-weight:700;
                ">
                    {{ $i }}
                </a>
            @endfor

            @if ($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" style="
                    padding:10px 14px;
                    border:1px solid #dbe2ea;
                    background:white;
                    color:#334155;
                    text-decoration:none;
                    border-radius:10px;
                    font-size:14px;
                    font-weight:600;
                ">
                    Next
                </a>
            @else
                <span style="
                    padding:10px 14px;
                    border:1px solid #dbe2ea;
                    background:#f8fafc;
                    color:#94a3b8;
                    border-radius:10px;
                    font-size:14px;
                    font-weight:600;
                ">
                    Next
                </span>
            @endif

        </div>

    </div>

</div>

<!-- MODAL -->
<div class="modal" id="modalForm">

    <div class="modal-content">

        <div class="modal-header">

            <h3 id="modalTitle">
                Tambah Penyuluhan
            </h3>

            <button type="button"
                    class="close"
                    onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form id="formData"
              method="POST"
              action="/penyuluhan">

            @csrf

            <input type="hidden"
                   name="_method"
                   id="methodField"
                   value="POST">

            <div class="form-grid">

                <input type="date"
                       name="tanggal_kegiatan"
                       id="tanggal_kegiatan"
                       required>

                <input type="text"
                       name="nama_tempat"
                       id="nama_tempat"
                       placeholder="Nama Tempat"
                       required>

                <select name="jenis_instansi"
                        id="jenis_instansi"
                        onchange="toggleKategori()"
                        required>

                    <option value="">Pilih Instansi</option>
                    <option value="Lingkungan Pemerintah">Lingkungan Pemerintah</option>
                    <option value="Lingkungan Swasta">Lingkungan Swasta</option>
                    <option value="Lingkungan Masyarakat">Lingkungan Masyarakat</option>
                    <option value="Lingkungan Pendidikan">Lingkungan Pendidikan</option>

                </select>

                <select name="kategori_pendidikan"
                        id="kategori_pendidikan"
                        style="display:none;">

                    <option value="">Kategori Pendidikan</option>
                    <option value="Sekolah">Sekolah</option>
                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>

                </select>

                <input type="text"
                       name="sasaran"
                       id="sasaran"
                       placeholder="Sasaran"
                       required>

                <input type="number"
                       name="jumlah_sebaran"
                       id="jumlah_sebaran"
                       placeholder="Jumlah Sebaran"
                       required>

                       <select name="jenis_media"
                        id="jenis_media"
                        required>

                    <option value="">Pilih Jenis Media</option>
                    <option value="Konvensional">Konvensional</option>
                    <option value="Cetak">Cetak</option>
                    <option value="Penyiaran">Penyiaran</option>
                    <option value="Online">Online</option>

                </select>

                <input type="text"
                    name="jenis_kegiatan"
                    id="jenis_kegiatan"
                    placeholder="Jenis Kegiatan"
                    required>

                <input type="number"
                    name="jumlah_paket"
                    id="jumlah_paket"
                    placeholder="Jumlah Paket"
                    required>

                <textarea name="keterangan"
                          id="keterangan"
                          class="full"
                          placeholder="Keterangan"></textarea>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-primary">
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

<script>
let timer;

/* FILTER */
function submitFilter(){
    document.getElementById('filterForm').submit();
}

/* AUTO SEARCH */
const searchInput = document.getElementById('searchInput');

if(searchInput){
    searchInput.addEventListener('keyup', function(){

        clearTimeout(timer);

        timer = setTimeout(function(){
            submitFilter();
        }, 500);

    });
}

/* MODAL */
function openModal(){

    document.getElementById('modalForm').style.display = 'flex';

    document.getElementById('modalTitle').innerHTML = 'Tambah Penyuluhan';

    document.getElementById('formData').action = '/penyuluhan';

    document.getElementById('methodField').value = 'POST';

    document.getElementById('formData').reset();

    document.getElementById('kategori_pendidikan').style.display = 'none';
}

function closeModal(){
    document.getElementById('modalForm').style.display = 'none';
}

/* KATEGORI */
function toggleKategori(){

    let instansi = document.getElementById('jenis_instansi').value;
    let kategori = document.getElementById('kategori_pendidikan');

    if(instansi === 'Lingkungan Pendidikan'){
        kategori.style.display = 'block';
        kategori.required = true;
    }else{
        kategori.style.display = 'none';
        kategori.required = false;
        kategori.value = '';
    }
}

/* EDIT */
function editData(
    id,
    tanggal,
    tempat,
    instansi,
    kategori,
    sasaran,
    jumlah,
    keterangan,
    jenis_media,
    jenis_kegiatan,
    jumlah_paket
){

    openModal();

    document.getElementById('modalTitle').innerHTML = 'Edit Penyuluhan';

    document.getElementById('formData').action = '/penyuluhan/' + id;

    document.getElementById('methodField').value = 'PUT';

    document.getElementById('tanggal_kegiatan').value = tanggal;
    document.getElementById('nama_tempat').value = tempat;
    document.getElementById('jenis_instansi').value = instansi;

    toggleKategori();

    document.getElementById('kategori_pendidikan').value = kategori ?? '';
    document.getElementById('sasaran').value = sasaran ?? '';
    document.getElementById('jumlah_sebaran').value = jumlah ?? '';
    document.getElementById('keterangan').value = keterangan ?? '';
    document.getElementById('jenis_media').value = jenis_media ?? '';
    document.getElementById('jenis_kegiatan').value = jenis_kegiatan ?? '';
    document.getElementById('jumlah_paket').value = jumlah_paket ?? '';
}

/* CLICK OUTSIDE */
window.onclick = function(event){

    let modal = document.getElementById('modalForm');

    if(event.target == modal){
        closeModal();
    }
}

/* ALERT */
@if(session('success'))
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:'{{ session('success') }}',
    confirmButtonColor:'#2563eb'
});
@endif

@if(session('error'))
Swal.fire({
    icon:'error',
    title:'Gagal',
    text:'{{ session('error') }}',
    confirmButtonColor:'#dc2626'
});
@endif

@if($errors->any())
Swal.fire({
    icon:'error',
    title:'Validasi Gagal',
    text:'{{ $errors->first() }}',
    confirmButtonColor:'#dc2626'
});
@endif
</script>

@endsection