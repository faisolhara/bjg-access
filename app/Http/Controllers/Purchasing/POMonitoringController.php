<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Service\AccessControlService;

class POMonitoringController extends Controller
{
    const RESOURCE = 'Absence\POMonitoring';

    public function index(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'view')){
            abort(403);
        }

        $client = new Client();

        if ($request->isMethod('post')) {
            $request->session()->put('POMonitoringFilter', $request->all());
        }

        $filters = $request->session()->get('POMonitoringFilter');

        $datas = [];
        if(!empty($filters['startDate']) && !empty($filters['endDate'])){

            $startDate = new \DateTime($filters['startDate']);
            $endDate   = new \DateTime($filters['endDate']);

            try {
                $response = $client->post(env('URL_API').'get-absence', [
                    'form_params' => [
                        'startDate' => $startDate->format('Ymd'),
                        'endDate'   => $endDate->format('Ymd'),
                        'empCode'   => \Session::get('user')['vc_emp_code'],
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
        }

        return view('absence.index',[
            'datas'   => $datas,
            'filters' => $filters,
            ]);
    }

    public function detail(Request $request){
        if(!AccessControlService::checkAccessControl(self::RESOURCE, 'view')){
            abort(403);
        }
        
        $client = new Client();
        $startDate = new \DateTime($request->get('startDate'));
        $endDate   = new \DateTime($request->get('endDate'));

        try {
                $response = $client->post(env('URL_API').'get-absence-detail', [
                    'form_params' => [
                        'empCode'   => $request->get('empCode'),
                        'category'  => $request->get('category'),
                        'startDate' => $startDate->format('Ymd'),
                        'endDate'   => $endDate->format('Ymd'),
                    ],
                    'verify'      => false,
                ]);

                $response = json_decode($response->getBody(), true);
                // dd($response);
                return view('absence.detail',[
                    'category' => $request->get('category'),
                    'header'   => $response['header'][0],
                    'lines'    => $response['lines'],
                ]);

            } catch (RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
            }
        

    }
}
