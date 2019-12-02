<?php

namespace Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true, name="email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="password")
     */
    private $password;

    /**
     * @ORM\Column(type="string", name="first_name", nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", name="last_name", nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", name="phone", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="simple_array", name="roles", nullable=true)
     */
    private $roles;

    public function __construct()
    {
        $this->roles = [];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        if ($this->email !== $email) {
            $this->email = $email;
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $encrypted = password_hash($password, PASSWORD_BCRYPT);
        if ($this->password !== $encrypted) {
            $this->password = $encrypted;
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): self
    {
        if ($this->firstName !== $firstName) {
            $this->firstName = $firstName;
        }

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): self
    {
        if ($this->lastName !== $lastName) {
            $this->lastName = $lastName;
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone($phone): self
    {
        if ($this->phone !== $phone) {
            $this->phone = $phone;
        }

        return $this;
    }

    public function getRoles(): ?array
    {
        $roles = $this->roles;
        $roles[] = 'user';

        return array_unique($roles);
    }

    public function addRole($role): self
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Set roles.
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }
}