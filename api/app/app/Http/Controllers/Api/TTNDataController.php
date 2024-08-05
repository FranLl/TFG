<?php

// In which directory is this controller
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Added to use Guzzle, HTTP client for Laravel
use Illuminate\Support\Facades\Http;
// Added to create blocks
use App\Models\Block;


class TTNDataController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // ESTO ES PARA VALIDARLO YO MANUALMENTE SIN FORMULARIOS Y SIN QUE MUESTRE EL MENSAJE DE ERROR CON EL VALOR DEL APIKEY
        if ($request['uplink_message']['decoded_payload']['apikey'] != '<clave>' )
            return response('Error bad api key.', 400)->header('Content-Type', 'application/json');

        // ESTO ES PARA FORMULARIOS
        // Request validation from The Things Network
        // https://laravel.com/docs/11.x/validation#quick-writing-the-validation-logic        
        $validated = $request->validate([
            'uplink_message.decoded_payload.data.ax' => ['required', 'numeric'],
            'uplink_message.decoded_payload.data.ay' => ['required', 'numeric'],
            'uplink_message.decoded_payload.data.az' => ['required', 'numeric'],
            'uplink_message.decoded_payload.data.temp' => ['required', 'numeric'],
            'uplink_message.decoded_payload.data.id' => ['required', 'numeric'],
            'uplink_message.decoded_payload.data.loc' => ['required', 'numeric']
        ]);

        // Block request creation to send to the blockchain node api
        // See api block creation reference: https://wiki.iota.org/apis/core/v2/submit-a-block/
        $blockRequest = [
            'protocolVersion' => 2,
            'payload' => [
                'type' => 5,
                'tag' => "0x".bin2hex("Sensor-".$validated['uplink_message']['decoded_payload']['data']['id']."-".
                    $validated['uplink_message']['decoded_payload']['data']['loc']
                ),
                'data' => "0x".bin2hex(json_encode($validated['uplink_message']['decoded_payload']['data']) )
            ]
        ];
        
        // Send request to the blockchain (Hornet node) using Guzzle
        // See Laravel HTTP client methods: https://laravel.com/docs/11.x/http-client
        $blockchainResponse = Http::post('http://192.168.2.111:14265/api/core/v2/blocks', $blockRequest);

        // Check if there was an error sending data to the blockchain (Hornet node)
        if( $blockchainResponse->failed() )
            // Uncomment to see the real error of the blockchain node
            //return response($blockchainResponse, 400)->header('Content-Type', 'application/json');
            return response('Error sending data to the blockchain.', 400)->header('Content-Type', 'application/json');

        // Array creation to save the data response of the blockchain (blockId)
        // Block::create needs an array
        $arrayBlockchainResponse = [
            'blockId' => $blockchainResponse['blockId'],
            'sensorLoc' => $validated['uplink_message']['decoded_payload']['data']['loc'],
            'sensorId' => $validated['uplink_message']['decoded_payload']['data']['id']
        ];
        
        // Save data to be displayed on the web
        $block = Block::create($arrayBlockchainResponse); #TODO: creo que no valida la entrada como hago en BlockResource

        // Check if model was created on the database
        if( !$block->save() )
            return response('Error creating block.', 400)->header('Content-Type', 'application/json');
        else
            return response('Block created.', 200)->header('Content-Type', 'application/json');
    }
}
