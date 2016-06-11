<?php
namespace Profiles\Model;

class Languages
{
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}