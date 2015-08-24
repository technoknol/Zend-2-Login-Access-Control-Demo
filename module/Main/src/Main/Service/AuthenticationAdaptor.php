<?php

namespace Main\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

// Authentication services delegate the actual authentication
// to one (or more) authentication adaptors.
//
// In reality, this adaptor would probably load the username
// and encrypted password from a database

class AuthenticationAdaptor implements AdapterInterface
{
    private $storedUsername = "";
    private $storedPassword = "";
    
    private static $knownUsers = array("user1","user2","admin"); 
    
    /**
     * Sets username and password for authentication
     *
     * @return void
     */
    public function __construct($username = "", $password = "")
    {
        if ( is_string($username) ) {
            $this->storedUsername = $username;
        }
        if ( is_string($password) ) {
            $this->storedPassword = $password;
        }
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {
        $authenticationCode = Result::FAILURE;
        $msgs = array();
        $grantedRoles = array();
        
        if ( $this->storedUsername === "" ) {
            $authenticationCode = Result::FAILURE_IDENTITY_AMBIGUOUS;
            $msgs[] = "No username provided";
        } else if ( $this->storedPassword === "" ) {
            $authenticationCode = Result::FAILURE_CREDENTIAL_INVALID;
            $msgs[] = "No password provided";
        } else if (!in_array($this->storedUsername, AuthenticationAdaptor::$knownUsers)) {
            $authenticationCode = Result::FAILURE_IDENTITY_NOT_FOUND;
            $msgs[] = "Unknown user '".$this->storedUsername."'";
        } else if ( $this->storedUsername === $this->storedPassword ) {
            $authenticationCode = Result::SUCCESS;
            $grantedRoles[] = "ROLE_AUTHENTICATED";
            if ( $this->storedUsername === "admin" ) {
                $grantedRoles[] = "ROLE_ADMINISTRATOR";
            }
        } else {
            $authenticationCode = Result::FAILURE_CREDENTIAL_INVALID;
            $msgs[] = "Wrong password";
        }
        
        $lii = array();
        $lii["username"] = $this->storedUsername;
        $lii["grantedRole"] = $grantedRoles;
        
        // new LoggedInIdentity($this->storedUsername,$grantedRoles);
        
        return new Result($authenticationCode, $lii, $msgs);
    }
}
