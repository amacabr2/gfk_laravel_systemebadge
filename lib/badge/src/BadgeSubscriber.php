<?php

namespace Badge;

use App\Events\Premium;
use App\User;
use Badge\Notifications\BadgeUnlocked;

class BadgeSubscriber {

    private $badge;

    public function __construct(Badge $badge) {
        $this->badge = $badge;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events) {
        $events->listen('eloquent.saved: App\Comment', [$this, 'onNewComment']);
        $events->listen('App\Events\Premium', [$this, 'onPremium']);
    }

    /**
     * Envoi notification
     * @param User $user
     * @param Badge $badge
     */
    public function notifyBadgeUnlock($user, $badge) {
        if ($badge) {
            $user->notify(new BadgeUnlocked($badge));
        }
    }

    /**
     * Evenement pour regarder s'il faut débloquer un badge
     * @param $comment
     */
    public function onNewComment($comment) {
        $user = $comment->user;
        $comments_count = $user->comments()->count();
        $badge = $this->badge->unlockActionFor($user, 'comments', $comments_count);
        $this->notifyBadgeUnlock($user, $badge);
    }

    /**
     * Evenement pour savoir si l'utisateur est premium ou pas
     * @param Premium $event
     * @internal param $arg
     */
    public function onPremium($event) {
        $badge = $this->badge->unlockActionFor($event->user, 'premium');
        $this->notifyBadgeUnlock($event->user, $badge);
    }

}