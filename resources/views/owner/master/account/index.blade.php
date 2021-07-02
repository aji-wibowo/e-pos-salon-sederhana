@extends('layouts.appPrimary')
@section('title', $title)
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-right">
                            <a data-toggle="modal" data-target="#modalForm" href="#"
                                class="btn btn-sm btn-success btnTambah mb-2">tambah</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-stripped" id="tblAccount">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Kode Akun</td>
                                        <td>Nama Akun</td>
                                        <td>Type</td>
                                        <td>Status</td>
                                        <td>Normal Saldo</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account as $u)
                                        <tr>
                                            <td>{{ $u->id }}</td>
                                            <td>{{ $u->account_code }}</td>
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->type_of_account }}</td>
                                            <td>{{ $u->account_status }}</td>
                                            <td>{{ $u->normal_saldo }}</td>
                                            <td>
                                                <a data-id="{{ $u->id }}" data-code="{{ $u->account_code }}"
                                                    data-name="{{ $u->name }}"
                                                    data-type_of_account="{{ $u->type_of_account }}"
                                                    data-account_status="{{ $u->account_status }}"
                                                    data-normal_saldo="{{ $u->normal_saldo }}" href="#"
                                                    data-toggle="modal" data-target="#modalForm"
                                                    class="btn btn-sm btn-warning btnEdit">edit</a>
                                                <a href="{{ route('owner_master_account_delete_process', ['id' => $u->id]) }}"
                                                    class="btn btn-sm btn-danger btnDelete">delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="modal fade" id="modalForm" aria-modal="true" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Default Modal</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="account_code">Kode Akun</label>
                                                <input type="text" name="account_code" id="account_code"
                                                    class="form-control" placeholder="Masukan kode akun">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="Masukan nama akun">
                                            </div>
                                            <div class="form-group">
                                                <label for="type_of_account">Tipe Akun</label>
                                                <input type="text" name="type_of_account" id="type_of_account"
                                                    class="form-control" placeholder="Masukan tipe akun">
                                            </div>
                                            <div class="form-group">
                                                <label for="account_status Akun">Status Akun</label>
                                                <select name="account_status" id="account_status" class="form-control">
                                                    <option>-Pilih-</option>
                                                    <option value="debit">Debit</option>
                                                    <option value="kredit">Kredit</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="normal_saldo">Normal Saldo</label>
                                                <input type="number" name="normal_saldo" id="normal_saldo"
                                                    class="form-control" placeholder="Masukan harga">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary btnSave">Save changes</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tblAccount').DataTable();

            $('.btnTambah').click(function(e) {
                e.preventDefault();
                $('#tambahan').html('');
                $('#modalForm form')[0].reset();
                $('#modalForm .modal-title').html('Tambah Master Akun');
                $('#modalForm form').attr('action',
                    "{{ route('owner_master_account_insert_process') }}")
            });

            // edit button action
            $('.btnEdit').click(function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');

                $('#tambahan').append(
                    '<mall style="color:red">Isi bila ingin mengganti password</small>')

                $('#modalForm .modal-title').html('Ubah Master Akun');
                $('#modalForm form')[0]
                    .reset();
                $('#modalForm form').attr(
                    'action',
                    "{{ url('/owner/master/account/update/process/') }}/" +
                    id + "");

                $('input[name="name"]').val($(this).attr('data-name'));
                $('input[name="account_code"]').val($(this).attr('data-code'));
                $('input[name="type_of_account"]').val($(this).attr('data-type_of_account'));
                $(
                    'input[name="normal_saldo"]').val($(this).attr('data-normal_saldo'));
                $('select[name="account_status"]').val($(this).attr('data-account_status'));
            })

            $('.btnSave').click(function() {
                $('#modalForm form').submit();
            })

            $('.btnDelete').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Anda yakin ingin melakukan hapus?',
                    text: "Data yang telah dihapus tidak akan dapat kembali!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = $(this).attr('href');
                    }
                })
            })
        })
    </script>
@endsection
