<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LostItem;

class LostItemPolicy
{
    public function update(User $user, LostItem $lostItem)
    {
        return $lostItem->isEditable();
    }
}
