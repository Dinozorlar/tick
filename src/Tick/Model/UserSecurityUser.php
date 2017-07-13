<?php

namespace Tick\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;


class UserSecurityUser implements AdvancedUserInterface
{
    protected $username;
    protected $password;
    protected $salt;
    private $enabled;

    private $accountNonExpired;
    private $accountNonLocked;
    private $credentialNonExpired;

    private $roles = ['USER'];
    private $groups = [];

    private $userUid = null;
    private $userID = null;

    private $fullName = '';

    public function __construct($username, $password, array $roles = [], $enabled = true, $userNonExpired = true, $credentialsNonExpired = true, $userNonLocked = true)
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('USERNAME_YOK');
        }

        $this->username = $username;
        $this->password = $password;
        $this->enabled = $enabled;
        $this->accountNonExpired = $userNonExpired;
        $this->credentialNonExpired = $credentialsNonExpired;
        $this->accountNonLocked = $userNonLocked;
        $this->roles = $roles;

    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return $this->accountNonExpired;
    }

    /**
     * @param bool $accountNonExpired
     */
    public function setAccountNonExpired($accountNonExpired)
    {
        $this->accountNonExpired = $accountNonExpired;
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return $this->accountNonLocked;
    }

    /**
     * @param bool $accountNonLocked
     */
    public function setAccountNonLocked($accountNonLocked)
    {
        $this->accountNonLocked = $accountNonLocked;
    }

    /**
     * @return bool
     */
    public function isCredentialNonExpired()
    {
        return $this->credentialNonExpired;
    }

    /**
     * @param bool $credentialNonExpired
     */
    public function setCredentialNonExpired($credentialNonExpired)
    {
        $this->credentialNonExpired = $credentialNonExpired;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return null
     */
    public function getUserUid()
    {
        return $this->userUid;
    }

    /**
     * @param null $userUid
     */
    public function setUserUid($userUid)
    {
        $this->userUid = $userUid;
    }

    /**
     * @return null
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param null $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function eraseCredentials()
    {

    }

    public function isCredentialsNonExpired()
    {

    }

    public function setSalt($salt){
        $this->salt = $salt;
    }


}