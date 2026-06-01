<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;
use App\Models\User;
use App\Models\Donation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
    
class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:member-list|member-create|member-edit|member-delete', ['only' => ['index','store']]);
        $this->middleware('permission:member-create', ['only' => ['create','store']]);
        $this->middleware('permission:member-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:member-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }
    
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.users.create', compact('roles'));
    }
    
    public function store(MemberRequest $request)
    {
        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);

        $user->assignRole($request->input('roles'));
    
        return redirect()
            ->back()
            ->with('success', 'User created successfully');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::pluck('name', 'name')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();
    
        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        if (!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);    
        }
    
        $user = User::findOrFail($id);

        $user->update($input);

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()
            ->route('admin.member')
            ->with('success', 'User updated successfully');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->route('admin.member')
            ->with('success', 'User deleted successfully');
    }

    public function donaturProfile()
    {
        $user = auth()->user();

        $donations = Donation::with('campaign')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $totalDonation = Donation::where('user_id', $user->id)
            ->where('status', 'PAID')
            ->sum('amount');

        $totalTransaction = Donation::where('user_id', $user->id)
            ->count();

        $successTransaction = Donation::where('user_id', $user->id)
            ->where('status', 'PAID')
            ->count();

        $pendingTransaction = Donation::where('user_id', $user->id)
            ->where('status', 'PENDING')
            ->count();

        $campaignSupported = Donation::where('user_id', $user->id)
            ->where('status', 'PAID')
            ->distinct('campaign_id')
            ->count('campaign_id');

        return view('donatur.profile', compact(
            'user',
            'donations',
            'totalDonation',
            'totalTransaction',
            'successTransaction',
            'pendingTransaction',
            'campaignSupported'
        ));
    }
}