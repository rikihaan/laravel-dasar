<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        $firstName = config('contoh.author.first');
        $lastName = config('contoh.author.last');
        $email = config('contoh.email');
        $web = config('contoh.web');

        self::assertEquals("Asep",$firstName);
        self::assertEquals("Riki",$lastName);
        self::assertEquals("asepriki2014@gmail.com",$email);
        self::assertEquals("http://www.asepriki.com",$web);

    }

}
