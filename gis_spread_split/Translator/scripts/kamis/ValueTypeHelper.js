function ValueTypeHelper(){};

ValueTypeHelper.startsWith = function (mainString, value)
{
	index = mainString.indexOf(value);
	
	if (index === -1) { return false; }
	if (index === 0) { return true; }
	
	return false;
};

