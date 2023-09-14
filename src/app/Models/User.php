<?php

class User
{

    private string $firstname;
    private string $lastname;
    private string $phone;
    private string $email;
    private string $password;

    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string|null $phone
     */
    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $password,
        string $phone = null,
    )
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $phone && $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function hasPhone(): bool
    {
        return !empty($this->phone);
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

}