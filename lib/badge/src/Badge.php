<?php

namespace Badge;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model {

    protected $guarded = [];
    public $timestamps = false;

    public function unlockActionFor(User $user, $action, $count) {
        $badge = $this->newQuery()
            ->where('action', $action)
            ->where('action_count', $count)
            ->first();
        if ($badge) {
            $user->badges()->attach($badge);
        }
    }

}
