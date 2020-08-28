<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Produto;
use App\ProdutoVenda;
use App\Venda;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    protected array $validation = [
        'forma_pagamento' => ['required', 'string', 'max:255'],
        'parcelas'        => ['required', 'int'],
        'acrescimo'       => ['nullable', 'numeric'],
        'desconto'        => ['nullable', 'numeric'],
        'total'           => ['required', 'numeric'],
        'status'          => ['nullable', 'string', 'max:255'],
        'observacao'      => ['nullable', 'string', 'max:255'],
        'produtos'        => ['required', 'array'],
        'cliente_id'      => ['required', 'int'],
    ];

    private function getProducts(Venda $sale) : array
    {
        $productsSale = $sale->produtosVenda()->get();
        $products = [];

        if($productsSale->count()) {
            foreach ($productsSale as $key => $productSale) {
                $products[$key] = $productSale->produto()->first();
                $products[$key]['quantidade'] = $productSale->quantidade;
            }
        }
        return $products;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $sales = Venda::all();

            if($sales->count()){
                foreach($sales as $key => $sale) {
                    $sales[$key]['produtos'] = $this->getProducts($sale);
                }
            }
            return $this->jsonResponse($sales);

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
            DB::beginTransaction();
            $validator = $this->validateRequest($request);

            if($validator->fails()){
                return $this->jsonResponse($validator->errors(), parent::ERROR);
            }
            $sale = $this->save(new Venda(), $validator->validated());
            $this->saveProducts($sale, $validator->validated());

            DB::commit();
            return $this->jsonResponse($sale);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $sale = Venda::find($id);

            if(!empty($sale))
                $sale['produtos'] = $this->getProducts($sale);

            return $this->jsonResponse($sale);

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
            DB::beginTransaction();
            $validator = $this->validateRequest($request, false);

            if($validator->fails()){
                return $this->jsonResponse($validator->errors(), parent::ERROR);
            }
            $sale = Venda::find($id);

            if(empty($sale)){
                return $this->jsonResponse(null, parent::ERROR);
            }
            $sale = $this->save($sale, $validator->validated());

            $this->saveProducts($sale, $validator->validated());

            DB::commit();
            return $this->jsonResponse($sale);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $sale = Venda::find($id);

            if(empty($sale)){
                return $this->jsonResponse(null, parent::ERROR);
            }
            $this->deleteProducts($sale);
            $sale->delete();

            DB::commit();
            return $this->jsonResponse($sale);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->jsonResponse($th->getMessage(), parent::ERROR);
        }
    }

    /**
     * Save Sale data.
     */
    private function save(Venda $sale, array $data) : Venda
    {
        isset($data['forma_pagamento'])? $sale->forma_pagamento = $data['forma_pagamento'] : null;
        isset($data['parcelas'])       ? $sale->parcelas        = $data['parcelas']        : null;
        isset($data['acrescimo'])      ? $sale->acrescimo       = $data['acrescimo']       : null;
        isset($data['desconto'])       ? $sale->desconto        = $data['desconto']        : null;
        isset($data['total'])          ? $sale->total           = $data['total']           : null;
        isset($data['status'])         ? $sale->status = $this->setStatus($data['status']) : null;
        isset($data['observacao'])     ? $sale->observacao      = $data['observacao']      : null;
        isset($data['cliente_id'])     ? $sale->cliente_id      = $data['cliente_id']      : null;

        $sale->save();
        return $sale;
    }

    private function setStatus(string $status): string
    {
        $options = [
            'ativo',
            'cancelado',
        ];
        if(in_array($status, $options))
            return $status;

        throw new Exception("$status não é um status válido. Status válidos: ". implode(', ', $options));
    }

    /**
     * Save Products to Sale.
     * @throws Exception
     */
    private function saveProducts(Venda $sale, array $data): void
    {
        if(isset($data['produtos']) || $sale->status == 'cancelado') {
            $this->deleteProducts($sale);

            if($sale->status != 'cancelado') {
                foreach ($data['produtos'] as $product) {
                    $productSale = new ProdutoVenda();

                    $productSale->produto_id = $product['produto_id'];
                    $productSale->venda_id = $sale->id;
                    $productSale->quantidade = $product['quantidade'];
                    $productSale->save();

                    $this->subtractStockQuantity($product);
                }
            }
        }
    }

    private function subtractStockQuantity(array $data) : void
    {
        $product = Produto::find($data['produto_id']);
        // SUBTRAI A QUANTIDADE DO ESTOQUE
        $product->quantidade -= $data['quantidade'];

        if($product->quantidade < 0) {
            throw new Exception("Estoque insuficiente. Produto id: {$product->id}, nome: {$product->nome}; Quantidade em estoque: " . $product->getOriginal('quantidade'));
        }
        $product->save();
    }

    private function deleteProducts(Venda $sale): void
    {
        $productsSale = $sale->produtosVenda()->get();
        if($productsSale->count()){

            foreach ($productsSale as $productSale) {
                $product = $productSale->produto()->first();

                // ADICIONA A QUANTIDADE AO ESTOQUE
                $product->quantidade += $productSale->quantidade;
                $product->save();

                ProdutoVenda::where('produto_id', $productSale->produto_id)->delete();
            }
        }
    }
}
