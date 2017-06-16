<?php

namespace App\Events;

use App\User;

class Premium {

    /**
     * Représente l'utilisateur qui a souscrit à un compte premium
     * @var User
     */
    public $user;

    /**
     * Premium constructor.
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

}