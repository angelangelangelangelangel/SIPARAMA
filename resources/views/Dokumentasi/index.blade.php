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

/* BUTTON */
.btn-primary{
    background:#2563eb;
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

.btn-primary:hover{
    background:#1d4ed8;
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

/* PREVIEW */
.preview-img{
    width:90px;
    height:90px;
    border-radius:14px;
    object-fit:cover;
    border:1px solid #e2e8f0;
}

.preview-icon{
    width:90px;
    height:90px;
    border-radius:14px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
}

/* BADGE */
.category-badge{
    display:inline-block;
    padding:8px 12px;
    border-radius:999px;
    background:#eff6ff;
    color:#1d4ed8;
    font-size:12px;
    font-weight:700;
}

/* ACTION */
.action{
    display:flex;
    gap:8px;
}

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
}

.btn-view{
    background:#dbeafe;
    color:#2563eb;
}

.btn-edit{
    background:#dbeafe;
    color:#2563eb;
}

.btn-delete{
    background:#fee2e2;
    color:#dc2626;
}

/* EMPTY */
.empty-box{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
    font-size:14px;
}

/* MODAL */
.modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,0.55);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
    padding:20px;
}

.modal-overlay.show{
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

.form-group{
    margin-bottom:18px;
}

.form-label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:700;
    color:#334155;
}

.form-input{
    width:100%;
    padding:14px 16px;
    border:1px solid #dbe2ea;
    border-radius:14px;
    outline:none;
    background:#f8fafc;
    font-size:14px;
}

.form-input:focus{
    border-color:#2563eb;
    background:white;
}

.modal-actions{
    display:flex;
    gap:12px;
    margin-top:24px;
}

