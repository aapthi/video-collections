<?php
namespace Profiles\Model;

class City
{
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}