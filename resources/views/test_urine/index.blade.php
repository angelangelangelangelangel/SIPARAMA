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

.instansi-link{
    color:#2563eb;
    font-weight:700;
    text-decoration:none;
}

.instansi-link:hover{
    text-decoration:underline;
}

.action-cell{
    position:relative;
    text-align:center;
    width:90px;
}

.action-btn{
    width:40px;
    height:40px;
    border:none;
    background:white;
    border:1px solid #e2e8f0;
    border-radius:10px;
    cursor:pointer;
    transition:.2s;
}

.action-btn:hover{
    background:#f8fafc;
}

.action-menu{
    position:absolute;
    right:100%;
    top:0;
    margin-right:10px;
    width:220px;
    background:white;
    border:1px solid #e2e8f0;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(15,23,42,0.12);
    display:none;
    z-index:9999;
    overflow:hidden;
}

.action-menu.show{
    display:block;
}

.action-menu a,
.action-menu button{
    width:100%;
    border:none;
    background:none;
    padding:14px 16px;
    text-align:left;
    display:flex;
    align-items:center;
    gap:10px;
    font-size:14px;
    font-weight:600;
    color:#334155;
    cursor:pointer;
    text-decoration:none;
}

.action-menu a:hover,
.action-menu button:hover{
    background:#f8fafc;
}

