<?php

namespace App\Http\Controllers\Auth;

use App\CustomHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * 
 * @package  App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    public function __construct(
        private CustomHelper $helper
    ) {
    }

    /**
     * Display the login form.
     *
     * @param Request $request The HTTP request instance.
     * @return Response The HTTP response instance.
     */
    public function index(Request $request)
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request The login request instance.
     * @return Response The HTTP response instance.
     */
    public function login(LoginRequest $request)
    {
        try {
            // Attempt to find the user by email
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $this->helper->alertResponse(__('message.invalid_email_or_password'), 'error');
                return redirect()->back();
            }
            // Check if the user's status is active
            if (strtolower($user->status) !== 'active') {
                $this->helper->alertResponse(__('message.account_not_active'), 'error');
                return redirect()->back();
            }
            // Attempt to authenticate the user
            if (!Auth::attempt($request->only('email', 'password'))) {
                $this->helper->alertResponse(__('message.invalid_email_or_password'), 'error');
                return redirect()->back();
            }
            $this->helper->alertResponse(__('message.logged_in_successfully'), 'success');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            $this->helper->handleException($e);
            return back()->with('message', __('message.something_went_wrong'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request The HTTP request instance.
     * @return Response The HTTP response instance.
     */
    protected function loggedOut(Request $request)
    {
        Auth::logout();
        // Invalidate the session.
        $request->session()->invalidate();
        // Regenerate the CSRF token.
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
