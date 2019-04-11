<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class OnhandController extends Controller
{
    //
    public function index(Request $request){
        $request->session()->put('filters', $request->all());
        $filters = $request->session()->get('filters');

        return view('onhand.index', [
            'filters'    => $filters,
            'data'      => [],
        ]);
    }

    public function view(Request $request){
        $filters = $request->session()->get('filters');

        $input =[
                'p_organization_id'  => $request->get('p_organization_id'),
                'p_project_code'     => $request->get('p_project_code'),
            ];
        $client             = new Client();


        try {
        $responseOrigin     = $client->post(env('URL_API').'get-onhand-index', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
            exit();
        }



        $data = json_decode($responseOrigin->getBody(), true);

    	return view('onhand.index', [
            'filters'    => $filters,
            'data'      => $data,
        ]);
    }

    public function index2(Request $request){
        $request->session()->put('filters', $request->all());
        $filters = $request->session()->get('filters');

        return view('onhand.index-2', [
            'filters'    => $filters,
            'data'      => [],
        ]);
    }

    public function view2(Request $request){
        $request->session()->put('filters', $request->all());
        $filters = $request->session()->get('filters');

        $input =[
                'p_organization_id'  => $request->get('p_organization_id'),
                'p_project_code'     => $request->get('p_project_code'),
            ];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-onhand-index', [
            'form_params' => $input,
            'verify'      => false,
        ]);

        $data = json_decode($responseOrigin->getBody(), true);

        return view('onhand.index-2', [
            'filters'    => $filters,
            'data'      => $data,
        ]);
    }

    public function getDetailItem(Request $request){
        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-onhand-detail', [
            'form_params' => $request->all(),
            'verify'      => false,
        ]);

        return json_decode($responseOrigin->getBody(), true);
    }
}
