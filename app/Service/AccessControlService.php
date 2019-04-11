<?php 

namespace App\Service;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class AccessControlService
{
    public static function checkAccessControl($resource, $privilege)
    {
        $client = new Client();
        $response = false;
        try {
            $response = $client->post(env('URL_API').'check-access-control', [
                'form_params' => [
                    'username'  => \Session::get('user')['user_name'],
                    'resource'  => $resource,
                    'privilege' => $privilege,
                ],
                'verify'      => false,
            ]);

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
        
        return json_decode($response->getBody(), true);
    }

    public static function canAccess($username, $resource, $privilege){
        $client = new Client();
        $response = false;
        try {
            $response = $client->post(env('URL_API').'can-access', [
                'form_params' => [
                    'username'  => $username,
                    'resource'  => $resource,
                    'privilege' => $privilege,
                ],
                'verify'      => false,
            ]);

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
        
        return json_decode($response->getBody(), true);

        
    }
}