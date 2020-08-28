<?php

namespace App\Http\Controllers\Api;

use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    protected array $validation = [
        'nome'     => ['required', 'string', 'max:255'],
        'telefone' => ['required', 'celular_com_ddd'],
        'email'    => ['required', 'max:255', 'email', 'unique:clientes'],
        'cpf'      => ['required', 'formato_cpf', 'cpf', 'unique:clientes']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->jsonResponse(Cliente::all());

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = $this->validateRequest($request);

            if($validator->fails()){
                return $this->jsonResponse($validator->errors(), parent::ERROR);
            }
            $customer = $this->save(new Cliente(), $validator->validated());
            return $this->jsonResponse($customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->jsonResponse(Cliente::find($id));

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validator = $this->validateRequest($request, false);

            if($validator->fails()){
                return $this->jsonResponse($validator->errors(), parent::ERROR);
            }
            $customer = Cliente::find($id);

            if(empty($customer)){
                return $this->jsonResponse(null,  parent::ERROR);
            }
            $customer = $this->save($customer, $validator->validated());

            return $this->jsonResponse($customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $customer = Cliente::find($id);

            if(empty($customer)){
                return $this->jsonResponse(null,  parent::ERROR);
            }
            $customer->delete();
            return $this->jsonResponse($customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Save data.
     */
    private function save(Cliente $customer = null, array $data): Cliente
    {
        isset($data['nome'])     ? $customer->nome     = $data['nome']     : null;
        isset($data['email'])    ? $customer->email    = $data['email']    : null;
        isset($data['cpf'])      ? $customer->cpf      = $data['cpf']      : null;
        isset($data['telefone']) ? $customer->telefone = $data['telefone'] : null;

        $customer->save();
        return $customer;
    }
}
