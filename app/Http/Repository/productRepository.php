<?php

namespace App\Http\Repository;

use App\Http\interface\ProductInteface;
use App\Models\Products;

class ProductRepository implements ProductInteface
{
    public function index()
    {
        return Products::paginate(5);
    }

    public function store($data)
    {
        return Products::create($data);
    }

    public function show($id)
    {
        return Products::findOrFail($id);
    }

    public function update($data, $id)
    {
        $product = Products::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function destroy($id)
    {
        return Products::find($id)->delete();
    }

}
