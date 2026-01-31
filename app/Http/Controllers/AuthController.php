<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            'username' => ['required','unique:users', 'not_regex:/[가-힣]|\s/u', 'max:255'],
            'password' => [
                'required',
                'min:8',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                'max:255'
            ]
        ], [
            'username.required' => '아이디부터 입력하셔야죠!',
            'username.unique' => '이미 있는 아이디네요...',
            'username.not_regex' => '혹시 아이디에 한글이나 공백 넣으신 건 아니죠..?',
            'username.max' => '아이디가 너무 길어요!',
            'password.required' => '비밀번호도 빼먹으셨어요!',
            'password.min' => '비밀번호는 8글자 이상으로 입력해주세요!',
            'password.max' => '비밀번호가 너무 길어요!',
            'password.regex' => '비밀번호에 특수문자 정도는 넣으셔야죠...',
        ]);

        User::create($validated);

        return redirect()->route('login')->with('message', "회원가입 성공하셨습니다! 아이디는 {$validated['username']}!");
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'username' => 'required|max:255',   
            'password' => 'required|max:255',
        ], [
            'username.max' => '그렇게 긴 아이디가 있을리 없잖아요..!',
            'username.required' => '아이디부터 입력하셔야죠!',
            'password.max' => '그렇게 긴 비밀번호가 있을리 없잖아요..!',
            'password.required' => '비밀번호도 빼먹으셨어요!',
        ]);

        if (auth()->attempt($validated)) {
            if (auth()->user()->role == 0) return redirect()->route('stores.index')->with('message', "안녕하세요! {$validated['username']}님!");
            else if (auth()->user()->role == 1) return redirect()->route('store_admin.index')->with('message', "안녕하세요! 서점 관리자 {$validated['username']}님!");
            else if (auth()->user()->role == 2) return redirect()->route('super_admin.index')->with('message', "안녕하세요! 관리자님!");
        }

        return back()->withInput()->with('message', '로그인에 실패했어요...');
    }

    public function logout() {
        $username = auth()->user()->username;

        auth()->logout();

        if ($username == 'admin') return redirect('/')->with('message', "관리자님 안녕히가세요!");

        return redirect('/')->with('message', "{$username}님 안녕히가세요!");
    }
}
