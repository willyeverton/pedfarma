<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected array $validation = [
        'nome'          => ['required', 'string', 'max:255', 'unique:produtos'],
        'descricao'     => ['nullable', 'string', 'max:255'],
        'quantidade'    => ['required', 'int'],
        'valor'         => ['required', 'numeric'],
        'custo'         => ['required', 'numeric'],
        'fornecedor_id' => ['required', 'int'],
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            return $this->jsonResponse(Produto::all());

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
            $product = $this->save(new Produto(), $validator->validated());

            return $this->jsonResponse($product);

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
            return $this->jsonResponse(Produto::find($id));

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
            $product = Produto::find($id);

            if(empty($product)){
                return $this->jsonResponse(null,  parent::ERROR);
            }
            $product = $this->save($product, $validator->validated());

            return $this->jsonResponse($product);

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
            $product = Produto::find($id);

            if(empty($product)){
                return $this->jsonResponse(null, parent::ERROR);
            }
            $product->delete();
            return $this->jsonResponse($product);

        } catch (\Throwable $th) {
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Save data.
     */
    private function save(Produto $product, array $data): Produto
    {
        isset($data['nome'])          ? $product->nome          = $data['nome']          : null;
        isset($data['descricao'])     ? $product->descricao     = $data['descricao']     : null;
        isset($data['quantidade'])    ? $product->quantidade    = $data['quantidade']    : null;
        isset($data['valor'])         ? $product->valor         = $data['valor']         : null;
        isset($data['custo'])         ? $product->custo         = $data['custo']         : null;
        isset($data['fornecedor_id']) ? $product->fornecedor_id = $data['fornecedor_id'] : null;

        $product->save();
        return $product;
    }
}
