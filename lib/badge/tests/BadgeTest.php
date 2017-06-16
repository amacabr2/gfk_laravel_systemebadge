<?php

namespace Tests\Unit;

use Badge\Badge;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BadgeTest extends TestCase {

    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testFakeThings() {
        Badge::create([
            'name' => 'Pipelette',
            'action' => 'comment',
            'action_acount' => 2
        ]);
        $this->assertEquals(1, Badge::count());
    }

}