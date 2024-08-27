<?php

namespace App\Helpers;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

use Illuminate\Support\Facades\Storage;

class JwtHelper
{
    public static function getJwtConfiguration(): Configuration
    {
        $privateKeyPath = Storage::path('jwt/private.pem');
        if (empty($privateKeyPath)) {
            throw new \InvalidArgumentException('Private key path cannot be empty.');
        }

        $publicKeyPath = Storage::path('jwt/public.pem');
        if (empty($publicKeyPath)) {
            throw new \InvalidArgumentException('Public key path cannot be empty.');
        }

        return Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file($privateKeyPath),
            InMemory::file($publicKeyPath)
        );
    }
}