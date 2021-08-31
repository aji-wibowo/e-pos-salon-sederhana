@extends('layouts.appPrimary')
@section('title', $title)
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transaction_report_jurnal_process') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_from">Tanggal Awal</label>
                                <input type="date" name="date_from" id="date_from" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_to">Tanggal Akhir</label>
                                <input type="date" name="date_to" id="date_to" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary">Generate PDF</button>
                        </div>
                    </div>
                    <hr>
                    <h3>List Data</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-stripped" id="tblUser">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kode Akun</th>
                                            <th>Kas</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Normal Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $u)
                                            <tr>
                                                <td>{{ $u->id }}</td>
                                                <td>{{ $u->account_code }}</td>
                                                <td>{{ $u->name }}</td>
                                                <td>{{ $u->type_of_account }}</td>
                                                <td>{{ $u->account_status }}</td>
                                                <td>{{ $u->normal_saldo }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tblUser').DataTable({});
        });
    </script>
@endsection
