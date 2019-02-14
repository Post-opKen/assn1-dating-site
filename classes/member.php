<?php
/*
Ean Daus
2/14/19
member.php
represents a member of the dating site
*/

/**
 * Class Member
 * Represents a member of the dating site, with a first and last name,
 * age, gender, phone number, email, state, seeking gender, and bio.
 */
class Member
{
    private $_first;
    private $_last;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Makes a new Member.
     * @param $_first
     * @param $_last
     * @param $_age
     * @param $_gender
     * @param $_phone
     */
    public function __construct($_first, $_last, $_age, $_gender, $_phone)
    {
        $this->_first = $_first;
        $this->_last = $_last;
        $this->_age = $_age;
        $this->_gender = $_gender;
        $this->_phone = $_phone;
    }

    //Getters and Setters

    /**
     * Gets the member's first name.
     * @return string
     */
    public function getFirst()
    {
        return $this->_first;
    }

    /**
     * Sets the member's new first name.
     * @param string $first
     */
    public function setFirst($first)
    {
        $this->_first = $first;
    }

    /**
     * Gets the member's last name.
     * @return string
     */
    public function getLast()
    {
        return $this->_last;
    }

    /**
     * Sets the member's new last name.
     * @param string $last
     */
    public function setLast($last)
    {
        $this->_last = $last;
    }

    /**
     * Gets the member's age.
     * @return int
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Sets the member's new age.
     * @param int $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Gets the member's gender.
     * @return string
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Sets the member's new gender.
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Gets the member's phone number.
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets the member's new phone number.
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Gets the member's email.
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the member's new email.
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Gets the member's state.
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets the member's new state.
     * @param string $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * Gets the gender the member is seeking.
     * @return string
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * Sets the gender the member is seeking.
     * @param string $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * Gets the member's bio.
     * @return string
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * Sets the member's new bio.
     * @param string $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }


}