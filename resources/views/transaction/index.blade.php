@extends('layouts.appPrimary')
@section('title', $title)

@section('content')
    <div class="container-fluid">
        <form action="#" action="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="customer_id">Pilih Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option>-Pilih Customer-</option>
                                    @if ($customers->count() > 0)
                                        @foreach ($customers as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="totalToDB">Total</label>
                                <input type="text" id="totalToDB" name="total" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div style="float: left; width: 100%">
                        <h5 style="float: left">Produk</h5>
                        <a class="btn btn-sm btn-info" data-target="#ourModal" data-toggle="modal"
                            style="float: right">tambah produk</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" id="nama_barang" class="form-control" readonly>
                        <input type="hidden" name="id_item" id="id_item">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" id="jumlah" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Satuan</label>
                        <input type="text" id="satuan" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" id="harga" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-success btn-sm" id="bInsertTemp"
                            style="margin-top: 25px; width: 100%">tambah</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h5>Keranjang</h5>
                    <table class="table table-bordered" id="tTemporary">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody id="tBodyTemporary">
                            <td colspan="6">data kosong</td>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="bSubmit" class="btn btn-sm btn-success">submit</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="ourModal" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Pilih Produk</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Satuan</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($products->count() > 0)
                                            @foreach ($products as $p)
                                                <tr>
                                                    <td class="p-name">{{ $p->name }}</td>
                                                    <td class="p-unit">{{ $p->unit }}</td>
                                                    <td class="p-price">{{ $p->price }}</td>
                                                    <td class="p-stock">{{ $p->stock }}</td>
                                                    <td>
                                                        <a href="#" data-id="{{ $p->id }}"
                                                            class="btn btn-sm btn-success btnPilih">
                                                            pilih
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <p>Stok Kosong</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>

    <script>
        var stockKunci;
        $(document).ready(function() {
            loadListBarangTemp();

            $('#bSubmit').click(function(e) {
                e.preventDefault();
                var customer = $('#customer_id').val();

                var data = {
                    customer: customer
                }

                $.ajax({
                    url: "{{ route('transaction_process') }}",
                    type: 'POST',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        customer_id: customer
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            Swal.fire('success', 'Berhasil input transaksi', 'success').then(
                                function() {
                                    window.location.reload();
                                });
                        } else {
                            Swal.fire('error', 'error', 'error');
                        }
                        loadListBarangTemp();
                    }
                });
            });

            $(document).on('click', '.btnPilih', function(e) {
                e.preventDefault();

                var item_id = $(this).attr('data-id');
                var item_name = $(this).parent().parent().find('.p-name').html();
                var unit_name = $(this).parent().parent().find('.p-unit').html();
                var buy_price = $(this).parent().parent().find('.p-price').html();
                stockKunci = $(this).parent().parent().find('.p-stock').html();

                $('#nama_barang').val(item_name);
                $('#satuan').val(unit_name);
                $('#harga').val(buy_price);
                $('#id_item').val(item_id);

                $('#ourModal').modal('hide');
            });

            $('#bInsertTemp').click(function(e) {
                e.preventDefault();
                var id_item = $('#id_item').val();
                var jumlah = $('#jumlah').val();

                if (id_item == '' || jumlah == '') {
                    Swal.fire("Isn't Us!",
                        "Anda harus memilih item atau mengisi jumlah barang terlebih dahulu!",
                        'warning');
                } else {
                    if (parseInt(jumlah) > parseInt(stockKunci) || jumlah == 0) {
                        Swal.fire('Gagal', 'Stok yang Anda masukan tidak cukup atau 0!!!', 'error');
                    } else {
                        $.ajax({
                            url: "{{ route('temporary_insert') }}",
                            type: 'POST',
                            data: {
                                id_item: id_item,
                                qty: jumlah,
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(r) {
                                if (r.status == 0) {
                                    Swal.fire(r.title, r.text, r.icon);
                                } else {
                                    loadListBarangTemp();
                                    $('#nama_barang').val("");
                                    $('#satuan').val("");
                                    $('#harga').val("");
                                    $('#jumlah').val("");
                                    $('#id_item').val("");
                                }
                            }
                        })
                    }
                }
            })

            $(document).on('click', '.bDeleteTemp', function(e) {
                e.preventDefault();
                var id_temp = $(this).attr('data-id-temp');
                $.ajax({
                    url: "{{ route('temporary_delete') }}",
                    type: 'post',
                    data: {
                        id: id_temp,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(r) {
                        if (r.status == 0) {
                            swal('error', 'silahkan coba beberapa saat lagi.', 'error');
                        } else {
                            loadListBarangTemp();
                        }
                    }
                })
            })

            function loadListBarangTemp() {
                $.ajax({
                    url: "{{ route('temporary_get') }}",
                    type: 'post',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(r) {
                        var html = '';
                        var grandtot = 0;

                        if (r.status != 0) {
                            $.each(r.data, function(i, item) {
                                let subtotal = parseInt(item.product.price) * parseInt(item
                                    .qty);

                                grandtot += subtotal;
                                html += '<tr class="rownya">' +
                                    '<td class="idItemToDB">' + item.product.id + '</td>' +
                                    '<td>' + item.product.name + '</td>' +
                                    '<td class="qtyToDB">' + item.qty + '</td>' +
                                    '<td class="priceToDB">' + item.product.price + '</td>' +
                                    '<td class="subtotalToDB">' + subtotal + '</td>' +
                                    '<td><a href="#" data-id-temp=' + item.id +
                                    ' class="bDeleteTemp">delete</a></td>' +
                                    '</tr>';
                            });

                            $('#totalToDB').val(grandtot);

                        } else {
                            html = '<tr>' +
                                '<td colspan="6">data kosong</td>' +
                                '</tr>';
                        }

                        $('#tBodyTemporary').html(html);
                    }
                })
            }
        })
    </script>
@endsection
