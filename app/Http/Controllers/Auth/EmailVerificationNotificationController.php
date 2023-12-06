<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->has_changed_email) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('status', 'verification-link-sent');
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
