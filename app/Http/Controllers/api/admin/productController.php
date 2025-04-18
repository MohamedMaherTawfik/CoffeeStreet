<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Http\interface\ProductInteface;
use App\Http\Requests\productRequest;
use App\Http\Requests\productUpdateRequest;
use Illuminate\Http\Request;

class productController extends Controller
{
    use apiResponse;

    private $productRepository;

    public function __construct(ProductInteface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->index();
        return $this->apiResponse($products, 'Products fetched successfully');
    }

    public function show() {
        $product = $this->productRepository->show(request('id'));
        if (!$product) {
            return $this->sendError('Product not found');
        }
        return $this->apiResponse($product, 'Product fetched successfully');
    }

    public function store(productRequest $request) {
        $data = $request->validated();
        // dd($data);
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('products'), $imageName);
        $data['image'] = $imageName;
        $product = $this->productRepository->store($data);
        return $this->apiResponse($product, 'Product created successfully');
    }

    public function update(productUpdateRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imageName);
            $data['image'] = $imageName;
        }
        $product = $this->productRepository->update($data, request('id'));
        return $this->apiResponse($product, 'Product updated successfully');
    }

    public function destroy()
    {
        $product = $this->productRepository->destroy(request('id'));
        return $this->apiResponse($product, 'Product deleted successfully');
    }

}
