<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function tearDown(): void
    {
        if (class_exists(\Cactuar\Admin\Models\Permalink::class)) {
            $ref = new \ReflectionProperty(\Cactuar\Admin\Models\Permalink::class, 'active');
            $ref->setAccessible(true);
            $ref->setValue(null, null);
        }
        parent::tearDown();
    }
}
