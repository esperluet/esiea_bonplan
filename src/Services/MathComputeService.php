<?php

namespace App\Services;

class MathComputeService
{
    public function isPremier(int $number): bool	
    {
        if($number < 0 )  return false;

        $isPremier = true;
        $borne = (int) ($number/2);
        
        for($i=2 ; $i <= $borne ; $i++){
            if ($number % $i == 0) {
                $isPremier = false;
                break;
            }
        }

        return $isPremier;
    }
}