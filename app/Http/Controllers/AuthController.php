<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
    //
    public function index(Request $request){
        return view('login');
    }

    public function cekStatus(Request $request){
        if(!empty(\Session::get('user'))){
            return redirect('/home');
        }else{
            return redirect('login');
        }
    }

    public function postLogin(Request $request){
        try {
            $client = new Client();

            $response = $client->post(env('URL_API').'login', [
                'form_params' => $request->all(),
                'verify'      => false,
            ]);

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        $result = json_decode($response->getBody(), true);

        if(!empty($result) && $result[0]['user_valid'] == 'Y'){
            \Session::put('user', $result[0]);
            return redirect('/home');
        }

        $username = strtoupper($request->get('username'));

        if(!empty($result)){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => 'Password for user '.$username.' is wrong']);
        }else{
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => 'Username '.$username.' not register in system']);
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
