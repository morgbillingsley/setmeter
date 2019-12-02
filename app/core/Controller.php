<?php

use Models\User;

class Controller
{
    public function __construct()
    {
        session_start();
        global $entityManager;
        $this->em = $entityManager;
        if ($this->isLoggedIn()) {
            $this->setUserByQuery(['email' => $_SESSION['user']['email']]);
        }
    }

    public function view(string $view, array $data=[]): int
    {
        // Check if view includes a file extension
        if (preg_match('/^.*\.[a-z]{1,5}$/', $view)) {
            $path = dirname(__DIR__) . '/views/' . $view;
        } else {
            // If no file extension, default to php
            $path = dirname(__DIR__) . '/views/' . $view . '.php';
        }
        require_once $path;
        return 0;
    }

    public function notFound(): int
    {
        http_response_code(404);
        require_once __DIR__ . '/views/404.html';
        exit(0);
    }

    public function isLoggedIn(): bool
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            if (isset($_SESSION['user']['email'])) {
                if ($this->userExists(['email' => $_SESSION['user']['email']])) {
                    return true;
                }
            }
        }
        session_unset();
        return false;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function setUserByQuery(array $query): self
    {
        $userRepository = $this->em->getRepository(User::class);
        $this->user = $userRepository->findOneBy($query);

        return $this;
    }

    public function userExists(array $query): bool
    {
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findOneBy($query);
        if ($user !== null) {
            return true;
        }
        return false;
    }

    public function findUser(array $query)
    {
        $userRepository = $this->em->getRepository(User::class);
        return $userRepository->findOneBy($query);
    }

    public function hasRole(string $role): bool
    {
        if ($this->isLoggedIn()) {
            $roles = $this->user->getRoles();
            if (in_array($role, $roles)) {
                return true;
            }
        }

        return false;
    }

    public function authorize(string $role = 'user'): int
    {
        if ($this->isLoggedIn()) {
            $roles = $this->user->getRoles();
            if (in_array($role, $roles)) {
                return 0;
            }
        }

        http_response_code(403);
        echo 'You are not allowed to view this page';
        exit(0);
    }

    public function login()
    {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['user']['id'] = $this->user->getId();
        $_SESSION['user']['email'] = $this->user->getEmail();
        $_SESSION['user']['roles'] = $this->user->getRoles();

        return 0;
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        return 0;
    }
    
}

?>