<?php

namespace App\Http\Controllers\Purchasing;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Service\AccessControlService;
use App\Http\Controllers\Controller;

class MyRequisitionController extends Controller
{
    const URL       = 'purchasing/my-requisition';
    const RESOURCE  = 'Purchasing\MyRequisition';

    public function index(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'view')){
            abort(403);
        }

        $client = new Client();
        try {
            $response = $client->post(env('URL_API').self::URL.'/get-requisition', [
                'form_params' => [
                    // 'user_id' => \Session::get('user')['user_id'],
                    'user_id' => 1926,
                ],
                'verify'      => false,
            ]);

            $requisitions = json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return view('purchasing/my-requisition.index',[
            'requisitions' => $requisitions,
            'url'          => self::URL,
            ]);
    }

    public function detail(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'view')){
            abort(403);
        }
        $client = new Client();
        try {
            $response = $client->post(env('URL_API').self::URL.'/get-requisition-detail', [
                'form_params' => [
                    'requisitionHeaderId' => $request->get('requisitionHeaderId'),
                ],
                'verify'      => false,
            ]);

            $notification = json_decode($response->getBody(), true);

            return view('purchasing/my-requisition.detail',[
                'dataHeader'    => $notification['dataHeader'][0],
                'dataItem'      => $notification['dataItem'],
            ]);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }
}
