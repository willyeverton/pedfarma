<?php

namespace App\Http\Controllers\Api;

use App\Fornecedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    protected array $validation = [
        'nome_fantasia' => ['required', 'string', 'max:255'],
        'telefone'      => ['required', 'celular_com_ddd'],
        'razao_social'  => [            'string', 'max:255'],
        'email'         => ['required', 'max:255', 'email',],
        'cnpj'          => ['required', 'formato_cnpj', 'cnpj']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $suppliers = Fornecedor::all();

            if(is_null($suppliers)){
                return $this->jsonResponse(parent::ERROR, 'No suppliers found');
            }
            return $this->jsonResponse(parent::SUCCESS, 'Suppliers found', $suppliers);

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
            $supplier = $this->save(new Fornecedor(), $validator->validated());
            return $this->jsonResponse(parent::SUCCESS, 'Supplier created!', $supplier);

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
            $supplier = Fornecedor::find($id);

            if(is_null($supplier)){
                return $this->jsonResponse(parent::ERROR, 'Supplier not found');
            }
            return $this->jsonResponse(parent::SUCCESS, 'Supplier found', $supplier);

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
            $supplier = Fornecedor::find($id);

            if(is_null($supplier)){
                return $this->jsonResponse(parent::ERROR, 'Supplier not found');
            }
            $supplier = $this->save($supplier, $validator->validated());
            return $this->jsonResponse(parent::SUCCESS, 'Supplier updated', $supplier);

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
            $supplier = Fornecedor::find($id);

            if(is_null($supplier)){
                return $this->jsonResponse(parent::ERROR, 'Supplier not found');
            }
            $supplier->delete();
            return $this->jsonResponse(parent::SUCCESS, 'Supplier Deleted!', $supplier);

        } catch (\Throwable $th) {
            return $this->jsonResponse(parent::ERROR, $th->getMessage());
        }
    }

    /**
     * Save data supplier.
     */
    private function save(Fornecedor $supplier, array $data): Fornecedor
    {
        isset($data['nome_fantasia']) ? $supplier->nome_fantasia = $data['nome_fantasia'] : null;
        isset($data['razao_social'])  ? $supplier->razao_social  = $data['razao_social']  : null;
        isset($data['email'])         ? $supplier->email         = $data['email']         : null;
        isset($data['cnpj'])          ? $supplier->cnpj          = $data['cnpj']          : null;
        isset($data['telefone'])      ? $supplier->telefone      = $data['telefone']      : null;

        $supplier->save();
        return $supplier;
    }
}
