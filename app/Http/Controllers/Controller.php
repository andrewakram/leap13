<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        return view('welcome');
    }

    public function loginUser(Request $request){
        $user=$request->user;
        $pass=$request->pass;
        $url = "https://nilepromotion.com/pa-test/wp-json/test/v2/creds?%20username=$user&password=$pass";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        //dd($data);
        curl_close($ch);
        $decodedData = json_decode($data);
        //dd($decodedData->tracks);
        $login_flag=$decodedData->login;
        $login_flag==false ? $login_flag="failed" :$login_flag;
        if($login_flag == 'successful'){
            Session::put('user','successful');
        }else{
            Session::put('user','failed');
        }
        return response($login_flag);
    }

    public function loadTracks(){
        $login_check = Session::get('user');
        if(isset($login_check) && $login_check == 'successful'){
            $i=0;
            $url = "https://api.jsonbin.io/b/5eafd4ca47a2266b1472794c";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $data = curl_exec($ch);
            //dd($data);
            curl_close($ch);
            $decodedData = json_decode($data);
            //dd($decodedData->tracks);
            $tracks=$decodedData->tracks;

            return response($tracks);
        }else{
            return response('failed');
        }



    }

    public function downloadTrack(Request $request){
        $filename=basename($request->urll);

        header('Content-Type: application/mp3');
        header("Content-Disposition: attachment; filename=$filename");
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($request->urll);

        exit;
    }
}
