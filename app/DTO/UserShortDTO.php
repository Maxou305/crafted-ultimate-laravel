<?php

namespace App\DTO;

use App\Models\User;

class UserShortDTO
{
    public $id;
    public $pseudo;
    public $lastname;
    public $firstname;
    public $email;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->pseudo = $user->pseudo;
        $this->lastname = $user->lastname;
        $this->firstname = $user->firstname;
        $this->email = $user->email;
    }
}
