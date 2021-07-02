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
                                        <td>Kode Transaksi</td>
                                        <td>Kode Akun</td>
                                        <td>Keterangan</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jurnal as $u)
                                        <tr>
                                            <td>{{ $u->id }}</td>
                                            <td>{{ $u->transaction_id }}</td>
                                            <td>{{ $u->account->name }}</td>
                                            <td>{{ $u->notes }}</td>
                                            <td>
                                                <a data-id="{{ $u->id }}"
                                                    data-transactionId="{{ $u->transaction_id }}"
                                                    data-accountId="{{ $u->account_id }}" data-notes="{{ $u->notes }}"
                                                    href="#" data-toggle="modal" data-target="#modalForm"
                                                    class="btn btn-sm btn-warning btnEdit">edit</a>
                                                <a href="{{ route('transaction_jurnal_hapus_proses', ['id' => $u->id]) }}"
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
                                                <label for="transaction_id">Kode Transaksi</label>
                                                <select name="transaction_id" id="transacion_id" class="form-control">
                                                    <option>-pilih-</option>
                                                    @foreach ($transaction as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="account_id">Kode Akun</label>
                                                <select name="account_id" id="account_id" class="form-control">
                                                    <option>-pilih-</option>
                                                    @foreach ($account as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->id . '-' . $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="notes">Keterangan</label>
                                                <input type="text" name="notes" id="notes" class="form-control"
                                                    placeholder="Masukan keterangan jika ada">
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
                $('#modalForm form').attr('action', "{{ route('transaction_jurnal_post') }}")
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
                    "{{ url('/owner/transaction/jurnal') }}/" +
                    id + "");

                $('select[name="transaction_id"]').val($(this).attr('data-transactionId'));
                $('select[name="account_id"]').val($(this).attr('data-accountId'));
                $('input[name="notes"]').val($(this).attr('data-notes'));
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
