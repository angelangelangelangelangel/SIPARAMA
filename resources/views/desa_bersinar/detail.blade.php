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
    line-height:1.7;
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

.table-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.info-box{
    padding:24px;
    border-bottom:1px solid #e2e8f0;
    background:#ffffff;
}

.info-box p{
    font-size:14px;
    color:#475569;
    line-height:1.9;
    margin:0;
}

.section-header{
    padding:20px 24px;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    border-bottom:1px solid #e2e8f0;
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
}

.data-table thead th:last-child{
    border-right:none;
}

.data-table tbody td{
    padding:18px 22px;
    border-bottom:1px solid #e2e8f0;
    border-right:1px solid #f1f5f9;
    font-size:14px;
    color:#334155;
    vertical-align:middle;
}

.data-table tbody td:last-child{
    border-right:none;
}

.data-table tbody tr:hover{
    background:#f8fafc;
}

.action-cell{
    text-align:center;
    width:110px;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
    font-size:14px;
}

/* MODAL */
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
    max-width:720px;
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
.modal-form-grid textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    outline:none;
    box-sizing:border-box;
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
        <h1>Desa Bersinar</h1>
        <p>
            Kegiatan Desa Bersinar yang dilaksanakan di
            <strong>{{ $data->nama_desa }}</strong>
            sebagai upaya pencegahan, pemberdayaan masyarakat,
            serta menciptakan lingkungan yang sehat, aman,
            dan bebas dari penyalahgunaan narkoba.
        </p>
    </div>

</div>

<div class="table-card">

    <div class="section-header"
     style="justify-content:flex-end;">

    <button type="button"
            onclick="openModal()"
            class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Tambah Kegiatan
    </button>

</div>

    <div class="table-wrap">

        <table class="data-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                        @forelse($data->detail as $item)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>
            {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}
        </td>

        <td>{{ $item->kegiatan }}</td>

        <td>{{ $item->keterangan ?? '-' }}</td>

        <td class="action-cell">

            <div style="display:flex; justify-content:center; gap:8px;">

                <button type="button"
                        onclick='editKegiatan(
                            "{{ $item->id }}",
                            @json($item->tanggal_kegiatan),
                            @json($item->kegiatan),
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

                <form action="/detail-desa-bersinar/{{ $item->id }}" method="POST">
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
        <td colspan="5" class="empty-state">
            Belum ada data kegiatan
        </td>
    </tr>

@endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- MODAL TAMBAH -->
<div class="modal" id="modalForm">

    <div class="modal-box">

        <div class="modal-header">

            <div class="modal-title">
                Tambah Kegiatan Desa Bersinar
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form action="/desa-bersinar/{{ $data->id }}/kegiatan"
      method="POST">

            @csrf
        <div class="modal-form-grid">

        <input type="date"
            name="tanggal_kegiatan"
            required>

        <input type="text"
            name="keterangan"
            placeholder="Keterangan">

        <textarea name="kegiatan"
                class="full"
                placeholder="Nama Kegiatan"
                required></textarea>

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
                Edit Kegiatan Desa Bersinar
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeEditModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <form id="editForm"
              method="POST">

            @csrf
            @method('PUT')

            <div class="modal-form-grid">

                <input type="date"
                    name="tanggal_kegiatan"
                    id="edit_tanggal"
                    required>

                <div></div>

                <textarea name="kegiatan"
                        id="edit_kegiatan"
                        class="full"
                        placeholder="Nama Kegiatan"
                        required></textarea>

                <input type="text"
                    name="keterangan"
                    id="edit_keterangan"
                    placeholder="Keterangan">

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
function openModal(){
    document.getElementById('modalForm').classList.add('show');
}

function closeModal(){
    document.getElementById('modalForm').classList.remove('show');
}

function closeEditModal(){
    document.getElementById('editModal').classList.remove('show');
}

function editKegiatan(id, tanggal, kegiatan, keterangan){

    document.getElementById('editModal').classList.add('show');

    document.getElementById('editForm').action =
        '/detail-desa-bersinar/' + id;

    document.getElementById('edit_tanggal').value =
        tanggal ?? '';

    document.getElementById('edit_kegiatan').value =
        kegiatan ?? '';

    document.getElementById('edit_keterangan').value =
        keterangan ?? '';
}

document.addEventListener('click', function(e){

    if(e.target.id === 'modalForm'){
        closeModal();
    }

    if(e.target.id === 'editModal'){
        closeEditModal();
    }

});
</script>

@endsection