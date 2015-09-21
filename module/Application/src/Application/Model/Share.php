<?php
namespace Application\Model;

class Share
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}