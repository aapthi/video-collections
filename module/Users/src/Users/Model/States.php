<?php
namespace Users\Model;

class States
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}