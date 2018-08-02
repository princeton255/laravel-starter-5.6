<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class LoginController extends AccessTokenController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse (Request $request)
    {
        $this->clearLoginAttempts($request);

        // Add OAuth password client credentials to request
        $request = $this->addClientCredentials($request);

        //convert Laravel Request (Symfony Request) to PSR-7
        $psr7Factory = new DiactorosFactory();
        $psrRequest = $psr7Factory->createRequest($request);

        //generate access token
        $tokenResponse = parent::issueToken($psrRequest);
        $tokenJson = json_decode($tokenResponse->content());

        if (isset($tokenJson->access_token)) {
            $tokenJson->code = 200;
            $tokenJson->message = 'success';
        } else {
            $tokenJson->code = 500;
            $tokenJson->message = 'error';
        }

        //return issued token
        return Response::json($tokenJson);
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function addClientCredentials (Request $request)
    {
        $client = \Laravel\Passport\Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->input('email', null),
            'password' => $request->input('password', null),
            'scope' => null,
        ]);

        return $request;
    }
}