.delete-action{
    color:#dc2626 !important;
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

.modal.show{
    display:flex;
}

.modal-box{
    background:white;
    width:100%;
    max-width:700px;
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
    font-size:16px;
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
    font-family:'Inter', sans-serif;
    background:white;
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

@media(max-width:768px){
    .search-wrapper input{
        width:100%;
    }

    .toolbar{
        flex-direction:column;
        align-items:stretch;
    }

    .modal-form-grid{
        grid-template-columns:1fr;
    }

    .modal-form-grid .full{
        grid-column:span 1;
    }
}
</style>


<div class="page-header">
    <div class="page-title-wrap">
        <h1>Test Urine</h1>
        <p>Kelola data kegiatan test urine SIPARAMA</p>
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
                <option value="10" {{ request('rows') == 10 ? 'selected' : '' }}>Show 10</option>
                <option value="25" {{ request('rows') == 25 ? 'selected' : '' }}>Show 25</option>
                <option value="50" {{ request('rows') == 50 ? 'selected' : '' }}>Show 50</option>
            </select>
        </div>

        <div class="search-wrapper">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input type="text"
                   name="search"
                   id="searchInput"
                   value="{{ request('search') }}"
                   placeholder="Cari nama instansi / jenis instansi...">
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
                    <th>Nama Instansi</th>
                    <th>Jenis Instansi</th>
                    <th>Sasaran</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($data as $item)

                <tr>

                    <td>{{ $data->firstItem() + $loop->index }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}
                    </td>

                    <td>
                        <a href="/test-urine/{{ $item->slug }}"class="instansi-link">{{ $item->nama_instansi }}</a>
                    </td>

                    <td style="font-weight:600; color:#475569;">
                        {{ $item->jenis_instansi }}
                    </td>

                    <td>{{ $item->sasaran }}</td>

                    <td>{{ $item->keterangan ?: '-' }}</td>

                    <td class="action-cell">

                        <div style="display:flex; justify-content:center; gap:8px;">

                            <button type="button"
                                    onclick='editData(
                                        "{{ $item->id }}",
                                        @json($item->tanggal_kegiatan),
                                        @json($item->nama_instansi),
                                        @json($item->jenis_instansi),
                                        @json($item->kategori_pendidikan),
                                        @json($item->sasaran),
                                        @json($item->tujuan_test),
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

                            <form action="/test-urine/{{ $item->id }}" method="POST">
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
                        Data test urine tidak ditemukan
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


<!-- MODAL TAMBAH -->
<div class="modal" id="addModal">

    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">
                Tambah Data Test Urine
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="/test-urine" method="POST">
            @csrf

            <div class="modal-form-grid">

                <input type="date"
                       name="tanggal_kegiatan"
                       required>

                <input type="text"
                       name="nama_instansi"
                       placeholder="Nama Instansi"
                       required>

                <select name="jenis_instansi"
                        id="jenis_instansi"
                        onchange="toggleKategori()"
                        required>

                    <option value="">Pilih Jenis Instansi</option>
                    <option value="Lingkungan Swasta">Lingkungan Swasta</option>
                    <option value="Lingkungan Pemerintah">Lingkungan Pemerintah</option>
                    <option value="Lingkungan Pendidikan">Lingkungan Pendidikan</option>
                    <option value="Lingkungan Masyarakat">Lingkungan Masyarakat</option>

                </select>

                <select name="kategori_pendidikan"
                        id="kategoriBox"
                        style="display:none;">

                    <option value="">Pilih Kategori Pendidikan</option>
                    <option value="Sekolah">Sekolah</option>
                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>

                </select>

                <input type="text"
                       name="sasaran"
                       placeholder="Sasaran">

                <input type="text"
                       name="tujuan_test"
                       placeholder="Tujuan Test">

                <textarea name="keterangan"
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


<!-- MODAL EDIT -->
<div class="modal" id="editModal">

    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">
                Edit Data Test Urine
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeEditModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-form-grid">

                <input type="date"
                       name="tanggal_kegiatan"
                       id="edit_tanggal"
                       required>

                <input type="text"
                       name="nama_instansi"
                       id="edit_nama_instansi"
                       required>

                <select name="jenis_instansi"
                        id="edit_jenis_instansi"
                        onchange="toggleEditKategori()"
                        required>

                    <option value="Lingkungan Swasta">Lingkungan Swasta</option>
                    <option value="Lingkungan Pemerintah">Lingkungan Pemerintah</option>
                    <option value="Lingkungan Pendidikan">Lingkungan Pendidikan</option>
                    <option value="Lingkungan Masyarakat">Lingkungan Masyarakat</option>

                </select>

                <select name="kategori_pendidikan"
                        id="editKategoriBox"
                        style="display:none;">

                    <option value="">Pilih Kategori Pendidikan</option>
                    <option value="Sekolah">Sekolah</option>
                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>

                </select>

                <input type="text"
                       name="sasaran"
                       id="edit_sasaran">

                <input type="text"
                       name="tujuan_test"
                       id="edit_tujuan">

                <textarea name="keterangan"
                          id="edit_keterangan"
                          class="full"></textarea>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeEditModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-primary">
                    Update Data
                </button>

            </div>

        </form>

    </div>

</div>

<script>
let timer;

/* AUTO SEARCH */
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

/* MODAL TAMBAH */
function openModal(){
    document.getElementById('addModal').classList.add('show');
}

function closeModal(){
    document.getElementById('addModal').classList.remove('show');
}

/* MODAL EDIT */
function closeEditModal(){
    document.getElementById('editModal').classList.remove('show');
}

/* TOGGLE KATEGORI */
function toggleKategori(){

    let jenis = document.getElementById('jenis_instansi').value;
    let box = document.getElementById('kategoriBox');

    if(jenis === 'Lingkungan Pendidikan'){
        box.style.display = 'block';
    }else{
        box.style.display = 'none';
        box.value = '';
    }
}

function toggleEditKategori(){

    let jenis = document.getElementById('edit_jenis_instansi').value;
    let box = document.getElementById('editKategoriBox');

    if(jenis === 'Lingkungan Pendidikan'){
        box.style.display = 'block';
    }else{
        box.style.display = 'none';
        box.value = '';
    }
}

/* EDIT DATA */
function editData(
    id,
    tanggal,
    nama,
    jenis,
    kategori,
    sasaran,
    tujuan,
    keterangan
){
    closeAllMenus();

    document.getElementById('editModal').classList.add('show');

    document.getElementById('editForm').action =
        '/test-urine/' + id;

    document.getElementById('edit_tanggal').value = tanggal;
    document.getElementById('edit_nama_instansi').value = nama;
    document.getElementById('edit_jenis_instansi').value = jenis;
    document.getElementById('editKategoriBox').value = kategori ?? '';
    document.getElementById('edit_sasaran').value = sasaran ?? '';
    document.getElementById('edit_tujuan').value = tujuan ?? '';
    document.getElementById('edit_keterangan').value = keterangan ?? '';

    toggleEditKategori();
}

/* ACTION MENU */
function toggleActionMenu(menuId){

    const menu = document.getElementById(menuId);
    const isOpen = menu.classList.contains('show');

    closeAllMenus();

    if(!isOpen){
        menu.classList.add('show');
    }
}

function closeAllMenus(){
    document.querySelectorAll('.action-menu').forEach(menu => {
        menu.classList.remove('show');
    });
}

/* CLICK OUTSIDE */
document.addEventListener('click', function(e){

    if(!e.target.closest('.action-cell')){
        closeAllMenus();
    }

    if(e.target.id === 'addModal'){
        closeModal();
    }

    if(e.target.id === 'editModal'){
        closeEditModal();
    }

});

/* SUCCESS ALERT */
@if(session('success'))
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:'{{ session('success') }}',
    confirmButtonColor:'#2563eb',
    background:'#ffffff'
});
@endif

/* ERROR ALERT */
@if(session('error'))
Swal.fire({
    icon:'error',
    title:'Gagal',
    text:'{{ session('error') }}',
    confirmButtonColor:'#dc2626',
    background:'#ffffff'
});
@endif

/* VALIDATION ALERT */
@if($errors->any())
Swal.fire({
    icon:'error',
    title:'Validasi Gagal',
    text:'{{ $errors->first() }}',
    confirmButtonColor:'#dc2626',
    background:'#ffffff'
});
@endif
</script>

@endsection