<?php

namespace Yaspa\Authentication\PrivateAuthentication\Transformers;

use GuzzleHttp\RequestOptions;
use Yaspa\Authentication\PrivateAuthentication\Models\Credentials as CredentialsModel;

/**
 * Class Credentials
 *
 * @package Yaspa\Authentication\PrivateAuthentication\Transformers
 */
class Credentials
{
    /**
     * Return a Guzzle specified basic auth request option array.
     *
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#auth
     * @param CredentialsModel $credentials
     * @return array
     */
    public function toRequestOptions(CredentialsModel $credentials): array
    {
        return [
            RequestOptions::AUTH => [
                $credentials->getApiKey(),
                $credentials->getPassword(),
            ],
        ];
    }
}
