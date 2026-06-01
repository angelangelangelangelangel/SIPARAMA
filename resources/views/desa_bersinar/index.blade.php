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

.link-desa{
    color:#2563eb;
    font-weight:700;
    text-decoration:none;
}

.link-desa:hover{
    text-decoration:underline;
}

.action-cell{
    text-align:center;
    width:120px;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
    font-size:14px;
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

.modal.show{
    display:flex;
}

.modal-box{
    background:white;
    width:100%;
    max-width:760px;
    border-radius:20px;
    padding:24px;
    box-shadow:0 25px 60px rgba(15,23,42,0.18);
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:22px;
}

.modal-title{
    font-size:20px;
    font-weight:800;
    color:#0f172a;
}

.modal-close{
    width:40px;
    height:40px;
    border:none;
    background:#f8fafc;
    border-radius:12px;
    cursor:pointer;
}

.modal-form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.modal-form-grid input,
.modal-form-grid select,
.modal-form-grid textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    outline:none;
}

.modal-form-grid textarea{
    min-height:110px;
    resize:none;
}

.modal-form-grid .full{
    grid-column:span 2;
}

.modal-footer{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:22px;
}
</style>


<div class="page-header">
    <div class="page-title-wrap">
        <h1>Desa Bersinar</h1>
        <p>Kelola data desa bersinar SIPARAMA</p>
    </div>

    <button class="btn-add" onclick="openModal()">
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
                   placeholder="Cari desa / satker / status...">
        </div>

    </div>

</form>


<div class="table-card">

    <div class="table-wrap">

        <table class="data-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Satker</th>
                    <th>Nama Desa</th>
                    <th>Kab/Kota</th>
                    <th>Status Kerawanan</th>
                    <th>Jumlah Kegiatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                    @forelse($data as $item)

    <tr>

        <td>{{ $loop->iteration + ($data->firstItem() - 1) }}</td>

        <td>{{ $item->satker }}</td>

        <td>
            <a href="/desa-bersinar/{{ $item->slug }}"
             class="detail-link">
                {{ $item->nama_desa }}
            </a>
        </td>

        <td>{{ $item->kab_kota }}</td>

        <td>{{ $item->status_kerawanan }}</td>

        <td>{{ $item->detail_count }}</td>

        <td class="action-cell">

            <div style="display:flex; justify-content:center; gap:8px;">

                <button type="button"
                        onclick='editData(
                            "{{ $item->id }}",
                            @json($item->satker),
                            @json($item->kab_kota),
                            @json($item->nama_desa),
                            @json($item->jenis_wilayah),
                            @json($item->status_kerawanan),
                            @json($item->alasan_perhitungan),
                            @json($item->keterangan)
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

                <form action="/desa-bersinar/{{ $item->id }}" method="POST">
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
            Data desa bersinar tidak ditemukan
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

    <div class="modal-box">

        <div class="modal-header">

            <div class="modal-title" id="modalTitle">
                Tambah Desa Bersinar
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form id="formData"
              method="POST"
              action="/desa-bersinar">

            @csrf

            <input type="hidden"
                   name="_method"
                   id="methodField"
                   value="POST">

            <div class="modal-form-grid">

                <input type="text"
                       name="satker"
                       id="satker"
                       placeholder="Satker"
                       required>

                <input type="text"
                       name="kab_kota"
                       id="kab_kota"
                       placeholder="Kabupaten / Kota"
                       required>

                <input type="text"
                       name="nama_desa"
                       id="nama_desa"
                       placeholder="Nama Desa"
                       required>

                <select name="jenis_wilayah"
                        id="jenis_wilayah"
                        required>

                    <option value="">Pilih Jenis Wilayah</option>
                    <option value="Desa">Desa</option>
                    <option value="Kelurahan">Kelurahan</option>

                </select>

                <select name="status_kerawanan"
                        id="status_kerawanan"
                        required>

                    <option value="">Pilih Status Kerawanan</option>
                    <option value="Tinggi">Tinggi</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Rendah">Rendah</option>

                </select>

                <textarea name="alasan_perhitungan"
                          id="alasan_perhitungan"
                          class="full"
                          placeholder="Alasan Perhitungan"></textarea>

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

/* SEARCH */
const searchInput = document.getElementById('searchInput');

if(searchInput){
    searchInput.addEventListener('keyup', function(){

        clearTimeout(timer);

        timer = setTimeout(function(){
            document.getElementById('filterForm').submit();
        }, 500);

    });
}

/* FILTER */
function submitFilter(){
    document.getElementById('filterForm').submit();
}

/* MODAL */
function openModal(){

    document.getElementById('modalForm').classList.add('show');

    document.getElementById('modalTitle').innerHTML =
        'Tambah Desa Bersinar';

    document.getElementById('formData').action =
        '/desa-bersinar';

    document.getElementById('methodField').value =
        'POST';

    document.getElementById('formData').reset();
}

function closeModal(){
    document.getElementById('modalForm').classList.remove('show');
}

/* EDIT */
function editData(
    id,
    satker,
    kabkota,
    desa,
    wilayah,
    status,
    alasan,
    keterangan
){

    openModal();

    document.getElementById('modalTitle').innerHTML =
        'Edit Desa Bersinar';

    document.getElementById('formData').action =
        '/desa-bersinar/' + id;

    document.getElementById('methodField').value =
        'PUT';

    document.getElementById('satker').value =
        satker ?? '';

    document.getElementById('kab_kota').value =
        kabkota ?? '';

    document.getElementById('nama_desa').value =
        desa ?? '';

    document.getElementById('jenis_wilayah').value =
        wilayah ?? '';

    document.getElementById('status_kerawanan').value =
        status ?? '';

    document.getElementById('alasan_perhitungan').value =
        alasan ?? '';

    document.getElementById('keterangan').value =
        keterangan ?? '';
}

/* CLICK OUTSIDE */
document.addEventListener('click', function(e){

    if(e.target.id === 'modalForm'){
        closeModal();
    }

});

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