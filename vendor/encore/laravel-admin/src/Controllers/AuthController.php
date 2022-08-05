<?php

namespace Encore\Admin\Controllers;

use App\Models\Category;
use App\Models\FarmersGroup;
use App\Models\User;
use App\Models\Utils;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid\Tools\Header;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @var string
     */
    protected $loginView = 'admin::login';

    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view($this->loginView);
    }

    /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
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
        if ($u == null) {
            return back()->withInput()->withErrors([
                'phone_number' => 'Phone number not found on our database.',
            ]);
        }

        if (!password_verify($request->password, $u->password)) {
            return back()->withInput()->withErrors([
                'password' => 'You entered a wrong password. . Try 4321',
            ]);
        }

        $u->username = $phone_number;
        //$u->email = $phone_number;
        $u->phone_number = $phone_number;
        $u->save();

        $credentials = [
            'username' => $phone_number,
            'password' => $request->password
        ];

        //$this->loginValidator($request->all())->validate();
        //$credentials = $request->only([$this->username(), 'password']);
        $remember = $request->get('remember', true);
        $remember = true;

        if ($this->guard()->attempt($credentials, $remember)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withInput()->withErrors([
            $this->username() => $this->getFailedLoginMessage(),
        ]);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(config('admin.route.prefix'));
    }

    /**
     * User setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {
        $form = $this->settingForm();
        $form->tools(
            function (Form\Tools $tools) {
                $tools->disableList();
                $tools->disableDelete();
                $tools->disableView();
            }
        );

        return $content
            ->title('My profile')
            ->body($form->edit(Admin::user()->id));
    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        return $this->settingForm()->update(Admin::user()->id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {

        $u = Auth::user();
        $x = User::find($u->id);

        $group_id = ((int)($x->group_id));
        if ($x->first_name != null) {
            if (strlen($x->first_name) > 3) {
                if ($x != null) {
                    $x->profile_is_complete =  1;
                    $x->save();
                } else {
                    die("Account not found");
                }
            } 
        }
        $x = User::find($u->id);


        if ($x->profile_is_complete == '1') {
            if (!Utils::is_wizard_done($x->id)) {

                header("Location: " . admin_url(''));
                die();
            }
        }

        $class = config('admin.database.users_model');

        $form = new Form(new $class());

        $form->disableReset();
        $form->disableViewCheck();
        $form->disableEditingCheck();
        $form->disableCreatingCheck();


        $form->tab('BASIC INFO', function (Form $form) {
            $u = Admin::user();
            $form->text('first_name')->rules('required');
            $form->text('last_name')->rules('required');
            $form->radio('gender', 'Sex')->options(['Male' => 'Male', 'Female' => 'Female'])->rules('required');
            $form->text('date_of_birth', 'Age')->rules('required');
            $form->text('phone_number_2', 'Phone number 2');
            $form->text('email', 'Email address');
            $form->text('address', 'Premises address');
        });



        $form->tab('USER ROLE', function (Form $form) {
            $u = Admin::user();

            $form->text('name', 'Your enterprise/business name')
                ->rules('required');
            $form->select(
                'production_scale',
                'Production scale'
            )->options([
                'Subsistence production' => 'Subsistence production',
                'Large Commercial Production' => 'Large Commercial Production',
                'Small Commercial Production' => 'Small Commercial Production'
            ])->rules('required');

            $form->select('category_id', 'Sector of specialization')->options([
                'Crop farming' => 'Crop farming',
                'Livestock farming' => 'Livestock farming',
                'Fisheries' => 'Fisheries',
            ])->rules('required');

            $form->radio('user_role', 'Your role')->options([
                'Farmer' => 'Farmer',
                'Service provider' => 'Service provider',
            ])
                ->when('Farmer', function ($f) {


                    $f->select('group_id', 'Select your Farm Association')
                        ->options(FarmersGroup::where([])->get()->pluck('name', 'id'))
                        ->rules('required');
                    $f->text('number_of_dependants', 'Number of dependants')->rules('required');

                    return $f;
                })
                ->when('Farmer', function ($f) {

                    $f->text('services', 'Services that you offer')->rules('required');

                    return $f;
                })->rules('required');

            $form->select('access_to_credit', 'Do you have access to credit?')->options([
                'No any access' => 'No any access',
                'SACCO' => 'SACCO',
                'Bank' => 'Bank',
                'VSLA' => 'Village Savings and Loan Associate (VSLA)',
                'Family' => 'Family',
            ])->rules('required');


            $form->textarea('about', 'About your farm/business');
            $form->image('avatar', 'Business Logo or Account Image')->rules('required');
        });


        $form->tab('SYSTEM ACCOUNT', function (Form $form) {
            $u = Admin::user();
            $form->display('username', trans('admin.username'));
            $form->display('phone_number', trans('Phone number'));




            $form->radio('change_password', 'Change password')
                ->options([
                    'change_password' => 'Change password',
                    'change_password_1' => 'Don\'t change password',
                ])
                ->when('change_password', function ($f) {

                    $f->password('password', trans('admin.password'))->rules('confirmed|required');
                    $f->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                        ->default(function ($fo) {
                            return $fo->model()->password;
                        });
                    $f->setAction(admin_url('auth/setting'));
                    $f->ignore(['password_confirmation']);

                    $f->saving(function (Form $form) {
                        if ($form->password && $form->model()->password != $form->password) {
                            $form->password = Hash::make($form->password);
                        }
                    });

                    return $f;
                });

            $form->ignore(['change_password']);


            $form->saved(function () {
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(admin_url('auth/setting'));
            });
        });






        return $form;
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        admin_toastr(trans('admin.login_successful'));

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Admin::guard();
    }
}
