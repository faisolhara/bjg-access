<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Service\AccessControlService;

class NotificationController extends Controller
{
    const URL       = '/';
    const RESOURCE  = 'Notification';

    public function home(Request $request){
        // dd(\Session::get('user'));
        $client = new Client();
        try {
            $response = $client->post(env('URL_API').'get-notification', [
                'form_params' => [
                    'username' => \Session::get('user')['user_name'],
                ],
                'verify'      => false,
            ]);

            $notifications = json_decode($response->getBody(), true);

        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return view('home',[
            'notifications' => $notifications,
            ]);
    }

    public function notificationDetail(Request $request){
        $client = new Client();
        if($request->get('approveType') == 'Absence'){
            $response = $client->post(env('URL_API').'get-notification-absence', [
                'form_params' => [
                    'documentId' => $request->get('documentId'),
                ],
                'verify'      => false,
            ]);

            $notification = json_decode($response->getBody(), true);

            return view('notification.absence',[
                'notification' => $notification[0],
            ]);
        }else if($request->get('approveType') == 'Requisition'){
            try {
                $response = $client->post(env('URL_API').'get-notification-requisition', [
                    'form_params' => [
                        'documentId' => $request->get('documentId'),
                    ],
                    'verify'      => false,
                ]);

                $notification = json_decode($response->getBody(), true);
                return view('notification.requisition',[
                    'keyId'         => $request->get('keyId'),
                    'dataHeader'    => $notification['dataHeader'][0],
                    'dataItem'      => $notification['dataItem'],
                    'dataHistory'   => $notification['dataHistory'],
                ]);
            } catch (RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
            }
        }else if($request->get('approveType') == 'SPKL'){
            $response = $client->post(env('URL_API').'get-notification-spkl', [
                'form_params' => [
                    'documentId' => $request->get('documentId'),
                ],
                'verify'      => false,
            ]);

            $notification = json_decode($response->getBody(), true);

            return view('notification.spkl',[
                'keyId'         => $request->get('keyId'),
                'dataHeader'    => $notification['dataHeader'][0],
                'dataLines'      => $notification['dataLines'],
            ]);
        }else if($request->get('approveType') == 'Quote'){
            $response = $client->post(env('URL_API').'get-notification-quote', [
                'form_params' => [
                    'documentId' => $request->get('documentId'),
                ],
                'verify'      => false,
            ]);

            $notification = json_decode($response->getBody(), true);

            return view('notification.quote',[
                'keyId'         => $request->get('keyId'),
                'dataHeader'    => $notification['dataHeader'][0],
                'dataLines'      => $notification['dataLines'],
            ]);
        }

        return "Coming soon ya!";
    }

    public function approveNotification(Request $request){
        $client = new Client();
        $input  = $request->all();
        $input['empCode'] = \Session::get('user')['vc_emp_code'];
        $response = [];

        try {
            if($request->get('approveType') == 'Absence'){
                $response = $client->post(env('URL_API').'get-notification-absence', [
                    'form_params' => [
                        'documentId' => $request->get('keyId'),
                    ],
                    'verify'      => false,
                ]);

                $notification = json_decode($response->getBody(), true);

                $input = [
                    'buttonType'    => $request->get('buttonType'),
                    'approveType'   => $notification[0]['approval_type'],
                    'noDocument'    => $notification[0]['no_document'],
                    'note'          => $request->get('note'),
                    'empCode'       => \Session::get('user')['vc_emp_code'],
                ];

                $response = $client->post(env('URL_API').'save-approve-absence', [
                    'form_params' => $input,
                    'verify'      => false,
                ]);
            }elseif($request->get('approveType') == 'Requisition'){
                $client = new Client();
                $input['keyId']         = $request->get('keyId');
                $input['approveType']   = strtoupper($request->get('buttonType'));
                $input['note']          = $request->get('note');
                $input['empCode']       = \Session::get('user')['vc_emp_code'];

                try {
                    $response = $client->post(env('URL_API').'save-approve-requisition', [
                        'form_params' => $input,
                        'verify'      => false,
                    ]);
                } catch (RequestException $e) {
                    echo Psr7\str($e->getRequest());
                    if ($e->hasResponse()) {
                        echo Psr7\str($e->getResponse());
                    }
                }
            }elseif($request->get('approveType') == 'SPKL'){
                return json_decode([]);
                $client = new Client();
                $input['keyId']         = $request->get('keyId');
                $input['approveType']   = strtoupper($request->get('buttonType'));
                $input['note']          = $request->get('note');
                $input['empCode']       = \Session::get('user')['vc_emp_code'];

                try {
                    $response = $client->post(env('URL_API').'save-approve-spkl', [
                        'form_params' => $input,
                        'verify'      => false,
                    ]);
                } catch (RequestException $e) {
                    echo Psr7\str($e->getRequest());
                    if ($e->hasResponse()) {
                        echo Psr7\str($e->getResponse());
                    }
                }
            }else{
                dd('gak ada tipe ini bosss');
            }
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        return json_decode($response->getBody(), true);
    }

    public function approveAbsence(Request $request){
        $client = new Client();
        $input  = $request->all();
        $input['empCode'] = \Session::get('user')['vc_emp_code'];

        try {
            $response = $client->post(env('URL_API').'save-approve-absence', [
                'form_params' => $input,
                'verify'      => false,
            ]);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        $response = json_decode($response->getBody(), true);

        $message =  $request->get('buttonType') == 'approve' ? 'approved' : 'rejected';

        if($response == 'S'){
            $request->session()->flash(
                'successMessage',
                'Absence '.$request->input('noDocument').' has '.$message
                );
        }else{
            $request->session()->flash(
                'errorMessage',
                'Absence '.$request->input('noDocument').' cannot be saved'
                );
        }

        return redirect('home');
    }

    public function approveRequisition(Request $request){
        $client = new Client();
        $input['keyId']         = $request->get('requitionHeaderId');
        $input['approveType']   = strtoupper($request->get('buttonType'));
        $input['note']          = $request->get('note');
        $input['empCode']       = \Session::get('user')['vc_emp_code'];

        try {
            $response = $client->post(env('URL_API').'save-approve-requisition', [
                'form_params' => $input,
                'verify'      => false,
            ]);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        $response = json_decode($response->getBody(), true);

        $message =  $request->get('buttonType') == 'approve' ? 'approved' : 'rejected';
        if($response == 'S'){
            $request->session()->flash(
                'successMessage',
                'Requisition Number '.$request->input('prNumber').' has '.$message
                );
        }else{
            $request->session()->flash(
                'errorMessage',
                'Requisition Number '.$request->input('prNumber').' cannot be saved'
                );
        }


        return redirect('home');
    }

    public function approveSpkl(Request $request){
        $client = new Client();
        $input  = $request->all();
        $input['empCode'] = \Session::get('user')['vc_emp_code'];

        try {
            $response = $client->post(env('URL_API').'save-approve-spkl', [
                'form_params' => $input,
                'verify'      => false,
            ]);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }

        $response = json_decode($response->getBody(), true);

        $message =  $request->get('buttonType') == 'approve' ? 'approved' : 'rejected';

        if($response == 'S'){
            $request->session()->flash(
                'successMessage',
                'Absence '.$request->input('noDocument').' has '.$message
                );
        }else{
            $request->session()->flash(
                'errorMessage',
                'Absence '.$request->input('noDocument').' cannot be saved'
                );
        }

        return redirect('home');

    }

    public function approveQuote(Request $request){
        dd('Belum ada approve quote ya!');
    }
    
}
