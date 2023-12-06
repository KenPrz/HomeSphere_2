<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Controllers\AppUtilities;
use App\Http\Requests\ProfileUserNameRequest;
use App\Http\Requests\ProfileUserEmailRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotificationHandler;
class ProfileController extends Controller
{
    public $notificationHandler;
    public function __construct(NotificationHandler $notificationHandler)
    {
        $this->notificationHandler = $notificationHandler;
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {   

        $user = auth()->user();
        $notifications = $this->notificationHandler->getNotifications($user);
        $appUtilities = New AppUtilities;
        $user = auth()->user();
        $homeData = $appUtilities->findHomeData($user);
        return Inertia::render('Profile/Main', [
            'notifications'=> $notifications,
            'homeData'=> $homeData,
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateName(ProfileUserNameRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $request->user()->name_updated_at = now();
        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();
        $home_id = DB::table('homes')->where('owner_id', $user->id)->value('id');
        DB::table('home_members')->where('home_id', $home_id)->delete();
        
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateEmail(ProfileUserEmailRequest $request): RedirectResponse
    {   
        $user = $request->user();
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->has_changed_email = true;
        $user->save();
        return Redirect::route('profile.edit');
    }
}
