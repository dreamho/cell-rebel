<?php namespace Ranking\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use Ranking\Http\Requests;
use Ranking\Http\Controllers\Controller;
use Ranking\Services\SocialAccountService;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        auth()->login($user);

        return redirect()->to('/analytics');
    }
}
