<?php

namespace App\Http\interface;

interface ProductInteface
{
    public function index();
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}

