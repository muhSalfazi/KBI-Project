<?php
namespace App\Services;

use App\Models\TblUser;

class UserSecurityServices{
    protected int $maxChance;

    public function __construct()
    {
        $this->maxChance = 3;
    }

    public function handleResponse(TblUser $user){
        $this->incrementChance($user);
    }

     private function incrementChance(TblUser $user) {
        if($user->is_blocked) {
            return;
        }

        $user->chance++;

        if($user->chance >= $this->maxChance) {
            $this->blockUser($user);
        } else {
            $user->save();
        }
     }

     private function blockUser(TblUser $user) {
        $user->is_blocked = true;
        $user->save();
     }

     public function unBlock(TblUser $user) {
        $user->is_blocked = false;
        $user->chance = 0;
        $user->save();
    }

     public function isActive (TblUser $user) {
        return !$user->is_blocked;
     }
}

?>
