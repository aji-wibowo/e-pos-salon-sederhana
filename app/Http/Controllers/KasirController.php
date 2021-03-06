<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProductDetail;
use App\Models\TransactionProductDetailTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $parseData = [
            'title' => 'Home | Kasir'
        ];
        return view('kasir.home', $parseData);
    }

    // master produk
    public function master_product()
    {
        $product = Product::all();

        $parseData = [
            'title' => 'Master Product | Kasir',
            'product' => $product
        ];

        return view('kasir.master.product.index', $parseData);
    }

    public function master_product_tambah_proses(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'stock' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ]);

        $tambah = Product::create([
            'id' => $this->generateCodeId('product'),
            'name' => $r->name,
            'stock' => $r->stock,
            'unit' => $r->unit,
            'price' => $r->price
        ]);

        if ($tambah) {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data product!'));
        } else {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master product!'));
        }
    }

    public function master_product_ubah_proses(Request $r, $id)
    {
        $r->validate([
            'name' => 'required',
            'stock' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($id);

        if ($product == null) {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master product!'));
        }

        $product->name = $r->name;
        $product->stock = $r->stock;
        $product->unit = $r->unit;
        $product->price = $r->price;

        if ($product->save()) {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master product!'));
        } else {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master product!'));
        }
    }

    public function master_product_hapus_proses($id)
    {
        $product = product::find($id);

        if ($product->delete()) {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master product!'));
        } else {
            return redirect('/kasir/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master product!'));
        }
    }

    // master customer
    public function master_customer()
    {
        $customer = Customer::all();

        $parseData = [
            'title' => 'Master Customer | Kasir',
            'customer' => $customer
        ];

        return view('kasir.master.customer.index', $parseData);
    }

    public function master_customer_tambah_proses(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        $tambah = Customer::create([
            'id' => $this->generateCodeId('customer'),
            'name' => $r->name,
            'address' => $r->address,
            'phone_number' => $r->phone_number
        ]);

        if ($tambah) {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data Customer!'));
        } else {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master Customer!'));
        }
    }

    public function master_customer_ubah_proses(Request $r, $id)
    {
        $r->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        $customer = Customer::find($id);

        if ($customer == null) {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master Customer!'));
        }

        $customer->name = $r->name;
        $customer->address = $r->address;
        $customer->phone_number = $r->phone_number;

        if ($customer->save()) {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master Customer!'));
        } else {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master Customer!'));
        }
    }

    public function master_customer_hapus_proses($id)
    {
        $admin = Customer::find($id);

        if ($admin->delete()) {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master customer!'));
        } else {
            return redirect('/kasir/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master customer!'));
        }
    }

    // transaction
    public function transaction_view()
    {
        $products = Product::all();
        $customes = Customer::all();
        TransactionProductDetailTemp::truncate();

        $parseData = [
            'title' => 'Transaction',
            'products' => $products,
            'customers' => $customes
        ];

        return view('transaction.index', $parseData);
    }

    public function transaction_process(Request $r)
    {
        $temporary = TransactionProductDetailTemp::with('product')->get();
        $total = 0;
        foreach ($temporary as $key => $row) {
            $total += $row->product->price * $row->qty;
        }

        $transaction = Transaction::create([
            'id' => $this->generateCodeId('transaction'),
            'total' => $total,
            'customer_id' => $r->customer_id,
            'cashier_id' => Auth::user()->id
        ]);

        if ($transaction) {
            foreach ($temporary as $key => $r) {
                $product = Product::find($r->product_id);
                $product->stock = $product->stock - $r->qty;
                $product->save();
                TransactionProductDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $r->product_id,
                    'qty' => $r->qty,
                    'price' => $r->product->price,
                    'subtotal' => $row->product->price * $row->qty
                ]);
            }

            TransactionProductDetailTemp::truncate();

            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function temporary_insert(Request $r)
    {
        $isExist = TransactionProductDetailTemp::where('product_id', $r->id_item)->first();
        if ($isExist != null) {
            $isExist->qty = $isExist->qty + $r->qty;

            if ($isExist->save()) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 0]);
            }
        } else {
            $tambah = TransactionProductDetailTemp::create([
                'product_id' => $r->id_item,
                'qty' => $r->qty
            ]);

            if ($tambah) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 0]);
            }
        }
    }

    public function temporary_get(Request $r)
    {
        $data = TransactionProductDetailTemp::with('product')->get();

        if ($data) {
            $data = [
                'status' => 1,
                'data' => $data
            ];

            return response()->json($data);
        } else {
            $data = [
                'status' => 0,
                'data' => null
            ];

            return response()->json($data);
        }
    }

    public function temporary_delete(Request $r)
    {
        $data = TransactionProductDetailTemp::find($r->id);
        if ($data != null) {
            if ($data->delete()) {
                $data = [
                    'status' => 1
                ];

                return response()->json($data);
            } else {
                $data = [
                    'status' => 0
                ];

                return response()->json($data);
            }
        }
    }

    // master akun
    public function master_account()
    {
        $account = Account::all();

        $parseData = [
            'title' => 'Master Account | Kasir',
            'account' => $account
        ];

        return view('kasir.master.account.index', $parseData);
    }

    public function master_account_tambah_proses(Request $r)
    {
        $r->validate([
            'account_code' => 'required',
            'name' => 'required',
            'type_of_account' => 'required',
            'account_status' => 'required',
            'normal_saldo' => 'required'
        ]);

        $tambah = Account::create([
            'id' => $this->generateCodeId('account'),
            'account_code' => $r->account_code,
            'name' => $r->name,
            'type_of_account' => $r->type_of_account,
            'account_status' => $r->account_status,
            'normal_saldo' => $r->normal_saldo
        ]);

        if ($tambah) {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data account!'));
        } else {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master account!'));
        }
    }

    public function master_account_ubah_proses(Request $r, $id)
    {
        $r->validate([
            'account_code' => 'required',
            'name' => 'required',
            'type_of_account' => 'required',
            'account_status' => 'required',
            'normal_saldo' => 'required'
        ]);

        $akun = Account::find($id);

        if ($akun == null) {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master account!'));
        }

        $akun->account_code = $r->account_code;
        $akun->name = $r->name;
        $akun->type_of_account = $r->type_of_account;
        $akun->account_status = $r->account_status;
        $akun->normal_saldo = $r->normal_saldo;

        if ($akun->save()) {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master account!'));
        } else {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master account!'));
        }
    }

    public function master_account_hapus_proses($id)
    {
        $account = Account::find($id);

        if ($account->delete()) {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master account!'));
        } else {
            return redirect('/kasir/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master account!'));
        }
    }
}
