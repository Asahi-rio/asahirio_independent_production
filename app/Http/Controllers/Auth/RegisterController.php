<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * 会員登録画面の表示
     */
    public function registerScreen()
        {
        return view('Auth.register');
        }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * 会員登録
     *
     * @param Request $request
     * @param Response
     */
    protected function create(Request $request){

        //バリデーションルールの定義
        $validator = $request->validate(
        [
            'name' => ['required', 'string', 'max:255'],//名前は必須の255文字
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],//メールは必須の255文字以内
            'password' => ['required', 'string', 'min:8','max:255', 'confirmed'],//パスワードは必須の8文字以上255文字以内
            'password_confirmation' => ['required','string','min:8','max:255','same:password'], //確認用パスワード欄
        ],[
            //み入力エラー
            'name.required' => '名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
            ///フォームの入力値がmax超えた場合だった場合
            'name.max' => 'ユーザーネームを255文字以内で入力してください',
            'email.max' => 'メールアドレスを255文字以内で入力してください',
            'password.max' => 'パスワードを255文字以内でで入力してください',
            'password_confirmation.max' => '確認用パスワードを255文字以内でで入力してください',
            ///パスワードが8文字以上で入力されていない場合
            'password.min' => 'パスワードを8文字以上で入力してください',
            ///パスワードと確認用パスが一致しない場合
            'password.confirmed' => 'パスワードと確認用パスワードが一致しません',
            ///メールアドレスが重複している場合
            'email.unique' => 'このアカウントは既に登録されています',  
        ]);  

        //ユーザーモデルを使ってデータベースに新しいユーザーを登録
        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
        ]);

        return redirect('/');        
    }

}