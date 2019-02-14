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
class PremiumMember extends member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    /**
     * Gets the premium member's indoor interests.
     * @return string
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * Sets the premium member's indoor interests.
     * @param string $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * Gets the premium member's outdoor interests.
     * @return string
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Sets the premium member's outdoor interests.
     * @param string $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }


}