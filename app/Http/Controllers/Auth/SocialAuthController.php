<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
    	return Socialite::driver($provider)->redirect();
    }
 
    public function handleProviderCallback($provider)
    {
    	$user = Socialite::driver($provider)->user();

        $authUser=User::firstOrNew(['provider_id'=>$user->id]);

        $authUser->name=$user->name;
        $authUser->email=$user->email;
        $authUser->provider=$provider;

        $authUser->save();

        auth()->login($authUser);

        return redirect('/');

    }
}
