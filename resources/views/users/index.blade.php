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
    transition:.2s;
}

.btn-primary:hover{
    background:#1d4ed8;
}

.btn-secondary{
    background:#64748b;
    color:white;
    border:none;
    padding:10px 16px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
    transition:.2s;
}

.btn-secondary:hover{
    background:#475569;
}

.filter-tabs{
    display:flex;
    gap:24px;
    margin-bottom:22px;
    border-bottom:1px solid #e2e8f0;
}

.filter-tab{
    padding:14px 2px;
    font-size:14px;
    font-weight:600;
    color:#64748b;
    position:relative;
    text-decoration:none;
    transition:.2s;
}

.filter-tab:hover{
    color:#0f172a;
}

.filter-tab.active{
    color:#0f172a;
}

.filter-tab.active::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-1px;
    width:100%;
    height:3px;
    background:#0f172a;
    border-radius:10px;
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

.user-table{
    width:100%;
    border-collapse:collapse;
}

.user-table thead th{
    background:#f8fafc;
    color:#64748b;
    font-size:12px;
    font-weight:700;
    padding:18px 20px;
    text-align:left;
    border-bottom:1px solid #e2e8f0;
}

.user-table tbody td{
    padding:18px 20px;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}

.user-table tbody tr:hover{
    background:#f8fafc;
}

.user-info{
    display:flex;
    align-items:center;
    gap:14px;
}

.user-avatar{
    width:42px;
    height:42px;
    border-radius:50%;
    background:#e2e8f0;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    color:#334155;
    font-size:14px;
}

.user-name{
    font-size:14px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:4px;
}

.user-username{
    font-size:13px;
    color:#64748b;
}

.badge{
    padding:7px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    display:inline-block;
}

.role-admin{
    background:#fee2e2;
    color:#b91c1c;
}

.role-pegawai{
    background:#dbeafe;
    color:#1d4ed8;
}

.role-kepala{
    background:#ede9fe;
    color:#7c3aed;
}

.status-active{
    background:#dcfce7;
    color:#15803d;
}

.status-nonaktif{
    background:#fee2e2;
    color:#b91c1c;
}

.action-cell{
    position:relative;
}

.action-btn{
    width:38px;
    height:38px;
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
}

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
    padding:50px 20px;
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
    max-width:560px;
    border-radius:20px;
    padding:24px;
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.modal-title{
    font-size:20px;
    font-weight:800;
}

.modal-form{
    display:grid;
    gap:14px;
}

