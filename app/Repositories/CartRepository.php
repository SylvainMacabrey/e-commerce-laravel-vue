<?php

namespace App\Repositories;

use Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartRepository
{
    public function add(Product $product)
    {
        Cart::session(auth()->user()->id)
            ->add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'attributes' => [],
                'associatedModel' => $product
            ]);
        return $this->count();
    }

    public function content()
    {
        return Cart::session(auth()->user()->id)->getContent();
    }

    public function count()
    {
        return $this->content()->sum('quantity');
    }

    public function increase(int $id)
    {
        if ($this->getItem($id)->quantity === 1) {
            return $this->delete($id);
        }

        Cart::session(auth()->user()->id)->update($id, [
            'quantity' => + 1
        ]);
    }

    public function decrease(int $id)
    {
        Cart::session(auth()->user()->id)->update($id, [
            'quantity' => - 1
        ]);
    }

    private function getItem(int $rowId)
    {
        return Cart::session(auth()->user()->id)->get($rowId);
    }

    public function delete(string $rowId): int
    {
        Cart::session(auth()->user()->id)->remove($rowId);
        return $this->count();
    }

    public function jsonOrderItems(): string
    {
        return $this->content()->map(function ($orderItem) {
            return [
                'name' => $orderItem->name,
                'quantity' => $orderItem->quantity,
                'price' => $orderItem->price,
            ];
        })->toJson();
    }

    public function clear()
    {
        Cart::session(auth()->user()->id)->clear();
    }
}
