<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20.12.18
 * Time: 19:44
 */

namespace App\Http\Controllers;


use App\Http\Requests\ScvRequest;
use App\Models\Client;

class ScvController
{

    public function index(ScvRequest $request)
    {

        $data = $request->get('csv');

        try {

            Client::updateFromScv($data);

        } catch (\Exception $e) {

            return response()->json([
                'response' => 'error',
                'message' => 'Error while parse',
            ]);

        }

        return response()->json();
    }

}