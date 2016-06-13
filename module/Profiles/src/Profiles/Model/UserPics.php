<?php
namespace Profiles\Model;

class UserPics
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}