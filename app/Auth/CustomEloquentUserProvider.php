<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * Handles credential lookups where 'email' is on the related 'people' table.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $credentials = array_filter(
            $credentials,
            fn ($key) => ! str_contains($key, 'password'),
            ARRAY_FILTER_USE_KEY
        );

        if (empty($credentials)) {
            return null;
        }

        $query = $this->newModelQuery();

        // Si la búsqueda incluye email, relacionar con la tabla people
        if (isset($credentials['email'])) {
            $email = $credentials['email'];
            unset($credentials['email']);

            $query->whereHas('person', function ($q) use ($email) {
                $q->where('email', $email);
            });
        }

        foreach ($credentials as $key => $value) {
            if (is_array($value) || $value instanceof \Illuminate\Contracts\Support\Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }
}
