<?php

namespace DavidWesdijk\LaravelPolymorphicEav\Tests;

use DavidWesdijk\LaravelPolymorphicEav\Providers\PolymorphicEavServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PolymorphicEavServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
