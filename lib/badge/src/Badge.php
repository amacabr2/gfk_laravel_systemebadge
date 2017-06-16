<?php

namespace Badge;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model {

    protected $guarded = [];
    public $timestamps = false;

    /**
     * Regarde si l'utilisateur a déjà le badge ou non
     * @param User $user
     * @return bool
     */
    public function isUnlockedFor(User $user): bool {
        return $user->badges->contains($this);
    }

    /**
     * Regarde l'action et le nombre de fois ou l'action est éxecuté pour savoir s'il faut débloquer le badge
     * @param User $user
     * @param string $action
     * @param int $count
     */
    public function unlockActionFor(User $user, string $action, int $count) {
        $badge = $this->newQuery()
            ->where('action', $action)
            ->where('action_count', $count)
            ->first();
        if ($badge and !$badge->isUnlockedFor($user)) {
            $user->badges()->attach($badge);
        }
    }

}
