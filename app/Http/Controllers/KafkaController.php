<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Junges\Kafka\Facades\Kafka;

/**
 * @OA\Info(title="Kafka", version="0.1"),
 *
 */
class KafkaController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/send",
     *   tags={"Kafka"},
     *   summary="Send Kafka",
     *  @OA\Parameter(
     *     name="name",
     *     in="query",
     *     required=true,
     *
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *  @OA\Parameter(
     *     name="email",
     *     in="query",
     *     required=true,
     *
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *  @OA\Parameter(
     *     name="key",
     *     in="query",
     *     required=true,
     *
     *     @OA\Schema(
     *          type="string"
     *     )
     *   ),
     *  @OA\Response(response=200, description="Success",@OA\MediaType(mediaType="application/json",)),
     *)
     **/


    public function send(Request $request)
    {
        Kafka::publish()
            ->onTopic('parrep3')
            ->withBodyKey('name', $request->name)
            ->withBodyKey('email',$request->email)
            ->withKafkaKey($request->key)
            ->send();

        return response()->json(['status' => 'Send message!']);
    }

    /**
     * @OA\Get(
     * path="/api/test_send",
     *   tags={"Kafka"},
     *   summary="Send Test Kafka",
     *  @OA\Response(response=200, description="Success",@OA\MediaType(mediaType="application/json",)),
     *)
     **/

    public function test_send()
    {
        for($i=0; $i<10; $i++){
        Kafka::publish()
            ->onTopic('parrep3')
            ->withBodyKey('name', fake()->paragraph())
            ->withBodyKey('email',fake()->email())
            ->withKafkaKey(now())
            ->send();
        }

        return response()->json(['status' => 'Send Test Message!']);
    }
}
