<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function messageSweetAlert($icon, $title, $text)
    {
        return ['sweetAlertMessage' => ['icon' => $icon, 'title' => $title, 'text' => $text]];
    }

    public function generateCodeId($type)
    {
        $prefixUser = "1169";
        $prefixCustomer = "1269";
        $prefixTreatment = "1369";
        $prefixProduct = "1469";
        $prefixAccount = "1569";
        $prefixTrx = "1669" . date('my');
        $prefixJournal = "1769";

        if ($type == 'user') {
            $user = User::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($user != null) {
                $id = substr($user->id, 4, 3);
                $id = sprintf("%03d", $id + 1);
                $id = $prefixUser . $id;
            } else {
                $id = $prefixUser . "001";
            }
        } else if ($type == 'customer') {
            $customer = Customer::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($customer != null) {
                $id = substr($customer->id, 4, 3);
                $id = sprintf("%03d", $id + 1);
                $id = $prefixCustomer . $id;
            } else {
                $id = $prefixCustomer . "001";
            }
        } else if ($type == 'treatment') {
            $treatment = Treatment::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($treatment != null) {
                $id = substr($treatment->id, 4, 3);
                $id = sprintf("%03d", $id + 1);
                $id = $prefixTreatment . $id;
            } else {
                $id = $prefixTreatment . "001";
            }
        } else if ($type == 'product') {
            $product = Product::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($product != null) {
                $id = substr($product->id, 4, 3);
                $id = sprintf("%03d", $id + 1);
                $id = $prefixProduct . $id;
            } else {
                $id = $prefixProduct . "001";
            }
        } else if ($type == 'account') {
            $account = Account::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($account != null) {
                $id = substr($account->id, 4, 3);
                $id = sprintf("%03d", $id + 1);
                $id = $prefixAccount . $id;
            } else {
                $id = $prefixAccount . "001";
            }
        } else if ($type == 'transaction') {
            $trx = Transaction::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($trx != null) {
                $id = substr($trx->id, 4, 3);
                $id = sprintf("%03d", $id + 1);
                $id = $prefixTrx . $id;
            } else {
                $id = $prefixTrx . "001";
            }
        } else if ($type == 'jurnal') {
            $jrnl = Transaction::orderBy('created_at', 'desc')->limit(1)->first('id');
            if ($jrnl != null) {
                $id = substr($jrnl->id, 8, 3);
                $id = sprintf("%03d", ($id + 1));
                $id = $prefixJournal . $id;
            } else {
                $id = $prefixJournal . "001";
            }
        } else {
            $id = null;
        }

        return $id;
    }
}
