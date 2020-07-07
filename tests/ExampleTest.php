<?php

namespace PolymorphicEav\PolymorphicEav\Tests;

use Orchestra\Testbench\TestCase;
use PolymorphicEav\PolymorphicEav\PolymorphicEavServiceProvider;

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
