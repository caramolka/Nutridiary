<?php

namespace App\Policies;

use App\User;
use App\Fooditem;
use Illuminate\Auth\Access\HandlesAuthorization;

class FooditemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the fooditem.
     *
     * @param  \App\User  $user
     * @param  \App\Fooditem  $fooditem
     * @return mixed
     */
    public function view(User $user, Fooditem $fooditem)
    {
        //
    }

    /**
     * Determine whether the user can create fooditems.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the fooditem.
     *
     * @param  \App\User  $user
     * @param  \App\Fooditem  $fooditem
     * @return mixed
     */
    public function update(User $user, Fooditem $fooditem)
    {
        //
    }

    /**
     * Determine whether the user can delete the fooditem.
     *
     * @param  \App\User  $user
     * @param  \App\Fooditem  $fooditem
     * @return mixed
     */
    public function delete(User $user, Fooditem $fooditem)
    {
        //
    }
}
