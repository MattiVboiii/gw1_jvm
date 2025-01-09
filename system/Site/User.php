<?php

namespace Site;

require_once 'system/db.inc.php';

class User
{
    private const EXTENSION_TIME = 3600;
    private int $sessionTimeout = 0;
    private readonly bool $verified;

    function __construct(
        public readonly int $id,
        public readonly string $username,
        private readonly string $passwordHash,
        public readonly string $email,
        public readonly string $permissionRole,
        public readonly string $firstname,
        public readonly string $lastname,
    ) {}

    public function verifyPass(#[\SensitiveParameter] string $password): bool
    {
        return $this->verified = password_verify($password, $this->passwordHash);
    }

    public function isVerified(): bool
    {
        return isset($this->verified) && $this->verified;
    }

    public function login()
    {
        if (!$this->verified) throw new \Exception('FORBIDDEN: Attempting login without verified password');
        $_SESSION['loggedInUser']?->logout();
        $_SESSION['loggedInUser'] = $this->extendSession();
    }

    public function logout(): null
    {
        $this->sessionTimeout = min($this->sessionTimeout, time());
        unset($_SESSION['loggedInUser']);
        return null;
    }

    public function isLoggedIn(): bool
    {
        if ($_SESSION['loggedInUser']?->id !== $this->id) return false;
        return $this->sessionTimeout > time();
    }

    public function extendSession(int $time = self::EXTENSION_TIME): User
    {
        $this->sessionTimeout = time() + $time;
        return $this;
    }

    public static function getLoggedInUser(): User|null
    {
        if (empty($_SESSION['loggedInUser'])) return null;
        if (!$_SESSION['loggedInUser'] instanceof User) return null;
        return ($user = $_SESSION['loggedInUser'])->isLoggedIn()
            ? $user->extendSession()
            : $user->logout();
    }

    public static function requireLogin(string $redirectLocation): User
    {
        if ($user = self::getLoggedInUser()) return $user;
        header("Location: $redirectLocation");
        exit;
    }

    public static function fetch(string $email): User|null
    {
        return getUser($email) ?: null;
    }

    public function refetch(): User|null
    {
        return getUser($this->email) ?: null;
    }

    public function getFullName()
    {
        return "$this->firstname $this->lastname";
    }

    public function printPermRole()
    {
        return ucwords($this->permissionRole);
    }
}
