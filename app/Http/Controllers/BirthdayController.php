<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Service\AccessControlService;

class BirthdayController extends Controller
{
    const RESOURCE = 'Birthday';
    const URL      = 'birthday';

    public function index(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'view')){
            abort(403);
        }

        $client = new Client();
        $datas = [];
        try {
            $response = $client->post(env('URL_API').'get-birthday', [
                'form_params' => [
                    'userName'   => \Session::get('user')['user_name'],
                ],
                'verify'      => false,
            ]);

            $datas = json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return view('birthday.index',[
            'datas'   => $datas,
            ]);
    }
}
