<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\LoginUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * ログイン画面の表示
     */
    public function login()
        {
        return view('auth.login');
        }

    /**
     * ログイン
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function signin(Request $request)
    {
         //バリデーションルールの定義
         $validator = $request->validate(
        [
            'email' => ['required', 'string', 'email', 'max:255'],//メールは必須の255文字以内
            'password' => ['required', 'string', 'min:8','max:255'],//パスワードは必須の8文字以上255文字以内
        ],[
            //み入力エラー
            'email.required' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
            //文字数オーバー
            'email.max' => 'メールアドレスを255文字以内で入力してください',
            'password.max' => 'パスワードを255文字以内でで入力してください',
            ///パスワードが8文字以上で入力されていない場合
            'password.min' => 'パスワードを8文字以上で入力してください', 
        ]); 
        
            // メールアドレスでユーザーを検索
            $user = User::where('email', $request->email)->first();

            // ユーザーが存在し、パスワードが正しいかを確認
            if ($user && Hash::check($request->password, $user->password)) {
                // ログイン処理
                \Auth::login($user);
                // ログイン後にリダイレクト
                return redirect('/home');
            }else{
            // エラーがあった場合、再度ログインフォームに戻す
            return redirect()->back()->with('error','メールアドレスまたはパスワードが間違っています。');
        }
             
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
