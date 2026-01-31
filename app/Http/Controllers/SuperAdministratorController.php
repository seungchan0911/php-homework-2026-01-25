<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;

class SuperAdministratorController extends Controller
{
    public function index() {
        $stores = Store::all();

        return view('store.index', compact('stores'));
    }

    public function showRegister() {
        return view('super_admin.register');
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'username' => 'required',
            'password' => [
                'required',
                'min:8',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
            ],
            'store' => 'required|exists:stores,name',
        ], [
            'username.required' => '아이디도 입력하셔야죠!',
            'username.unique' => '이미 있는 아이디네요...',
            'username.not_regex' => '혹시 아이디에 한글이나 공백 넣으신 건 아니죠..?',
            'username.max' => '아이디가 너무 길어요!',
            'password.required' => '비밀번호도 빼먹으셨어요!',
            'password.min' => '비밀번호는 8글자 이상으로 입력해주세요!',
            'password.max' => '비밀번호가 너무 길어요!',
            'password.regex' => '비밀번호에 특수문자 정도는 넣으셔야죠...',
            'store.required' => '서점부터 입력하셔야죠!',
            'store.exists' => '처음 보는 서점인데요..?',
        ]);

        $user = User::where('username', $validated['username'])->first();
        $store = Store::where('name', $validated['store'])->first();

        if (isset($store->user)) return back()->with('message', '이미 관리자가 있는 서점이네요...');

        if (isset($user)) {
            if (!Hash::check($validated['password'], $user->password)) return back()->withInput()->with('message', "비밀번호가 틀려요!");

            $user->role = 1;
            $user->store_id = $store->id;
            $user->save();

            return redirect()->route('super_admin.index')->with('message', "서점 관리자 등록을 완료했습니다!");
        }

        User::create([
            'username' => $validated['username'],
            'password' => $validated['password'],
            'store_id' => $store->id,
            'role' => 1,
        ]);

        return redirect()->route('super_admin.index')->with('message', "서점 관리자 계정을 새로 만들었어요!");
    }

    public function users() {
        $users = User::where('id', '!=', 'admin')->orderBy('role', 'desc')->get();

        return view('super_admin.users', compact('users'));
    }
}
