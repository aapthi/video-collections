<?php
namespace Application\Model;

class CategoryTypes
{
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}