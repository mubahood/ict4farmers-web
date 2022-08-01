<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function update_profile(Request $r)
    {
        $id = ((int)($r->id));
        if ($id < 1) {
            dd("creating");
        }

        $u = new User();
        if ($id > 0) {
            $u = User::find($id);
        }
        if ($u == null) {
            dd("user not found.");
        }


        if (isset($_FILES['avatar'])) {

            $img = $_FILES['avatar'];
            if ($img['error'] == 0) {
                $raw_images = [];
                $raw_images['name'][] = $img['name'];
                $raw_images['type'][] = 'image/png';
                $raw_images['tmp_name'][] = $img['tmp_name'];
                $raw_images['error'][] = $img['error'];
                $raw_images['size'][] = $img['size'];

                $temp_img = Utils::upload_images($raw_images);
                if ($temp_img != null) {
                    if (isset($temp_img[0])) {
                        $u->avatar = $temp_img[0]['src'];
                    }
                }
            }
        }


        $u->name = $r->name;
        if ($u->email == null) {
            $u->email = $u->username;
        }
        if ($u->username == null) {
            $u->username = $u->email;
        }

        $u->last_name = $r->name;
        $u->phone_number = $r->phone_number;
        $u->company_name = $r->company_name;
        $u->category_id = $r->category_id;
        $u->services = $r->services;
        $u->sub_county = $r->sub_county;
        $u->address = $r->address;
        $u->facebook = $r->facebook;
        $u->twitter = $r->twitter;
        $u->whatsapp = $r->whatsapp;
        $u->youtube = $r->youtube;
        $u->instagram = $r->instagram;
        $u->linkedin = $r->linkedin;
        $u->about = $r->about;
        $u->save();
        return redirect('dashboard');
    }

    public function logout()
    {
        die("logout...");
    }

    public function index()
    {
        die("listing...");
        return view('metro.auth.register');
    }

    public function login()
    {
        return view('metro.auth.login');
    }


    public function register()
    {
        return view('metro.auth.register');
    }

    public function do_login(Request $request)
    {
        $this->validate(
            $request,
            [
                'phone_number' => 'required|min:4',
                'password' => 'required|min:4',
            ]
        );

        $phone_number = Utils::prepare_phone_number($request->phone_number);
        if (!Utils::phone_number_is_valid($phone_number)) {
            return back()->withInput()->withErrors([
                'phone_number' => 'Enter a valid phone number.',
            ]);
        }

        $u = Administrator::where([
            'username' => $phone_number
        ])->orWhere([
            'email' => $phone_number
        ])->orWhere([
            'phone_number' => $phone_number
        ])->first();
        if ($u == null) {
            return back()->withInput()->withErrors([
                'phone_number' => 'Phone number not found.',
            ]);
        }

        if (!password_verify($request->password, $u->password)) {
            return back()->withInput()->withErrors([
                'password' => 'You entered a wrong password.',
            ]);
        }


        $password = $request->password;

        $old_user = User::where('phone_number', $phone_number)->first();

        if ($old_user == null) {
            $old_user = User::where('phone_number', $phone_number)->first();
        }

        if ($old_user  == null) {
            $errors['phone_number'] = "An account with the provided phone number does not exist.";
            return redirect('login')
                ->withErrors($errors)
                ->withInput();
            // die();
        }

        $_u['phone_number'] = $phone_number;
        $_u['password'] = $password;

        if (Auth::attempt($_u, true)) {
            return redirect('dashboard');
        } else {
            $errors['password'] = "You entered a wrong password.";
            return redirect('login')
                ->withErrors($errors)
                ->withInput();
        }
        // die();
    }


    public function store(Request $request)
    {

        $phone_number = Utils::prepare_phone_number($request->phone_number);
        if (!Utils::phone_number_is_valid($phone_number)) {
            return back()->withInput()->withErrors([
                'phone_number' => 'Enter a valid phone number.',
            ]);
        }
        $u = Administrator::where([
            'username' => $phone_number
        ])->orWhere([
            'email' => $phone_number
        ])->orWhere([
            'phone_number' => $phone_number
        ])->first();
        if ($u != null) {
            return back()->withInput()->withErrors([
                'phone_number' => 'Account with same phone number already exist.',
            ]);
        }


        $request->validate([
            'name' => 'required|min:2',
            'password' => 'required|confirmed|min:4'
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->username = $phone_number;
        $admin->phone_number = $phone_number;
        $admin->password = Hash::make($request->input("password"));

        if ($admin->save()) {
            DB::table('admin_role_users')->insert([
                'role_id' => 2,
                'user_id' => $admin->id
            ]);
        } else {
            $errors['phone_number'] = "Failed to created your account. Please try again.";
            return redirect('register')
                ->withErrors($errors)
                ->withInput();
            // die();
        }

        $password = $request->password;
        $_u['phone_number'] = $phone_number;
        $_u['password'] = $password;
        $remember = $request->get('remember', true);

        if (Auth::attempt($_u, $remember)) {
            admin_toastr(trans('admin.login_successful'));
            $request->session()->regenerate();
            return redirect()->intended('admin');
            die();
        }

        return back()->withErrors([
            'phone_number' => 'The provided credentials do not match our records.',
        ]);

        return view('metro.auth.register');
    }


    public function show($id)
    {
        die("show");
        //
    }



    public function edit($id)
    {
        die("edit");
        //
    }



    public function update(Request $request, $id)
    {
        die("update");
        //
    }


    public function destroy($id)
    {
        die("deleint..");
        //
    }
}
