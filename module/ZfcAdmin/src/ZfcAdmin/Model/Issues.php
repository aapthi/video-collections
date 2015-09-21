<?php
namespace ZfcAdmin\Model;

class Issues
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}