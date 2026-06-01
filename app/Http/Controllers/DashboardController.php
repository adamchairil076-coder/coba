<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Post;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\SettingRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = Activity::where('causer_id', auth()->id())
            ->latest()
            ->paginate(5);

        $totalCampaign = Campaign::count();
        $totalDonation = Donation::count();
        $totalDana = Donation::sum('amount');
        $totalArticle = Post::count();
        $totalContact = Contact::count();

        $campaignAktif = Campaign::whereDate('deadline', '>=', now())->count();
        $campaignSelesai = Campaign::whereDate('deadline', '<', now())->count();

        $donasiTerbaru = Donation::with('campaign')
            ->latest()
            ->limit(5)
            ->get();

        $campaignTerbaru = Campaign::latest()
            ->limit(5)
            ->get();

        $donasiBulanan = Donation::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $chartLabels = [];
        $chartData = [];

        foreach ($donasiBulanan as $item) {
            $chartLabels[] = $namaBulan[$item->bulan];
            $chartData[] = $item->total;
        }

        return view('admin.dashboard', compact(
            'logs',
            'totalCampaign',
            'totalDonation',
            'totalDana',
            'totalArticle',
            'totalContact',
            'campaignAktif',
            'campaignSelesai',
            'donasiTerbaru',
            'campaignTerbaru',
            'chartLabels',
            'chartData'
        ));
    }

    public function activity_logs()
    {
        $logs = Activity::where('causer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('admin.logs', compact('logs'));
    }

    public function settings_store(SettingRequest $request)
    {
    	if($request->file('logo')) {
	    	$filename = $request->file('logo')->getClientOriginalName();
	    	$filePath = $request->file('logo')->storeAs('uploads', $filename, 'public');
	    	setting()->set('logo', $filePath);
    	}

    	setting()->set('site_name', $request->site_name);
    	setting()->set('keyword', $request->keyword);
    	setting()->set('description', $request->description);
    	setting()->set('url', $request->url);

    	setting()->save();

    	return redirect()->back()->with('success', 'Settings has been successfully saved');
    }

    public function profile_update(Request $request)
    {
        $data = ['name' => $request->name];

        if($request->old_password && $request->new_password) {
            if(!Hash::check($request->old_password, auth()->user()->password)) {
                session()->flash('failed', 'Password is wrong!');
                return redirect()->back();
            }

            $data['password'] = Hash::make($request->new_password);
        } 

        if($request->avatar) {
            $data['avatar'] = $request->avatar;

            if(auth()->user()->avatar) {
                $avatarPath = storage_path('app/public/'.auth()->user()->avatar);

                if(file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }
        }
        
        auth()->user()->update($data);
        
        return redirect()->back()->with('success', 'Profile updated!');
    }

    public function upload_avatar(Request $request)
    {
        $request->validate([
            'avatar'  => 'file|image|mimes:jpg,png,svg|max:10240'
        ]);

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');

            $fileName = $file->getClientOriginalName();
            $folder = 'user-'.auth()->id();

            $file->storeAs('avatars/'.$folder, $fileName, 'public');

            return 'avatars/'.$folder.'/'.$fileName;
        }

        return '';
    }

    public function delete_logs()
    {
        $logs = Activity::where('created_at', '<=', Carbon::now()->subWeeks())->delete();

        return back()->with('success', $logs.' Logs successfully deleted!');
    }
}