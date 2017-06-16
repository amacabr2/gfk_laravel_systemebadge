<?php

namespace Tests\Unit;

use App\Comment;
use App\Events\Premium;
use App\User;
use Badge\Badge;
use Badge\Notifications\BadgeUnlocked;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BadgeTest extends TestCase {

    use DatabaseTransactions;
    use DatabaseMigrations;

    public function setBadge(string $name, string $action, int $action_count = 0) {
        Badge::create([
            'name' => $name,
            'action' => $action,
            'action_count' => $action_count
        ]);
    }

    /**
     * Test si le badge se créer bien automatiquement
     */
    public function testUnlockBadgeAutomatically() {
        $this->setBadge('Pipelette', 'comments', 2);
        $user = factory(User::class)->create();
        factory(Comment::class, 3)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
    }

    /**
     * Test si le badge se créer pas lorsqu'il ne le faut pas
     */
    public function testDontUnlockBadgeForNotEnoughAction() {
        $this->setBadge('Pipelette', 'comments', 2);
        $user = factory(User::class)->create();
        factory(Comment::class)->create(['user_id' => $user->id]);
        $this->assertEquals(0, $user->badges()->count());
    }

    /**
     * Test si on a pas de doublon de badge
     */
    public function testUnlockDoubleBadge(){
        $this->setBadge('Pipelette', 'comments', 2);
        $user = factory(User::class)->create();
        factory(Comment::class, 2)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
        Comment::first()->delete();
        factory(Comment::class, 2)->create(['user_id' => $user->id]);
        $this->assertEquals(1, $user->badges()->count());
    }

    /**
     * Regarde si la notification est envoyé
     */
    public function testNotificationSent() {
        Notification::fake();
        $this->setBadge('Pipelette', 'comments', 2);
        $user = factory(User::class)->create();
        factory(Comment::class, 3)->create(['user_id' => $user->id]);
        Notification::assertSentTo([$user], BadgeUnlocked::class);
    }

    public function testUnlockPremiumBadge() {
        $user = factory(User::class)->create();
        $this->setBadge('Premium', 'premium');
        event(new Premium($user));
        $this->assertEquals(1, $user->badges()->count());
    }

}