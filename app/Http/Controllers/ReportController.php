<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::latest()->get();

        $query = Donation::with('campaign')->latest();

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $summaryQuery = clone $query;

        $donations = $query->paginate(10)->withQueryString();

        $totalTransaction = $summaryQuery->count();
        $totalDonation = $summaryQuery->sum('amount');

        $selectedCampaign = null;

        if ($request->filled('campaign_id')) {
            $selectedCampaign = Campaign::find($request->campaign_id);
        }

        $statuses = Donation::select('status')
            ->whereNotNull('status')
            ->distinct()
            ->pluck('status');

        return view('admin.reports.index', compact(
            'campaigns',
            'donations',
            'totalTransaction',
            'totalDonation',
            'selectedCampaign',
            'statuses'
        ));
    }

    public function download(Request $request)
    {
        $query = Donation::with('campaign')->latest();

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $donations = $query->get();

        $totalTransaction = $donations->count();
        $totalDonation = $donations->sum('amount');

        $selectedCampaign = null;

        if ($request->filled('campaign_id')) {
            $selectedCampaign = Campaign::find($request->campaign_id);
        }

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'donations',
            'totalTransaction',
            'totalDonation',
            'selectedCampaign',
            'request'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-donasi.pdf');
    }
}