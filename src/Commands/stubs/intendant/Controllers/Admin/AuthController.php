<?php

namespace Intendant\{$stub_intendant_zone_upper}\Controllers\Incore;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getLogin()
    {
        if (!Auth::guard('admin')->guest()) {
            return redirect(\Docore::configs('prefix'));
        }

        return view('incore::login');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        $validator = Validator::make($credentials, [
            'username' => 'required', 'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            return Redirect::intended(\Docore::configs('prefix'));
        }

        return Redirect::back()->withInput()->withErrors(['username' => $this->getFailedLoginMessage()]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::guard('admin')->logout();

        return redirect(\Docore::configs('prefix'));
    }

    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }
}
