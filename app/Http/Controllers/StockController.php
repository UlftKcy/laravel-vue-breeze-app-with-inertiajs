<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        Request::validate([
            "name" => "required",
            "brand" => "required",
            "price" => "required",
            "count_in_stock" => "required",
        ]);
        Stock::create(
            [
                "name" => $request->name,
                "brand" => $request->brand,
                "price" => $request->price,
                "count_in_stock" => $request->count_in_stock,
                "description" => $request->description,
            ]
        );
        return \redirect()->route('stocks.index');

    }

    /**
     * Display the specified resource.
     *
     * @param Stock $stock
     * @return Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Stock $stock
     * @return Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Stock $stock
     * @return Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Stock $stock
     * @return Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
