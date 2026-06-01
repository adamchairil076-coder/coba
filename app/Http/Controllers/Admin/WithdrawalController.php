<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['campaign', 'user'])
            ->latest()
            ->get();

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        $campaigns = Campaign::latest()->get();

        $campaignBalances = [];

        foreach ($campaigns as $campaign) {
            $totalWithdrawn = Withdrawal::where('campaign_id', $campaign->id)
                ->whereIn('status', ['pending', 'success'])
                ->sum('amount');

            $campaignBalances[$campaign->id] = $campaign->raised - $totalWithdrawn;
        }

        $banks = [
            'BCA',
            'BRI',
            'BNI',
            'Mandiri',
            'BSI',
            'CIMB Niaga',
            'Permata',
            'Danamon',
            'BTN',
            'Bank DKI',
            'Bank Jabar Banten',
        ];

        return view('admin.withdrawals.create', compact(
            'campaigns',
            'campaignBalances',
            'banks'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|min:8|max:20',
            'account_holder_name' => 'required|string|max:100',
            'amount' => 'required|numeric|min:10000',
            'description' => 'required|string',
        ]);

        $campaign = Campaign::findOrFail($request->campaign_id);

        $totalWithdrawn = Withdrawal::where('campaign_id', $campaign->id)
            ->whereIn('status', ['pending', 'success'])
            ->sum('amount');

        $availableBalance = $campaign->raised - $totalWithdrawn;

        $status = 'pending';
        $description = $request->description;

        if (!ctype_digit($request->account_number)) {
            $status = 'failed';
            $description .= ' | Penarikan ditolak karena nomor rekening tidak valid.';
        } elseif ($request->amount > $availableBalance) {
            $status = 'failed';
            $description .= ' | Penarikan ditolak karena saldo campaign tidak mencukupi.';
        } else {
            $status = 'success';
            $description .= ' | Transfer dana berhasil diproses.';
        }

        Withdrawal::create([
            'campaign_id' => $request->campaign_id,
            'user_id' => Auth::id(),
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_holder_name,
            'amount' => $request->amount,
            'status' => $status,
            'description' => $description,
        ]);

        if ($status == 'failed') {
            return redirect()
                ->route('admin.withdrawal.index')
                ->with('failed', 'Penarikan dana gagal diproses. Periksa saldo campaign atau nomor rekening.');
        }

        return redirect()
            ->route('admin.withdrawal.index')
            ->with('success', 'Penarikan dana berhasil diproses.');
    }
}