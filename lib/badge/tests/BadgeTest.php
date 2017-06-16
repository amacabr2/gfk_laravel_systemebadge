<?php

namespace Tests\Unit;

use App\Comment;
use App\User;
use Badge\Badge;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BadgeTest extends TestCase {

    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testUnlockBadgeAutomatically() {
        Badge::create([
            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2
        ]);
        $user = factory(User::class)->create();
        factory(Comment::class, 3)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
    }

    public function testDontUnlockBadgeForNotEnoughAction(){
        Badge::create([
            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2
        ]);
        $user = factory(User::class)->create();
        factory(Comment::class)->create(['user_id' => $user->id]);
        $this->assertEquals(0, $user->badges()->count());
    }

    public function testUnlockDoubleBadge(){
        Badge::create([
            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2
        ]);
        $user = factory(User::class)->create();
        factory(Comment::class, 2)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
        Comment::first()->delete();
        factory(Comment::class, 2)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
    }

}