@media(max-width:768px){
    .pagination-wrap{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>


<div class="page-header">
    <div class="page-title-wrap">
        <h1>Users</h1>
        <p>Kelola akun pengguna sistem SIPARAMA</p>
    </div>

    <button class="btn-add" onclick="openAddModal()">
        <i class="fa-solid fa-plus"></i>
        Tambah User
    </button>
</div>


<div class="filter-tabs">
    <a href="{{ route('users.index') }}"
       class="filter-tab {{ !$status ? 'active' : '' }}">
        Semua
    </a>

    <a href="{{ route('users.index', ['status' => 'Aktif']) }}"
       class="filter-tab {{ $status == 'Aktif' ? 'active' : '' }}">
        Aktif
    </a>

    <a href="{{ route('users.index', ['status' => 'Nonaktif']) }}"
       class="filter-tab {{ $status == 'Nonaktif' ? 'active' : '' }}">
        Nonaktif
    </a>
</div>


<div class="table-card">
    <div class="table-wrap">
        <table class="user-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($data as $item)

                @php
                    $roleName = $item->role->name ?? '';

                    $roleClass = match($roleName){
                        'Admin' => 'role-admin',
                        'Pegawai' => 'role-pegawai',
                        'Kepala Bidang P2M' => 'role-kepala',
                        default => 'role-pegawai'
                    };
                @endphp

                <tr>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ strtoupper(substr($item->name, 0, 1)) }}
                            </div>

                            <div>
                                <div class="user-name">
                                    {{ $item->name }}
                                </div>

                                <div class="user-username">
                                    {{ $item->username }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="badge {{ $roleClass }}">
                            {{ $roleName }}
                        </span>
                    </td>

                    <td>
                        <span class="badge {{ $item->status == 'Aktif' ? 'status-active' : 'status-nonaktif' }}">
                            {{ $item->status }}
                        </span>
                    </td>

                    <td>
                        {{ $item->last_active
                            ? \Carbon\Carbon::parse($item->last_active)->diffForHumans()
                            : '-' }}
                    </td>

                    <td class="action-cell">

                        <button type="button"
                                class="action-btn"
                                onclick="toggleActionMenu('menu{{ $item->id }}')">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        <div class="action-menu" id="menu{{ $item->id }}">

                            @if(auth()->id() != $item->id)

                                <button type="button"
                                        onclick='openEditModal(
                                            {{ $item->id }},
                                            @json($item->name),
                                            @json($item->username),
                                            @json($item->email),
                                            {{ $item->role_id }},
                                            @json($item->status)
                                        )'>
                                    <i class="fa-solid fa-pen"></i>
                                    Edit
                                </button>

                                <form action="{{ route('users.toggleStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit">
                                        <i class="fa-solid fa-power-off"></i>
                                        {{ $item->status == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('users.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="delete-action">
                                        <i class="fa-solid fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>

                            @else

                                <button type="button"
                                        disabled
                                        style="opacity:.5; cursor:not-allowed;">
                                    <i class="fa-solid fa-lock"></i>
                                    Akun Sedang Digunakan
                                </button>

                            @endif

                        </div>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5" class="empty-state">
                        Data user tidak ditemukan
                    </td>
                </tr>

            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        <div class="pagination-info">
            Showing {{ $data->firstItem() ?? 0 }}–{{ $data->lastItem() ?? 0 }} of {{ $data->total() }} results
        </div>

        {{ $data->links() }}
    </div>

</div>


<!-- ADD MODAL -->
<div class="modal" id="addModal">
    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">Tambah User</div>

            <button type="button"
                    class="btn-secondary"
                    onclick="closeAddModal()">
                Tutup
            </button>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="modal-form">

                <input type="text"
                       name="name"
                       placeholder="Nama"
                       required>

                <input type="text"
                       name="username"
                       placeholder="Username"
                       required>
                
                       <input type="email"
                            name="email"
                            placeholder="Email"
                            required>

                <div style="position:relative;">
                <input type="password"
                    name="password"
                    id="add_password"
                    placeholder="Password"
                    required
                    style="padding-right:45px;">

                <i class="fa-solid fa-eye"
                id="toggleAddPassword"
                style="
                        position:absolute;
                        right:15px;
                        top:50%;
                        transform:translateY(-50%);
                        cursor:pointer;
                        color:#64748b;
                ">
                </i>
            </div>

                <select name="role_id" required>
                    <option value="">Pilih Role</option>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>

                <button type="submit" class="btn-primary">
                    Simpan User
                </button>

            </div>
        </form>
    </div>
</div>


<!-- EDIT MODAL -->
<div class="modal" id="editModal">
    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">Edit User</div>

            <button type="button"
                    class="btn-secondary"
                    onclick="closeEditModal()">
                Tutup
            </button>
        </div>

        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="modal-form">

                <input type="text"
                       name="name"
                       id="edit_name"
                       required>

                <input type="text"
                       name="username"
                       id="edit_username"
                       required>

                    <input type="email"
                            name="email"
                            id="edit_email"
                            required>

                <div style="position:relative;">
                <input type="password"
                    name="password"
                    id="edit_password"
                    placeholder="Kosongkan jika password tidak diubah"
                    style="padding-right:45px;">

                <i class="fa-solid fa-eye"
                id="toggleEditPassword"
                style="
                        position:absolute;
                        right:15px;
                        top:50%;
                        transform:translateY(-50%);
                        cursor:pointer;
                        color:#64748b;
                ">
                </i>
            </div>

                <select name="role_id"
                        id="edit_role"
                        required>

                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}
                        </option>
                    @endforeach

                </select>

                <select name="status"
                        id="edit_status"
                        required>

                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>

                </select>

                <button type="submit" class="btn-primary">
                    Update User
                </button>

            </div>
        </form>
    </div>
</div>


@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:'{{ session('success') }}',
    confirmButtonColor:'#2563eb'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon:'error',
    title:'Gagal',
    text:'{{ session('error') }}',
    confirmButtonColor:'#dc2626'
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Validasi Gagal',
    text:'{{ $errors->first() }}',
    confirmButtonColor:'#dc2626'
});
</script>
@endif


<script>
function openAddModal(){
    document.getElementById('addModal').classList.add('show');
}

function closeAddModal(){
    document.getElementById('addModal').classList.remove('show');
}

function openEditModal(id, name, username, email, role, status){{
    closeAllMenus();

    document.getElementById('editForm').action = '/users/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('edit_status').value = status;

    document.getElementById('editModal').classList.add('show');
}

function closeEditModal(){
    document.getElementById('editModal').classList.remove('show');
}

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

document.addEventListener('click', function(e){

    if(!e.target.closest('.action-cell')){
        closeAllMenus();
    }

    if(e.target.id === 'addModal'){
        closeAddModal();
    }

    if(e.target.id === 'editModal'){
        closeEditModal();
    }
});

const toggleAddPassword =
document.getElementById('toggleAddPassword');

if(toggleAddPassword){

    toggleAddPassword.addEventListener('click', function(){

        const input =
        document.getElementById('add_password');

        if(input.type === 'password'){
            input.type = 'text';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }else{
            input.type = 'password';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }

    });

}

const toggleEditPassword =
document.getElementById('toggleEditPassword');

if(toggleEditPassword){

    toggleEditPassword.addEventListener('click', function(){

        const input =
        document.getElementById('edit_password');

        if(input.type === 'password'){
            input.type = 'text';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }else{
            input.type = 'password';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }

    });

}
</script>

@endsection