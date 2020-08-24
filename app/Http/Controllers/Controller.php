<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS = 'success';
    const ERROR   = 'error';

    protected function jsonResponse(string $status, string $message, object $data = null) : JsonResponse
    {
        $code = $status == self::ERROR ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;
        return response()->json([
            'status' => $status,
            'message'=> $message,
            'data'   => $data
        ], $code);
    }

    protected array $validation = [];

    protected function validateRequest(Request $request, bool $insert = true ) : ValidationValidator
    {
        if(!$insert) {
            $this->removeRequireValidatiton();
        }
        return Validator::make($request->all(), $this->validation);
    }

    private function removeRequireValidatiton() : void
    {
        foreach ($this->validation as $field => $validations) {
            foreach ($validations as $key => $value) {
                if($value == 'required'){
                    unset($this->validation[$field][$key]);
                }
            }
        }
    }
}
