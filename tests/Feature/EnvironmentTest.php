<?php

    namespace Tests\Feature;

    use Tests\TestCase;

    class EnvironmentTest extends TestCase
    {
        public function testEnv()
        {
            $appName = env("YOUTUBE");
            self::assertEquals("Programmer Zaman Now", $appName);
        }

        public function testDefaulValue()
        {
            $author = env("AUTHOR", "Riki");
            self::assertEquals("Riki", $author);
        }

    }
