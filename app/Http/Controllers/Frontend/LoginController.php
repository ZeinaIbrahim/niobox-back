<?php

namespace App\Http\Controllers\Frontend;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:web', ['except' => ['logout']]);
    }



    /**
     * @return Application|Factory|View
     */
    public function login(): Factory|View|Application
    {
        return view('frontend.login');
    }

    public function register(): Factory|View|Application
    {
        return view('frontend.register', compact('logo'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function submit(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (auth('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('home');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function submitRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (auth('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('home');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        auth()->guard('web')->logout();
        return redirect()->route('home');
    }
}
