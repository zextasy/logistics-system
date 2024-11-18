<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Document $document)
    {
        return $user->is_admin || $document->shipment->user_id === $user->id;
    }

    public function download(User $user, Document $document)
    {
        return $this->view($user, $document) && $document->status === 'active';
    }

    public function revoke(User $user, Document $document)
    {
        return $user->is_admin;
    }
}
