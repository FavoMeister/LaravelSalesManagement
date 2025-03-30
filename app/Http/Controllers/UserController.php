<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    /* public function FirstUser()
    {
        User::create([
            'name' => 'Harry Kane',
            'email' => 'admin@gmail.com',
            'photo' => '',
            'status' => 1,
            'last_login' => '',
            'role' => 'Administrator',
            'branch_id' => 0,
            'password' => Hash::make('123456'),
        ]);
    } */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 'Administrator') {
            return redirect('index');
        }
        //$users = User::orderBy('id', 'desc');
        $users = User::all();
        $branches = Branch::where('status', 1)->get();
        //dd($users->first()->branch);
                //->where('roles.id','!=',1)
                //->paginate(10);

        return view('modules.users.users')->with([
            'users' => $users,
            'branches' => $branches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $emailValidation = request()->validate([
            'email' => ['unique:users']
        ]);
        $data = request();
        if ($data['role'] != 'Administrator') {
            # code...
        } else {
            # code...
        }
        

        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        //$user->branch_id = $request->branch_id;
        //$enterprise=session('company');
        //$branch->company_id=$enterprise->id;
        $user->save();
        return redirect('usuarios')->with('success', 'El usuario a sido creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateData(Request $request)
    {
        //dd(Auth::user()->email, request('email'));
        if (Auth::user()->email != request('email')) {
            if(request('password')){
                $data = request()->validate([
                    'name' => ['required', 'string', 'max:50'],
                    'email' => ['required', 'email', 'unique:users'],
                    'password' => ['required', 'string', 'min:8'],
                ]);
            }else {
                $data = request()->validate([
                    'name' => ['required', 'string', 'max:50'],
                    'email' => ['required', 'email', 'unique:users'],
                ]);
            }
        } else {
            if(request('password')){
                $data = request()->validate([
                    'name' => ['required', 'string', 'max:50'],
                    'email' => ['required', 'email'],
                    'password' => ['required', 'string', 'min:8'],
                ]);
            }else {
                $data = request()->validate([
                    'name' => ['required', 'string', 'max:50'],
                    'email' => ['required', 'email'],
                ]);
            }
        }
        //dd(Auth::user()->email, request('profilePhoto'));
        if (request('profilePhoto')) {
            if (Auth::user()->photo != '') {
                $path = storage_path('app/public/'.Auth::user()->photo);
                unlink($path);
            } else {
                # code...
            }
            $imgRoute = $request['profilePhoto']->store('users', 'public');
            
        } else {
            $imgRoute = Auth::user()->photo;
        }
        //dd($imgRoute);
        if (isset($data['password'])) {
            DB::table('users')->where('id', Auth::user()->id)
                            ->update([
                                'name' => $data["name"],
                                'email' => $data["email"],
                                'photo' => $imgRoute,
                                'password' => Hash::make($data["password"]),
                            ]);
        } else {
            DB::table('users')->where('id', Auth::user()->id)
                            ->update([
                                'name' => $data["name"],
                                'email' => $data["email"],
                                'photo' => $imgRoute,
                               
                            ]);
        }
        return redirect('mis-datos');
    }


    public function changeStatus($user_id)
    {
        $user = User::find($user_id);
        
        if ($user != null) {
            $user->status = $user->status == 1 ? 0 : 1;
            $user->update();
            return response()->json([
                'user' => $user,
            ]);
            //return redirect('usuarios')->with('success', 'El estado del usuario {$user->name} ha sido actualizada correctamente');
        } else {
            return response()->json([
                'user' => null,
            ]);
        }
    }
}
