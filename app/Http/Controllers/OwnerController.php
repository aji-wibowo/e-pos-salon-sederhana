<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\JournalTransaction;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProductDetail;
use App\Models\TransactionProductDetailTemp;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;

class OwnerController extends Controller
{
    public function index()
    {
        $parseData = [
            'title' => 'Home | Owner'
        ];
        return view('owner.home', $parseData);
    }

    // master user
    public function master_user_tambah_proses(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'email' => 'required|unique:App\Models\User,email',
            'password' => 'required|min:6',
            'level' => 'required'
        ]);

        $tambah = User::create([
            'id' => $this->generateCodeId('user'),
            'name' => $r->name,
            'email' => $r->email,
            'password' => Hash::make($r->password),
            'level' => $r->level
        ]);

        if ($tambah) {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data User!'));
        } else {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master User!'));
        }
    }

    public function master_user()
    {
        $users = User::all();
        $parseData = [
            'title' => 'Master | User',
            'user' => $users
        ];

        return view('owner.master.user.index', $parseData);
    }

    public function master_user_ubah_proses(Request $r, $id)
    {
        $r->validate([
            'name' => 'required',
            'email' => 'required',
            'level' => 'required'
        ]);

        $admin = User::find($id);

        if ($admin == null) {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master User!'));
        }

        if ($r->email != $admin->email) {
            $isEmailExist = User::where('email', $r->email)->get();

            if ($isEmailExist->count() > 0) {
                return redirect('/owner/master/user')->with($this->messageSweetAlert('error', 'Maaf!', 'Email telah digunakan!'));
            }

            $admin->email = $r->email;
        }

        if ($r->password) {
            $admin->password = Hash::make($r->password);
        }

        $admin->name = $r->name;
        $admin->level = $r->level;

        if ($admin->save()) {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master User!'));
        } else {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master User!'));
        }
    }

    public function master_user_hapus_proses($id)
    {
        $admin = User::find($id);

        if ($admin->delete()) {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master user!'));
        } else {
            return redirect('/owner/master/user')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master user!'));
        }
    }

    // master customer
    public function master_customer()
    {
        $customer = Customer::all();

        $parseData = [
            'title' => 'Master Customer | Owner',
            'customer' => $customer
        ];

        return view('owner.master.customer.index', $parseData);
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
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data Customer!'));
        } else {
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master Customer!'));
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
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master Customer!'));
        }

        $customer->name = $r->name;
        $customer->address = $r->address;
        $customer->phone_number = $r->phone_number;

        if ($customer->save()) {
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master Customer!'));
        } else {
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master Customer!'));
        }
    }

    public function master_customer_hapus_proses($id)
    {
        $admin = Customer::find($id);

        if ($admin->delete()) {
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master customer!'));
        } else {
            return redirect('/owner/master/customer')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master customer!'));
        }
    }

    // master treatment
    public function master_treatment()
    {
        $treatment = Treatment::all();

        $parseData = [
            'title' => 'Master Treatment | Owner',
            'treatment' => $treatment
        ];

        return view('owner.master.treatment.index', $parseData);
    }

    public function master_treatment_tambah_proses(Request $r)
    {
        $r->validate([
            'name' => 'required',
            'type_of_hair' => 'required',
            'price' => 'required'
        ]);

        $tambah = Treatment::create([
            'id' => $this->generateCodeId('treatment'),
            'name' => $r->name,
            'type_of_hair' => $r->type_of_hair,
            'price' => $r->price
        ]);

        if ($tambah) {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data Treatment!'));
        } else {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master Treatment!'));
        }
    }

    public function master_treatment_ubah_proses(Request $r, $id)
    {
        $r->validate([
            'name' => 'required',
            'type_of_hair' => 'required',
            'price' => 'required'
        ]);

        $treatment = Treatment::find($id);

        if ($treatment == null) {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master Treatment!'));
        }

        $treatment->name = $r->name;
        $treatment->type_of_hair = $r->type_of_hair;
        $treatment->price = $r->price;

        if ($treatment->save()) {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master Treatment!'));
        } else {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master Treatment!'));
        }
    }

    public function master_treatment_hapus_proses($id)
    {
        $treatment = Treatment::find($id);

        if ($treatment->delete()) {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master treatment!'));
        } else {
            return redirect('/owner/master/treatment')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master treatment!'));
        }
    }

    // master produk
    public function master_product()
    {
        $product = Product::all();

        $parseData = [
            'title' => 'Master Product | Owner',
            'product' => $product
        ];

        return view('owner.master.product.index', $parseData);
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
            return redirect('/owner/master/product')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data product!'));
        } else {
            return redirect('/owner/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master product!'));
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
            return redirect('/owner/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master product!'));
        }

        $product->name = $r->name;
        $product->stock = $r->stock;
        $product->unit = $r->unit;
        $product->price = $r->price;

        if ($product->save()) {
            return redirect('/owner/master/product')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master product!'));
        } else {
            return redirect('/owner/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master product!'));
        }
    }

    public function master_product_hapus_proses($id)
    {
        $product = product::find($id);

        if ($product->delete()) {
            return redirect('/owner/master/product')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master product!'));
        } else {
            return redirect('/owner/master/product')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master product!'));
        }
    }

    // master akun
    public function master_account()
    {
        $account = Account::all();

        $parseData = [
            'title' => 'Master Account | Owner',
            'account' => $account
        ];

        return view('owner.master.account.index', $parseData);
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
            return redirect('/owner/master/account')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data account!'));
        } else {
            return redirect('/owner/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data master account!'));
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
            return redirect('/owner/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master account!'));
        }

        $akun->account_code = $r->account_code;
        $akun->name = $r->name;
        $akun->type_of_account = $r->type_of_account;
        $akun->account_status = $r->account_status;
        $akun->normal_saldo = $r->normal_saldo;

        if ($akun->save()) {
            return redirect('/owner/master/account')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil mengubah data master account!'));
        } else {
            return redirect('/owner/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal mengubah data master account!'));
        }
    }

    public function master_account_hapus_proses($id)
    {
        $account = Account::find($id);

        if ($account->delete()) {
            return redirect('/owner/master/account')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data master account!'));
        } else {
            return redirect('/owner/master/account')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data master account!'));
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

    // transaction jurnal
    public function transaction_jurnal()
    {
        $account = Account::all();
        $transactions = Transaction::all();
        $jurnal = JournalTransaction::with('account', 'transaction')->get();

        $parseData = [
            'title' => 'Transaksi Jurnal | Owner',
            'account' => $account,
            'transaction' => $transactions,
            'jurnal' => $jurnal
        ];

        return view('transaction.jurnal.index', $parseData);
    }

    public function transaction_jurnal_post(Request $r)
    {
        $r->validate([
            'transaction_id' => 'required',
            'account_id' => 'required'
        ]);

        $tambah = JournalTransaction::create([
            'id' => $this->generateCodeId('jurnal'),
            'transaction_id' => $r->transaction_id,
            'account_id' => $r->account_id,
            'notes' => $r->notes
        ]);

        if ($tambah) {
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data jurnal!'));
        } else {
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data jurnal!'));
        }
    }

    public function transaction_jurnal_post_edit(Request $r)
    {
        $r->validate([
            'transaction_id' => 'required',
            'account_id' => 'required'
        ]);

        $find = JournalTransaction::find($r->id);

        if ($find == null) {
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data jurnal! id tidak ditemukan!'));
        }

        $find->transaction_id = $r->transaction_id;
        $find->account_id = $r->account_id;
        $find->notes = $r->notes;

        if ($find->save()) {

            // dd($r->notes, $find->notes);
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menambah data jurnal!'));
        } else {
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menambah data jurnal!'));
        }
    }

    public function transaction_jurnal_hapus_proses($id)
    {
        $jurnal = JournalTransaction::find($id);

        if ($jurnal->delete()) {
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('success', 'Selamat!', 'Anda telah berhasil menghapus data jurnal!'));
        } else {
            return redirect('/owner/transaction/jurnal')->with($this->messageSweetAlert('error', 'Maaf!', 'Anda telah gagal menghapus data jurnal!'));
        }
    }

    public function transaction_report_view()
    {
        $parseData = [
            'title' => 'Laporan Transaksi'
        ];

        return view('transaction.report.index', $parseData);
    }

    public function transaction_report_process(Request $r)
    {
        $r->validate([
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        $transactions = Transaction::with('customer', 'cashier', 'jurnal.account')->whereBetween('transactions.created_at', [$r->date_from, $r->date_to])->get();

        $parseData = [
            'transactions' => $transactions,
            'date_from' => $r->date_from,
            'date_to' => $r->date_to,
        ];

        $pdf = PDF::loadView('transaction.report.cetak', $parseData);

        return $pdf->stream('laporan_transaksi.pdf');
    }
}
