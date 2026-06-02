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

.info-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:24px;
    margin-bottom:20px;
}

.info-text{
    font-size:15px;
    line-height:1.9;
    color:#475569;
}

.table-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.table-header{
    padding:20px 24px;
    border-bottom:1px solid #e2e8f0;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:14px;
}

.table-title{
    font-size:18px;
    font-weight:800;
    color:#0f172a;
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

.action-cell{
    text-align:center;
    width:120px;
}

.action-wrap{
    display:flex;
    justify-content:center;
    gap:8px;
}

.action-btn{
    width:40px;
    height:40px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:14px;
}

.edit-btn{
    background:#dbeafe;
    color:#2563eb;
}

.delete-btn{
    background:#fee2e2;
    color:#dc2626;
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
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.form-grid input,
.form-grid select,
.form-grid textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    font-family:'Inter', sans-serif;
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
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:22px;
}

@media(max-width:768px){
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
        <h1>Peserta Test Urine</h1>
        <p>Kelola data peserta kegiatan test urine</p>
    </div>
</div>

<div class="info-card">
    <div class="info-text">
        Kegiatan tes urine yang dilaksanakan di
        <strong>{{ $data->nama_instansi }}</strong>
        dengan sasaran
        <strong>{{ $data->sasaran }}</strong>
        diikuti oleh
        <strong>{{ $data->peserta->count() }}</strong>
        peserta sebagai upaya deteksi dini dan pencegahan penyalahgunaan narkoba, serta mendukung terciptanya lingkungan yang sehat, aman, dan bebas dari narkotika.
    </div>
</div>

<div class="table-card">

    <div class="table-header">
        <div class="table-title">Data Peserta</div>

        <button type="button"
                onclick="openModal()"
                class="btn-add">
            <i class="fa-solid fa-plus"></i>
            Tambah Peserta
        </button>
    </div>

    <div class="table-wrap">

        <table class="data-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Jenis Kelamin</th>
                    <th>Status Kehadiran</th>
                    <th>Hasil</th>
                    <th>Riwayat Obat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <tbody>

    @forelse($data->peserta as $item)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td style="font-weight:700; color:#0f172a;">
            {{ $item->nama_peserta }}
        </td>

        <td>
            {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
        </td>

        <td>
            {{ ucwords(str_replace('_', ' ', $item->status_kehadiran)) }}
        </td>

        <td style="
            font-weight:700;
            color:{{ $item->hasil == 'reaktif' ? '#dc2626' : '#16a34a' }};
        ">
            {{ ucwords(str_replace('_', ' ', $item->hasil)) }}
        </td>

        <td>
            {{ $item->riwayat_obat ?: '-' }}
        </td>

        <td class="action-cell">

            <div class="action-wrap">

                <button type="button"
                        class="action-btn edit-btn"
                        onclick='editPeserta(
                            "{{ $item->id }}",
                            @json($item->nama_peserta),
                            @json($item->jenis_kelamin),
                            @json($item->status_kehadiran),
                            @json($item->hasil),
                            @json($item->riwayat_obat)
                        )'>
                    <i class="fa-solid fa-pen"></i>
                </button>

                <form action="/peserta/{{ $item->id }}"
                      method="POST"
                      onsubmit="return confirm('Yakin hapus peserta?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="action-btn delete-btn">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </form>

            </div>

        </td>

    </tr>

    @empty

    <tr>
        <td colspan="7" class="empty-state">
            Belum ada data peserta
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
                Tambah Peserta Test Urine
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="/peserta/store" method="POST">
            @csrf

            <input type="hidden"
                   name="test_urine_id"
                   value="{{ $data->id }}">

            <div class="form-grid">

                <input type="text"
                       name="nama_peserta"
                       placeholder="Nama Peserta"
                       required>

                <select name="jenis_kelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>

                <select name="status_kehadiran" required>
                    <option value="">Pilih Status Kehadiran</option>
                    <option value="Hadir">Hadir</option>
                    <option value="Tidak Hadir">Tidak Hadir</option>
                </select>

                <select name="hasil" required>
                    <option value="">Pilih Hasil</option>
                    <option value="reaktif">Reaktif</option>
                    <option value="non_reaktif">Non Reaktif</option>
                </select>

                <textarea name="riwayat_obat"
                          class="full"
                          placeholder="Riwayat Obat (Opsional)"></textarea>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-primary">
                    Simpan Peserta
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
                Edit Peserta Test Urine
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

            <div class="form-grid">

                <input type="text"
                       name="nama_peserta"
                       id="edit_nama"
                       required>

                <select name="jenis_kelamin"
                        id="edit_jenis_kelamin"
                        required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>

                <select name="status_kehadiran"
                        id="edit_status"
                        required>
                    <option value="Hadir">Hadir</option>
                    <option value="Tidak Hadir">Tidak Hadir</option>
                </select>

                <select name="hasil"
                        id="edit_hasil"
                        required>
                    <option value="reaktif">Reaktif</option>
                    <option value="non_reaktif">Non Reaktif</option>
                </select>

                <textarea name="riwayat_obat"
                          id="edit_riwayat"
                          class="full"
                          placeholder="Riwayat Obat"></textarea>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeEditModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-primary">
                    Update Peserta
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

function editPeserta(
    id,
    nama,
    jk,
    status,
    hasil,
    riwayat
){
    document.getElementById('editModal').classList.add('show');

    document.getElementById('editForm').action = '/peserta/' + id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_jenis_kelamin').value = jk;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_hasil').value = hasil;
    document.getElementById('edit_riwayat').value = riwayat ?? '';
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
