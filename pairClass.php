<?php

class Pair
{
	private $menteeID;
	private $mentorID;
	private $requester;
	

	function __construct($menteeID = "", $mentorID = "", $requester = "")
	{
		$this->menteeID = $menteeID;
		$this->mentorID = $mentorID;
		$this->requester = $requester;
	}

    public function getMenteeID()
    {
        return $this->menteeID;
    }

    public function setMenteeID($menteeID)
    {
        $this->ID = $menteeID;
    }

	public function getMentorID()
    {
        return $this->mentorID;
    }

    public function setMentorID($mentorID)
    {
        $this->ID = $mentorID;
    }
	
	public function getRequester()
    {
        return $this->requester;
    }

    public function setRequester($requester)
    {
        $this->ID = $requester;
    }
	
}