<?php

    namespace Tests\Feature;

    use App\Data\Bar;
    use App\Data\Foo;
    use App\Data\Person;
    use App\Services\HelloService;
    use App\Services\HelloServiceIndonesia;
    use Tests\TestCase;
    use function PHPUnit\Framework\assertEquals;

    class ServiceContainerTest extends TestCase
    {
        public function testCreateDependecyIjection()
        {
            $foo1 = $this->app->make(Foo::class);
            $foo2 = $this->app->make(Foo::class);
            self::assertEquals("Foo", $foo1->foo());
            self::assertEquals("Foo", $foo2->foo());
            self::assertNotSame($foo1, $foo2);


        }

//  Mennetukan cara pembuatan object dengan function bind
        public function testBid()
        {
//        beritahun cara pembuatan dengan function bind
            $this->app->bind(Person::class,function ($app){
                return new Person("Asep","Riki");
            });

            //sekarang membuat object nya
            $person1= $this->app->make(Person::class);
            $person2 = $this->app->make(Person::class);
            self::assertEquals("Asep",$person1->firstName);
            self::assertEquals("Asep",$person2->firstName);
            self::assertEquals("Riki",$person1->lastName);
            self::assertEquals("Riki",$person2->lastName);
            self::assertNotSame($person1,$person2);

        }

        public function testSingleton()
        {
            //set oject dengan yang sama
            $this->app->singleton(Person::class,function ($app){
                return new Person("Asep","Riki");
            });

            //sekarang membuat object nya
            $person1= $this->app->make(Person::class);
            $person2 = $this->app->make(Person::class);
            self::assertEquals("Asep",$person1->firstName);
            self::assertEquals("Asep",$person2->firstName);
            self::assertEquals("Riki",$person1->lastName);
            self::assertEquals("Riki",$person2->lastName);
            self::assertSame($person1,$person2);
        }

        //membuat singgleton dengan instance, selain dengan method singleton kita juga bisa menggunakan instance
        public function testInstance()
        {
            $instance = new Person("Asep","Riki");
            $this->app->instance(Person::class,$instance);

            //sekarang membuat object nya
            $person1= $this->app->make(Person::class);
            $person2 = $this->app->make(Person::class);
            self::assertEquals("Asep",$person1->firstName);
            self::assertEquals("Asep",$person2->firstName);
            self::assertEquals("Riki",$person1->lastName);
            self::assertEquals("Riki",$person2->lastName);
            self::assertSame($person1,$person2);

        }

        //membuat dependency injection
        public function testDependencyInjection()
        {
            $this->app->singleton(Foo::class,function ($app){
                return new Foo();
            });

            // object Foo akan  otometisi di ijection ke Bar
            $bar = $this->app->make(Bar::class);

            $foo = $this->app->make(Foo::class);

            assertEquals("Foo and Bar", $bar->bar());
            self::assertSame($foo,$bar->foo);

        }
        // dependency injection closure
        public function testDependencyInjectionInClosure()
        {
            // object ini sebenarnya akan tersimpan di service container, jadi bisa kita gunakan
            $this->app->singleton(Foo::class,function(){
                return new Foo();
            });

            //membuat bar dengan dependecy mengambil dari closure di atas
            $this->app->singleton(Bar::class,function ($app){
                //buat object dan ambil dependency foo dari service container
                return new Bar($app->make(Foo::class));
            });

//            // panggin dependency
            $bar1 = $this->app->make(Bar::class);
            $bar2 = $this->app->make(Bar::class);

            self::assertSame($bar1,$bar2);

        }

        //biding interface ke class
        public function testHelloService()
        {
            $this->app->singleton(HelloService::class,HelloServiceIndonesia::class);

            $HelloService = $this->app->make(HelloService::class);
            assertEquals("Hello Riki",$HelloService->hello("Riki"));



        }


    }