.submit-btn{
    flex:1;
    height:48px;
    background:#2563eb;
    color:white;
    border:none;
    border-radius:14px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.cancel-btn{
    flex:1;
    height:48px;
    background:#dc2626;
    color:white;
    border:none;
    border-radius:14px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.suggestion-box{
    margin-top:8px;
    border:1px solid #e2e8f0;
    border-radius:14px;
    background:white;
    display:none;
    max-height:240px;
    overflow-y:auto;
    box-shadow:0 10px 30px rgba(15,23,42,0.08);
}

.suggestion-item{
    padding:14px;
    cursor:pointer;
    border-bottom:1px solid #f1f5f9;
    font-size:13px;
    color:#334155;
}

.suggestion-item:hover{
    background:#eff6ff;
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

            <h1>
                Dokumentasi
                {{ isset($desa)
                    ? $desa->nama_desa
                    : ucwords(str_replace('-', ' ', $modul)) }}
            </h1>

            <p>
                Kelola dokumentasi kegiatan
                {{ isset($desa)
                    ? 'desa bersinar'
                    : str_replace('-', ' ', $modul) }}
            </p>

        </div>

        <button class="btn-primary" id="openUploadModal">
            <i class="fa-solid fa-plus"></i>
            Upload Dokumentasi
        </button>

    </div>

    <div class="table-card">

        <div class="toolbar">

            <div class="search-wrapper">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text"
                       id="searchInput"
                       placeholder="Cari dokumentasi...">

            </div>

        </div>

        <div class="table-wrap">

            <table class="data-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Preview</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($data as $index => $item)

                    @php
                        $ext = strtolower(pathinfo($item->file, PATHINFO_EXTENSION));

                        $nama = '-';
                        $tanggal = '-';
                        $kategori = '-';

                        if($modul == 'test-urine' && $item->testUrine){
                            $nama = $item->testUrine->nama_instansi;
                            $tanggal = date('d M Y', strtotime($item->testUrine->tanggal_kegiatan));
                            $kategori = $item->testUrine->jenis_instansi;
                        }

                        elseif($modul == 'penyuluhan' && $item->penyuluhan){
                            $nama = $item->penyuluhan->nama_tempat;
                            $tanggal = date('d M Y', strtotime($item->penyuluhan->tanggal_kegiatan));
                            $kategori = $item->penyuluhan->jenis_instansi;
                        }

                        elseif($modul == 'desa-bersinar' && $item->detailDesa){
                            $nama = $item->detailDesa->kegiatan;
                            $tanggal = date('d M Y', strtotime($item->detailDesa->tanggal_kegiatan));
                            $kategori = $item->detailDesa->desa->nama_desa ?? '-';
                        }
                    @endphp

                    <tr class="data-row">

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>

                            @if(in_array($ext, ['jpg','jpeg','png','webp']))

                                <img src="/uploads/{{ $item->file }}"
                                     class="preview-img">

                            @elseif($ext == 'pdf')

                                <div class="preview-icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>

                            @elseif(in_array($ext, ['doc','docx']))

                                <div class="preview-icon">
                                    <i class="fa-solid fa-file-word"></i>
                                </div>

                            @else

                                <div class="preview-icon">
                                    <i class="fa-solid fa-file"></i>
                                </div>

                            @endif

                        </td>

                        <td>
                            <strong>{{ $nama }}</strong>
                        </td>

                        <td>
                            {{ $tanggal }}
                        </td>

                        <td>

                            <span class="category-badge">
                                {{ $kategori }}
                            </span>

                        </td>

                        <td>

                            <div class="action">

                                <a href="/uploads/{{ $item->file }}"
                                   target="_blank"
                                   class="btn-action btn-view">

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                                <button type="button"
                                        class="btn-action btn-edit"
                                        onclick="openEditModal(
                                            '{{ $item->id }}',
                                            '{{ $nama }}'
                                        )">

                                    <i class="fa-solid fa-pen"></i>

                                </button>

                                <form action="/dokumentasi/{{ $item->id }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn-action btn-delete">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-box">
                                Belum ada dokumentasi.
                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- MODAL UPLOAD -->
<div class="modal-overlay" id="uploadModal">

    <div class="modal-box">

        <div class="modal-header">

            <div class="modal-title">
                Upload Dokumentasi
            </div>

            <button type="button"
                    class="modal-close"
                    id="closeUploadModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form action="/dokumentasi/store"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <input type="hidden"
                   name="modul"
                   value="{{ $modul }}">

            <input type="hidden"
                   name="kegiatan_id"
                   id="kegiatanId">

            <input type="hidden"
                   id="desaId"
                   value="{{ isset($desa) ? $desa->id : '' }}">

            <div class="form-group">

                <label class="form-label">
                    Cari Kegiatan
                </label>

                <input type="text"
                       id="searchKegiatan"
                       class="form-input"
                       placeholder="Ketik nama kegiatan...">

                <div class="suggestion-box"
                     id="suggestionBox"></div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Upload File
                </label>

                <input type="file"
                       name="file"
                       class="form-input"
                       required>

            </div>

            <div class="modal-actions">

                <button type="button"
                        class="cancel-btn"
                        onclick="closeUploadModalFunc()">

                    Batal

                </button>

                <button type="submit"
                        class="submit-btn">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>


<!-- MODAL EDIT -->
<div class="modal-overlay" id="editModal">

    <div class="modal-box">

        <div class="modal-header">

            <div class="modal-title">
                Edit Dokumentasi
            </div>

            <button type="button"
                    class="modal-close"
                    id="closeEditModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form id="editForm"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <input type="hidden"
                   name="kegiatan_id"
                   id="editKegiatanId">

            <div class="form-group">

                <label class="form-label">
                    Cari Kegiatan
                </label>

                <input type="text"
                       id="editSearchKegiatan"
                       class="form-input"
                       placeholder="Ketik nama kegiatan...">

                <div class="suggestion-box"
                     id="editSuggestionBox"></div>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Ganti File (Opsional)
                </label>

                <input type="file"
                       name="file"
                       class="form-input">

            </div>

            <div class="modal-actions">

                <button type="button"
                        class="cancel-btn"
                        onclick="closeEditModalFunc()">

                    Batal

                </button>

                <button type="submit"
                        class="submit-btn">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>


<script>
let timer;

/* TABLE SEARCH */
const searchInput = document.getElementById('searchInput');

if(searchInput){

    searchInput.addEventListener('keyup', function(){

        clearTimeout(timer);

        timer = setTimeout(function(){

            const keyword = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('.data-row');

            rows.forEach(row => {

                row.style.display =
                    row.innerText.toLowerCase().includes(keyword)
                    ? ''
                    : 'none';

            });

        }, 300);

    });

}

/* MODAL ELEMENT */
const uploadModal = document.getElementById('uploadModal');
const editModal = document.getElementById('editModal');

const openUploadBtn = document.getElementById('openUploadModal');
const closeUploadBtn = document.getElementById('closeUploadModal');
const closeEditBtn = document.getElementById('closeEditModal');

/* OPEN/CLOSE MODAL */
function closeUploadModalFunc(){

    uploadModal.classList.remove('show');

}

function closeEditModalFunc(){

    editModal.classList.remove('show');

}

if(openUploadBtn){

    openUploadBtn.addEventListener('click', function(){

        uploadModal.classList.add('show');

    });

}

if(closeUploadBtn){

    closeUploadBtn.addEventListener('click', closeUploadModalFunc);

}

if(closeEditBtn){

    closeEditBtn.addEventListener('click', closeEditModalFunc);

}

/* CLICK OUTSIDE */
document.addEventListener('click', function(e){

    if(e.target === uploadModal){

        closeUploadModalFunc();

    }

    if(e.target === editModal){

        closeEditModalFunc();

    }

});

/* EDIT */
const editForm = document.getElementById('editForm');
const editSearchKegiatan = document.getElementById('editSearchKegiatan');
const editSuggestionBox = document.getElementById('editSuggestionBox');
const editKegiatanId = document.getElementById('editKegiatanId');

function openEditModal(id, nama){

    editForm.action = '/dokumentasi/' + id;
    editSearchKegiatan.value = nama;
    editModal.classList.add('show');

}

/* AUTOCOMPLETE */
const searchKegiatan = document.getElementById('searchKegiatan');
const suggestionBox = document.getElementById('suggestionBox');
const kegiatanId = document.getElementById('kegiatanId');
const desaId = document.getElementById('desaId');

function loadSuggestion(keyword, targetBox, targetInput, targetId){

    fetch(`/dokumentasi/search-kegiatan?modul={{ $modul }}&keyword=${keyword}&desa_id=${desaId.value}`)
        .then(response => response.json())
        .then(data => {

            targetBox.innerHTML = '';

            if(data.length > 0){

                targetBox.style.display = 'block';

                data.forEach(item => {

                    const div = document.createElement('div');

                    div.classList.add('suggestion-item');
                    div.innerText = item.label;

                    div.onclick = function(){

                        targetInput.value = item.label;
                        targetId.value = item.id;
                        targetBox.style.display = 'none';

                    };

                    targetBox.appendChild(div);

                });

            }else{

                targetBox.style.display = 'none';

            }

        });

}

if(searchKegiatan){

    searchKegiatan.addEventListener('keyup', function(){

        if(this.value.length < 2){

            suggestionBox.style.display = 'none';
            return;

        }

        loadSuggestion(
            this.value,
            suggestionBox,
            searchKegiatan,
            kegiatanId
        );

    });

}

if(editSearchKegiatan){

    editSearchKegiatan.addEventListener('keyup', function(){

        if(this.value.length < 2){

            editSuggestionBox.style.display = 'none';
            return;

        }

        loadSuggestion(
            this.value,
            editSuggestionBox,
            editSearchKegiatan,
            editKegiatanId
        );

    });

}
</script>
@endsection