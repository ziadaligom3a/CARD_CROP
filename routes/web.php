<?php

use Mtownsend\RemoveBg\RemoveBg;
use IDAnalyzer\CoreAPI;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('CARD',function(){


        $image = request()->file('file');
        $file = $image->getContent();
        $coreapi = new CoreAPI("kIkT6nxynxkG70NJX8VNDsBlx4Aihb76", "US");
        $coreapi->enableAuthentication(true, 'quick');
        list($width, $height, $type, $attr) = getimagesize($image);
        // dd($height);
        if($height >= 1000 || $width >= 1000){

            $removebg = new RemoveBg('cnigyBEevq3dXQ686jMdgBXj');
            $rawBase64 = $removebg->base64(base64_encode($file))->get();
            $file = $rawBase64;
        }

        $result = $coreapi->scan($image);
        $data_result = $result['result'];
        return view('CARD',[

            'base' => base64_encode($file),
            'value' => $data_result['documentNumber']
        ]);




});
