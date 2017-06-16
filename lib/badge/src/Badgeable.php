<?php

namespace Badge;


trait Badgeable {

    public function Badges() {
        return $this->belongsToMany(Badge::class);
    }

}