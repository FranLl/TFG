<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

use App\Http\Requests\StoreBlockRequest;
// Added to use this resource
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Block creation with received data
        $block = Block::create($request->validated());

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
        $blockchainResponse = Http::get('http://<IP_nodo_Hornet>:14265/api/core/v2/blocks/'.$blockId);

        // 'pack' converts hexadecimal to string. 'substr' removes the first two characters, in this case '0x'
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Block $block)
    {
        $block->update($request->validated());
        return new BlockResource($block);
    }
}
