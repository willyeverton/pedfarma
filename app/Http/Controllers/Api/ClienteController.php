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
        'email'    => ['required', 'max:255', 'email',],
        'cpf'      => ['required', 'formato_cpf', 'cpf']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $customers = Cliente::all();

            if(is_null($customers)){
                return $this->jsonResponse(parent::ERROR, 'No Customers found');
            }
            return $this->jsonResponse(parent::SUCCESS, 'Customers found', $customers);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
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
                return $this->jsonResponse(parent::ERROR, 'Failed to validate data', $validator->errors());
            }
            $customer = $this->save(new Cliente(), $validator->validated());
            return $this->jsonResponse(parent::SUCCESS, 'Customer created!', $customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $customer = Cliente::find($id);

            if(is_null($customer)){
                return $this->jsonResponse(parent::ERROR, 'Customer not found');
            }
            return $this->jsonResponse(parent::SUCCESS, 'Customer found', $customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
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
                return $this->jsonResponse(parent::ERROR, 'Failed to validate data', $validator->errors());
            }
            $customer = Cliente::find($id);

            if(is_null($customer)){
                return $this->jsonResponse(parent::ERROR, 'Customer not found');
            }
            $customer = $this->save($customer, $validator->validated());
            return $this->jsonResponse(parent::SUCCESS, 'Customer updated', $customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $customer = Cliente::find($id);

            if(is_null($customer)){
                return $this->jsonResponse(parent::ERROR, 'Customer not found');
            }
            $customer->delete();
            return $this->jsonResponse(parent::SUCCESS, 'Customer Deleted!', $customer);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Save data supplier.
     */
    private function save(Cliente $customer, array $data): Cliente
    {
        isset($data['nome_fantasia']) ? $customer->nome_fantasia = $data['nome_fantasia'] : null;
        isset($data['razao_social'])  ? $customer->razao_social  = $data['razao_social']  : null;
        isset($data['email'])         ? $customer->email         = $data['email']         : null;
        isset($data['cnpj'])          ? $customer->cnpj          = $data['cnpj']          : null;
        isset($data['telefone'])      ? $customer->telefone      = $data['telefone']      : null;

        $customer->save();
        return $customer;
    }
}
