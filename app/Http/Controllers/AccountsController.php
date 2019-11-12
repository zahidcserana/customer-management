<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Customer;
use Validator;
use DB;
use PDF;
use Auth;
use Session;

class AccountsController extends Controller
{
    /*
     * Customer Form
     */
    public function form()
    {
        $data = array(
            'customers' => DB::table('customers')->get()
        );
        return view('accounts.add', $data);
    }

    /*
     * Add
     */
    public function add(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'amount' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        $data['company_id'] = Auth::user()->company_id;
        $data['status'] = 'PAID';
        if($data['amount'] == $data['due']) {
           $data['status'] = 'DUE';
        } else if($data['due'] > 0 && ($data['amount'] > $data['due'])) {
           $data['status'] = 'PARTIAL PAID';
        }

        $accountId = DB::table('accounts')->insertGetid($data);
        $this->_getInvoice($accountId);

        return redirect()->route('accounts');
    }

    private function _getInvoice($id) {
        $idLength = strlen($id);
        $invoice = $id;
        for($i=0; $i < 6 - $idLength; $i++){
            $invoice .= rand(0, 9);
        }
        DB::table('accounts')->where('id', $id)->update(['invoice'=>$invoice]);
        return;
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Accounts';

        return view('accounts.index', $data);
    }

    public function accountsList(Request $request)
    {
        $query = $request->query('query');

        $conditions = array();
        if (isset($query['name']) && !empty($query['name'])) {
            $conditions = array_merge(array(['customers.name', 'LIKE', '%' . $query['name'] . '%']), $conditions);
        }
        if (isset($query['email']) && !empty($query['email'])) {
            $conditions = array_merge(array(['customers.email', 'LIKE', '%' . $query['email'] . '%']), $conditions);
        }
        if (isset($query['mobile']) && !empty($query['mobile'])) {
            $conditions = array_merge(array(['customers.mobile', 'LIKE', '%' . $query['mobile'] . '%']), $conditions);
        }
        if (isset($query['status']) && !empty($query['status'])) {
            $conditions = array_merge(array('accounts.status' => $query['status']), $conditions);
        }
        $accounts = DB::table('customers')->Join('accounts', 'accounts.customer_id', '=', 'customers.id')->where($conditions)
        ->orderBy('accounts.id','desc')
        ->get();
        $amount_total = 0;
        $pay_total = 0;
        $due_total = 0;
        foreach ($accounts as $i=>$account) {
            $amount_total += $account->amount;
            $pay_total += $account->pay;
            $due_total += $account->due;
            $sl = $i + 1;
            $account->download = '<a href="/accounts/' . $account->id . '/download" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only"><i class="fa flaticon-clock"></i>' . $sl . '</a>';
            $account->created_at = date("M j, Y, g:i a", strtotime($account->created_at));
            $account->customer_name = '<a href="/accounts/' . $account->id . '">' . $account->name . '</a>';
            $account->customer = ['name' => $account->name, 'mobile' => $account->mobile];
            $account->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="/accounts/' . $account->id . '">Edit</a></li>
                    <li><a onclick="return confirm(\'Are you sure?\')" href="/accounts/' . $account->id . '/delete">Delete</a></li>
                  </ul>
                </div>
					';
        }
        $data['data'] = $accounts;
        $data['summary'] = array(
        'amount_total' => $amount_total,
        'pay_total' => $pay_total,
        'due_total' => $due_total,
        );

        echo json_encode($data);
    }

    /*
     * View Customer
     */
    public function view($id,Request $request)
    {
        $account = DB::table('customers')
        ->Join('accounts', 'accounts.customer_id', '=', 'customers.id')
        ->Join('companies', 'companies.company_row_id', '=', 'accounts.company_id')
        ->where('accounts.id', $id)
        ->first();
        if (empty($account)) {
            return redirect()->route('accounts');
        }
        $account->description = json_decode($account->description);
        $request->session()->put('account', $account);
        $data = array(
            'account' => $account,
            'customers' => DB::table('customers')->get(),
        );
        return view('accounts.view', $data);
    }

    public function download($id)
    {
        $account = DB::table('customers')
        ->Join('accounts', 'accounts.customer_id', '=', 'customers.id')
        ->Join('companies', 'companies.company_row_id', '=', 'accounts.company_id')
        ->where('accounts.id', $id)
        ->first();
        if (empty($account)) {
            return redirect()->route('accounts');
        }
        $account->description = json_decode($account->description);

        $pdf = PDF::loadView('accounts.pdf', compact('account'))->setPaper('a4', 'portrait');

        return $pdf->download('account.pdf');
    }

    public function edit($id = null, Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'amount' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        $data['status'] = 'PAID';
        if($data['amount'] == $data['due']) {
           $data['status'] = 'DUE';
        } else if($data['due'] > 0 && ($data['amount'] > $data['due'])) {
           $data['status'] = 'PARTIAL PAID';
        }
        DB::table('accounts')->where('id', $id)->update($data);
        return redirect()->route('accounts');
    }

    public function downloadPDF(Request $request)
    {
        $account = $request->session()->get('account');
        $pdf = PDF::loadView('accounts.pdf', compact('account'))->setPaper('a4', 'portrait');

        return $pdf->download('account.pdf');
    }

    /*
     * Delete an account
     */
    public function delete($id)
    {
        DB::table('accounts')->where('id', $id)->delete();
        return redirect()->route('accounts');
    }
}
