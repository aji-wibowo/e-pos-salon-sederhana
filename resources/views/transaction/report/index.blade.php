@extends('layouts.appPrimary')
@section('title', $title)
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transaction_report_process') }}" method="post">
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
                                            <th>Customer</th>
                                            <th>Kasir</th>
                                            <th>Total</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $u)
                                            <tr>
                                                <td>{{ $u->id }}</td>
                                                <td>{{ $u->customer->name }}</td>
                                                <td>{{ $u->cashier->name }}</td>
                                                <td>{{ $u->total }}</td>
                                                <td class="clickable" data-toggle="collapse" id="row1"
                                                    data-target=".row{{ $u->id }}">
                                                    <a href="#" class="btn btn-sm btn-info">detail</a>
                                                </td>
                                            </tr>
                                            @if ($u->detail != null)
                                                @foreach ($u->detail as $i)
                                                    <tr class="collapse row{{ $u->id }}">
                                                        <td>- detail transaction</td>
                                                        <td>{{ $i->product->name }}</td>
                                                        <td>{{ $i->product->unit }}</td>
                                                        <td>{{ $i->qty }}</td>
                                                        <td>{{ $i->price }}</td>
                                                        <td>{{ $i->subtotal }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
            // $('#tblUser').DataTable({});
        });
    </script>
@endsection
