<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;
// TODO: para que me sirve este fichero?
use App\Http\Requests\StoreBlockRequest;
// Added to usethis resource
use App\Http\Resources\BlockResource;
// Added to use Guzzle, HTTP client for Laravel
use Illuminate\Support\Facades\Http;


class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all blocks
        $blocks = Block::all();
        // Use resources to convert resource to array
        $arrayBlocks = BlockResource::collection($blocks);

        // Return web view with data
        return view('dashboard', [ 'arrayBlocks' => $arrayBlocks ] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // TODO: eliminar funciones vacias?
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Block creation with received data
        $block = Block::create($request->validated());

        // TODO: creo que esta funcion no la uso porque no llamo a BlockController.store en ningun lado
        // TODO: solo llamo a index y show en el web.php, deberia estructurar el codigo para utilizar esta clase junto al BlockResource
        return new BlockResource($block);
    }

    /**
     * Display the specified resource.
     */
    public function show($blockId)
    {
        // Send request to the blockchain (Hornet node) using Guzzle
        # https://laravel.com/docs/11.x/http-client
        # dot to concatenate
        $blockchainResponse = Http::get('http://<IP_almacen>:14265/api/core/v2/blocks/'.$blockId);

        //$block = Block::where('blockId', $blockId)->first();
        //return $blockchainResponse;
        
        // CAMBIAR ESTO POR                 bin2hex("that's all you need");
        // pack transforma de hexadecimal a cadena. substr quita los dos primeros caracteres, en este caso 0x
        $blockData = [
            'blockId' => $blockId,
            'hexTag' => $blockchainResponse['payload']['tag'],
            'tag' => pack('H*', substr( $blockchainResponse['payload']['tag'], 2)),
            'parents' => $blockchainResponse['parents'],
            'hexData' => $blockchainResponse['payload']['data'],
            'data' => pack('H*', substr( $blockchainResponse['payload']['data'], 2))
        ];
        
        return view('blockInfo', [ 'blockData' => $blockData ] );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Block $block)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Block $block)
    {
        $block->update($request->validated());
        return new BlockResource($block);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Block $block)
    {
        //
    }
}
