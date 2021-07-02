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
                            <table class="table table-stripped" id="tblUser">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Alamat</td>
                                        <td>No. Telp.</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer as $u)
                                        <tr>
                                            <td>{{ $u->id }}</td>
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->address }}</td>
                                            <td>{{ $u->phone_number }}</td>
                                            <td>
                                                <a data-id="{{ $u->id }}" data-name="{{ $u->name }}"
                                                    data-address="{{ $u->address }}"
                                                    data-phone_number="{{ $u->phone_number }}" href="#"
                                                    data-toggle="modal" data-target="#modalForm"
                                                    class="btn btn-sm btn-warning btnEdit">edit</a>
                                                <a href="{{ route('owner_master_customer_delete_process', ['id' => $u->id]) }}"
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
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="Masukan nama nama">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Alamat</label>
                                                <textarea name="address" id="address" cols="30" rows="5"
                                                    class="form-control" placeholder="Masukan alamat Anda"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone_number">Nomor Telpon</label>
                                                <input type="number" name="phone_number" id="phone_number"
                                                    class="form-control" placeholder="Masukan nama phone_number">
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
            $('#tblUser').DataTable();

            $('.btnTambah').click(function(e) {
                e.preventDefault();
                $('#tambahan').html('');
                $('#modalForm form')[0].reset();
                $('#modalForm .modal-title').html('Tambah Master Customer');
                $('#modalForm form').attr('action', "{{ route('owner_master_customer_insert_process') }}")
            });

            // edit button action
            $('.btnEdit').click(function(e) {
                e.preventDefault();

                var id = $(this).attr('data-id');

                $('#tambahan').append(
                    '<mall style="color:red">Isi bila ingin mengganti password</small>')

                $('#modalForm .modal-title').html('Ubah Master Customer');
                $('#modalForm form')[0]
                    .reset();
                $('#modalForm form').attr(
                    'action',
                    "{{ url('/owner/master/customer/update/process/') }}/" +
                    id + "");

                $('input[name="name"]').val($(this).attr('data-name'));
                $(
                    'textarea[name="address"]').val($(this).attr('data-address'));
                $('input[name="phone_number"]').val($(this).attr('data-phone_number'));
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
