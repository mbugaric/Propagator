function DomHelper(){};

DomHelper.selectOption = function(selectElement, valueToSelect)
{
	if(!selectElement) { return; }
	
	for(var i = 0; i < selectElement.length; i++)
	{
		if(selectElement[i].value === valueToSelect)
		{
			selectElement[i].selected = 1;
			break;
		}
	}
};

DomHelper.getElementsIdStartsWith = function(tagName,idStartString)
{
	var allElements = document.getElementsByTagName(tagName);
	var resultElements = new Array();
	
	for(var i = 0; i < allElements.length; i++)
	{
		if(ValueTypeHelper.startsWith(allElements[i].id, idStartString))
		{
			resultElements.push(allElements[i]);
		}
	}
	
	return resultElements;
}