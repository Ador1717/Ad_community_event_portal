<?php

namespace model;
class user
{

    public int $id;
    public string $username;
    public string $password;
    public string $role;
    public string $email;
    public DateTime $posted_at;
    public function __construct()
    {
    }
    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPostedAt(): \DateTime {
        return $this->posted_at;
    }

    // Setters
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function setPassword(?string $password): void {
        if ($password !== null) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }
    public function setRole(string $role): void {
        $this->role = $role;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPostedAt(\DateTime $posted_at): void {
        $this->posted_at = $posted_at;
    }
}
