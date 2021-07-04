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
                </form>
            </div>
        </div>
    </div>
@endsection
