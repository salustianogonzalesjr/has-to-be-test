<?php
/**
 * @category    ChargingProcess
 * @package     Rating
 * @author      Sag Gonzales <salustiano.a.gonzales.jr@gmail.com>
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Conditions
    |--------------------------------------------------------------------------
    |
    | These value are used for the Rating computation
    |
    */
    'cdr' => [
        'energy' => env('CDR_ENERGY', 0.30), // 0.30€ per kWh
        'time' => env('TIME', 2), // 2€ per hour
        'transaction' => env('TRANSACTION', 1), //1€ service fee    
    ]
];