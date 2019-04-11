<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Service\AccessControlService;

class AccessControlController extends Controller
{
    const URL       = 'access-control';
    const RESOURCE  = 'AccessControl';

    public function index(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'view')){
            abort(403);
        }

        $client = new Client();
        if ($request->isMethod('post')) {
            $request->session()->put('AccessControlFilter', $request->all());
        }
        $filters = $request->session()->get('AccessControlFilter');

        if(!empty($filters['username']) || !empty($filters['name'])){
            try {
                $response = $client->post(env('URL_API').'get-user', [
                    'form_params' => $filters,
                    'verify'      => false,
                ]);

                $accessControls = json_decode($response->getBody(), true);
            } catch (RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
            }
        }

        return view('access-control.index',[
            'accessControls' => !empty($accessControls) ? $accessControls : [],
            'filters'        => $filters,
            'url'            => self::URL,
            'resource'       => self::RESOURCE,
            ]);
    }

    public function edit(Request $request, $username){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'edit')){
            abort(403);
        }

        $client = new Client();
        $input = [
            'username' => $username,
        ];

        try {
            $response = $client->post(env('URL_API').'get-user', [
                'form_params' => $input,
                'verify'      => false,
            ]);
            $user = json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return view('access-control.edit',[
            'user'           => !empty($user) ? $user[0] : [],
            'url'            => self::URL,
            'resource'       => self::RESOURCE,
            'username'       => $username,
            'resources'      => config('menu.resources'),
            ]);
    }

    public function save(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'edit')){
            abort(403);
        }
        $client = new Client();
        try {
            $response = $client->post(env('URL_API').'save-access-control', [
                'form_params' => $request->all(),
                'verify'      => false,
            ]);

            $response = json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        $request->session()->flash(
            'successMessage',
            'Access control for user  '.$request->input('username').' has been saved'
        );

        return redirect(self::URL.'/edit/'.$request->input('username'));
        
    }
}
