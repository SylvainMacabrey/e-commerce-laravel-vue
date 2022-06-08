<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\CartRepository;

class ApiCartController extends Controller
{

    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'cartContent' => $this->cartRepository->content(),
            'cartCount' => $this->cartRepository->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->productId);
        $count = $this->cartRepository->add($product);
        return response()->json(['count' => $count]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = $this->cartRepository->delete($id);
        return response()->json(['count' => $count]);
    }

    public function count()
    {
        return response()->json([
            'count' =>  $this->cartRepository->count()
        ]);
    }

    public function decreaseQuantity($id)
    {
        $this->cartRepository->decrease($id);
    }

    public function dincreaseQuantity($id)
    {
        $this->cartRepository->increase($id);
    }
}
