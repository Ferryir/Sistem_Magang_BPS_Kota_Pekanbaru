<?php

namespace App\Guards;

use App\Models\Pegawai;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;

class PegawaiSessionGuard extends SessionGuard
{
    /**
     * Update the session with the given ID.
     *
     * @param  string  $id
     * @return void
     */
    protected function updateSession($id)
    {
        parent::updateSession($id);

        // If the user is a Pegawai, store the pegawai_id in the session
        if ($this->user() instanceof Pegawai) {
            Session::put('pegawai_id', $this->user()->getAuthIdentifier());
        }
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ($this->loggedOut) {
            return;
        }

        // If the user is already stored in the session, return it
        if (! is_null($this->user)) {
            return $this->user;
        }

        // Retrieve the pegawai_id from the session
        $id = Session::get('pegawai_id');

        if (! is_null($id) && $this->user = $this->provider->retrieveById($id)) {
            $this->fireAuthenticatedEvent($this->user);

            return $this->user;
        }

        return parent::user();
    }
}
