<?php

abstract class AuthBase
{
    protected $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
        // session_start();
    }

    abstract public function login($email, $password);
    
    abstract public function logout();

    abstract public function register($username, $email, $password, $role = 'student');
}
