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
use stdClass;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS = 'success';
    const ERROR   = 'error';

    protected function jsonResponse($data = null, string $status = self::SUCCESS) : JsonResponse
    {
        if(empty($data) || is_string($data)) {
            $data = $this->setMessage($data);
        }
        $code = $status == self::ERROR ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;

        return response()->json([
            'status' => $status,
            'data'   => $data
        ], $code);
    }

    private function setMessage(string $message = null): object
    {
        $message = $this->getMessageForeignKeyException($message);

        $data = new stdClass();
        $data->message = [$message ?? 'Nenhum registro encontrado'];
        return $data;
    }

    private function getMessageForeignKeyException(string $message = null)
    {
        $constraints = [
            'produto_vendas_produto_id_foreign' => 'produto_id não encontrado',
            'produto_vendas_venda_id_foreign'   => 'venda_id não encontrado',
            'vendas_cliente_id_foreign'         => 'cliente_id não encontrado',
            'users_email_unique'                => 'email já existe',
            'produtos_fornecedor_id_foreign'    => 'fornecedor_id não encontrado',
        ];

        if(!empty($message)) {
            foreach ($constraints as $constraint => $exception) {
                if (strpos($message, $constraint)) {
                    return $exception;
                }
            }
        }
        return $message;
    }

    protected array $validation = [];

    protected function validateRequest(Request $request, bool $insert = true ) : ValidationValidator
    {
        if(!$insert) {
            foreach ($this->validation as $field => $validations) {
                foreach ($validations as $key => $value) {
                    if($value == 'required'){
                        unset($this->validation[$field][$key]);
                    }
                }
            }
        }
        return Validator::make($request->all(), $this->validation);
    }
}
