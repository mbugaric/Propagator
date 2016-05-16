//POZOR!!! NIJE DOBRO NAPRAVLJENO - NE DOPUŠTA MI SLANJE 
//PARAMETARA U handleStateChanged PA SE TA FUNKCIJA
//ŠALJE PRIKO Ajax.handler - TRIBA POPRAVITI NEKAKO !!!!

function Ajax(){};

Ajax.create = function()
{
	return window.XMLHttpRequest ? new XMLHttpRequest()
	   							 : new ActiveXObject("Microsoft.XMLHTTP");
};

Ajax.get = function(url, finishedHandler)
{
	Ajax.handler = finishedHandler;
	xmlHttpRequest = Ajax.create();
		
	xmlHttpRequest.onreadystatechange = Ajax.handleStateChanged;
	xmlHttpRequest.open("GET", url, true);
	xmlHttpRequest.send(null);
};
	
Ajax.handleStateChanged = function ()
{
	if(xmlHttpRequest.readyState == 4 || xmlHttpRequest.readyState == "complete")
	{ 
		Ajax.handler(xmlHttpRequest.responseText);//SET IN THE Ajax.get function 
	} 
};

Ajax.post = function(url, dataAsRequestString, finishedHandler)
{
	Ajax.handler = finishedHandler;
	xmlHttpRequest = Ajax.create();

	xmlHttpRequest.onreadystatechange = Ajax.handleStateChanged;
	xmlHttpRequest.open("POST", url, true);

	//Send the proper header information along with the request
	xmlHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttpRequest.setRequestHeader("Content-length", dataAsRequestString.length);
	xmlHttpRequest.setRequestHeader("Connection", "close");
	xmlHttpRequest.send(dataAsRequestString);
};