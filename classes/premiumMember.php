<?php
/*
Ean Daus
2/14/19
premiumMember.php
represents a premium member of the dating site
*/

/**
 * Class PremiumMember
 * Represents a premium member of the dating site, with indoor and outdoor interests.
 */
class PremiumMember extends Member
{
    private $_inDoorInterests = array();
    private $_outDoorInterests = array();

    /**
     * Gets the premium member's indoor interests.
     * @return array
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * Sets the premium member's indoor interests.
     * @param array $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * Gets the premium member's outdoor interests.
     * @return array
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Sets the premium member's outdoor interests.
     * @param array $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }


}