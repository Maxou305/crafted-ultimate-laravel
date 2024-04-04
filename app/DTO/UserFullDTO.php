<?php

namespace App\DTO;

use App\Models\User;

class UserFullDTO
{
    public $id;
    public $pseudo;
    public $lastname;
    public $firstname;
    public $email;
    public $avatar;
    public $paymentaddress;
    public $deliveryaddress;
    public $phone;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->pseudo = $user->pseudo;
        $this->lastname = $user->lastname;
        $this->firstname = $user->firstname;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->paymentaddress = $user->paymentaddress;
        $this->deliveryaddress = $user->deliveryaddress;
        $this->phone = $user->phone;
    }
}
