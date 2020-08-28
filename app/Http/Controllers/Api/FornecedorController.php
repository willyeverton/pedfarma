<?php

namespace App\Http\Controllers\Api;

use App\Fornecedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    protected array $validation = [
        'nome_fantasia' => ['required', 'string',   'max:255'],
        'telefone'      => ['required', 'celular_com_ddd'],
        'razao_social'  => ['nullable', 'string',   'max:255',  'unique:fornecedores'],
        'email'         => ['required', 'max:255',  'email',    'unique:fornecedores'],
        'cnpj'          => ['required', 'formato_cnpj', 'cnpj', 'unique:fornecedores']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->jsonResponse(Fornecedor::all());

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
            $supplier = $this->save(new Fornecedor(), $validator->validated());
            return $this->jsonResponse($supplier);

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
            return $this->jsonResponse(Fornecedor::find($id));

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
            $supplier = Fornecedor::find($id);

            if(empty($supplier)){
                return $this->jsonResponse(null,  parent::ERROR);
            }
            $supplier = $this->save($supplier, $validator->validated());

            return $this->jsonResponse($supplier);

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
            $supplier = Fornecedor::find($id);

            if(empty($supplier)){
                return $this->jsonResponse(null, parent::ERROR);
            }
            $supplier->delete();
            return $this->jsonResponse($supplier);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Save data.
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
