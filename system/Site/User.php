<?php

namespace Site;

class User
{
    function __construct(
        public readonly int $id,
        public readonly string $username,
        private readonly string $password,
        public readonly string $email,
    ) {}
}
