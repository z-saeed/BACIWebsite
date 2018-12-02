<?php

class Pair
{
	private $menteeID;
	private $mentorID;
	private $requester;
	private $change; //used to send a # to pairing.php indicating what changes need to be made to the database i.e. end, start, deny
	

	function __construct($menteeID = "", $mentorID = "", $requester = "", $change = 15)
	{
		$this->menteeID = $menteeID;
		$this->mentorID = $mentorID;
		$this->requester = $requester;
		$this->change = $change;
	}

    public function getMenteeID()
    {
        return $this->menteeID;
    }

    public function setMenteeID($menteeID)
    {
        $this->menteeID = $menteeID;
    }

	public function getMentorID()
    {
        return $this->mentorID;
    }

    public function setMentorID($mentorID)
    {
        $this->mentorID = $mentorID;
    }
	
	public function getRequester()
    {
        return $this->requester;
    }

    public function setRequester($requester)
    {
        $this->requester = $requester;
    }
	
	public function getChange()
    {
        return $this->change;
    }

    public function setChange($change)
    {
        $this->change = $change;
    }
	
}