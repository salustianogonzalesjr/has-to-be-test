<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Interfaces\ChargingProcessInterface;
use Laravel\Lumen\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

use App\Services\ChargingProcessService;
use App\Exceptions\InvalidDataException;


class ChargingProcessController extends BaseController
{    
    protected $chargingProcessService;    

    /**
     * Create a new controller instance.
     *
     * @param ChargingProcessService $chargingProcessService
     * 
     */
    public function __construct( ChargingProcessService $chargingProcessService )
    {
        $this->chargingProcessService = $chargingProcessService;
    }

    /**
     * Function to calculate Charging Rate
     * 
     * @param \Laravel\Lumen\Http\Request $request
     * 
     * @return array|\Symfony\Component\HttpFoundation\JsonResponse|static
     * 
     * @throws \App\Exceptions\InvalidDataException 
     * @throws \App\Exceptions;
     */
    public function calculate(Request $request) : JsonResponse 
    {
        try {
            $respone = $this->chargingProcessService->calculateRating( $request->json()->get('cdr') );
        } catch (\Exception $exception) {                

            return response()->json(     
                json_decode($exception->getMessage(), true), 
                Response::HTTP_BAD_REQUEST );

        } catch (InvalidDataException $exception) {   

            return response()->json(     
                json_decode($exception->getMessage(), true), 
                Response::HTTP_UNPROCESSABLE_ENTITY );                
        }
        
        return response()->json($respone, Response::HTTP_OK);
    }

}
