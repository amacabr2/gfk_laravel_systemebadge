<?php

namespace Badge;

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
    }

    public function onNewComment($comment) {
        $user = $comment->user;
        $comments_count = $user->comments()->count();
        $badge = Badge::where('action', 'comments')
            ->where('action_count', $comments_count)
            ->first();
        if ($badge) {
            $user->badges()->attach($badge);
        }
    }

}