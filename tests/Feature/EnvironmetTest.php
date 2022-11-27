<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmetTest extends TestCase
{
    public function testEnv()
    {
        $appName = env("YOUTUBE");
        self::assertEquals("Programmer Zaman Now",$appName);
    }

}
