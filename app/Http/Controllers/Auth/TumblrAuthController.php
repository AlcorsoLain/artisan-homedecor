<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class TumblrAuthController extends Controller
{

    public function __construct() {
        $this->client = new Client();
        $this->client_id = env('TUMBLR_CLIENT_ID');
        $this->client_secret = env('TUMBLR_CLIENT_SECRET');
    }
    public function redirectToProvider(){
        return redirect()->intended("https://www.tumblr.com/oauth2/authorize?". http_build_query([
            'client_id' => $this->client_id,
            'response_type' => 'code',
            'scope' => 'basic',
            'state' => bin2hex(random_bytes(16)),
            'redirect_uri' => env('TUMBLR_REDIRECT_URI')
        ]));
    }
    public function handleProviderCallback(Request $request){
        $oauth_verifier = $request->input('code');
        if(!$oauth_verifier){
            return response(["error" => "oauth vacio"]);
        }
        $response = $this->client->post('https://api.tumblr.com/v2/oauth2/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $oauth_verifier,
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'redirect_uri' => env('TUMBLR_REDIRECT_URI')
            ]
        ]);
        $userObjectTumblr = json_decode($response->getBody());
        session(['USER_TOKEN' => $userObjectTumblr]);
        error_log(json_encode($userObjectTumblr));
        $response = $this->client->get("https://api.tumblr.com/v2/user/info", [
            'headers' => [
                'Authorization' => 'Bearer '.$userObjectTumblr->access_token
            ],

        ]);
        $TumblrUser = json_decode($response->getBody());
        session(['USER_INFO' => $TumblrUser->response->user]);
        return redirect('/');
    }
    public function handleProviderLogout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
