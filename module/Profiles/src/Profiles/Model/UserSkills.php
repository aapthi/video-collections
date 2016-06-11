<?php
namespace Profiles\Model;

class UserSkills
{
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}