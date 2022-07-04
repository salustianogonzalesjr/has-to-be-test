<?php

namespace App\Services;

use App\Interfaces\ChargingProcessInterface;
use App\Exceptions\InvalidDataException;
use Illuminate\Support\Facades\Validator;
use DateTime;

class ChargingProcessService implements ChargingProcessInterface 
{
    /**
     * Calculate Rating per Charging Process
     *
     * @return array
     */
    public function calculateRating($request) 
    {           
        try {
            $validator = $this->validator($request);

            if ($validator->fails()) {                         
                throw (new InvalidDataException())->setInvalidVasRequestDataMessage( $validator->errors()->getMessages() );                
            }

            // extract time and get the difference
            $time = $this->calculateTimeUsed( $request['timestampStart'] , $request['timestampStop'] ); 

            // extract energy used and get the difference
            $energy = $this->getEnergyUsed( $request['meterStart'] , $request['meterStop'] ); 

            // get the transaction
            $transaction = $this->calculateTransaction(); 

        } catch (\Exception $e) {
            throw  new \Exception(json_encode($e->getMessage()));
        }

        return [
            "overall" =>  $this->calculateOverall($time, $energy, $transaction),
            "components" => [
                "energy" => $energy,
                 "time" =>  $time, 
                 "transaction" => $transaction
            ]
        ];

    }

    /**
     * Calculate/get Time Used per Charging Process
     * 
     * @param string $start
     * @param string $end
     * 
     * @return string
     */
    private function calculateTimeUsed($start, $end)
    {
        $timestampStart = new DateTime($start);
        $timestampStart = $timestampStart->format('U');
    
        $timestampStop = new DateTime($end);
        $timestampStop = $timestampStop->format('U');
    
        // get the difference between 2 timestamps
        $diff = $timestampStop - $timestampStart;                            
        $timeDiff = ($diff/3600);
    
        // use the value set in the config to compute
        $time = $timeDiff * config('cdr.cdr.time');

        // round the result 3 digit precision
        return number_format((float)$time, 3, '.', '');
    }

    /**
     * Calculate/get Energy Used per Charging Process
     * 
     * @param mixed $meterStart
     * @param mixed $meterStop
     * 
     * @return string
     */    
    private function getEnergyUsed($meterStart, $meterStop)
    {            
        $energy = ($meterStop - $meterStart) * config('cdr.cdr.energy') ;
        
        $energy = $energy / 1000;
        
        return number_format((float)$energy, 3, '.', '');
    }  

    /**
     * Calculate/get transaction fee per Charging Process
     *
     * @return string
     */    
    private function calculateTransaction()
    {            
        return  config('cdr.cdr.transaction');
    }   

    /**
     * Calculate Overall value of Charging Process
     * 
     * @param mixed $time
     * @param mixed $energy
     * @param int $transaction
     * 
     * @return string
     */    
    private function calculateOverall($time, $energy, $transaction )
    {                    
        $overall = $time + $energy + $transaction;

        return number_format((float)$overall, 2, '.', '');
    }   
    
    
    /**
     * Perform Validation on the required parameters fields and formats
     * 
     * @param array $data
     * @param string $info
     * 
     * @return mixed
     */
    private function validator($data)
    {    
        $rules = [            
            'meterStart' => 'required|numeric',
            'timestampStart' => 'required|date',
            'meterStop' => 'required|numeric|greater_than_field:meterStart',
            'timestampStop' => 'required|date|after_or_equal:timestampStart',            
        ];

        $message = [
            'meterStart.required' => 'MeterStart is a required field',
            'meterStart.numeric' => 'MeterStart should be a numeric value',
            'meterStop.required' => 'MeterStop is a required field',
            'meterStop.numeric' => 'MeterStop should be a numeric value',
            'meterStop.greater_than_field' => 'MeterStop should be lower than meterStart value',            
            'timestampStart.required' => 'timestampStart is a required field',
            'timestampStop.required' => 'timestampStop is a required field',
        ];
        
        return Validator::make($data, $rules, $message);    
    }    

}
