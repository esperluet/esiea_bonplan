<?php

namespace App\tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\MathComputeService;

class MathComputeServiceTest extends TestCase
{

    public function testisPremier() {
        $mathService = new MathComputeService();

        $this->assertEquals(true, $mathService->isPremier(3));
        $this->assertEquals(true, $mathService->isPremier(7));
        $this->assertEquals(true, $mathService->isPremier(19));
        $this->assertEquals(false, $mathService->isPremier(4));
        $this->assertEquals(false, $mathService->isPremier(16));
    }

}