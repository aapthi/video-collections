<?php
namespace Profiles\Model;

class UserVideo
{
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}