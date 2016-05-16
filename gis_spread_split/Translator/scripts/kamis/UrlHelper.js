function UrlHelper(){};

//function copied from http://www.11tmr.com/11tmr.nsf/D6Plinks/MWHE-695L9Z
UrlHelper.getAttributeValue = function(attribute)
{
	  var strReturn = "";
	  var strHref = window.location.href;
	  
	  if ( strHref.indexOf("?") > -1 )
	  {
	    var strQueryString = strHref.substr(strHref.indexOf("?"));
	    var aQueryString = strQueryString.split("&");
	    for ( var iParam = 0; iParam < aQueryString.length; iParam++ )
	    {
	      if (aQueryString[iParam].indexOf(attribute + "=") > -1 )
	      {
	    	  var aParam = aQueryString[iParam].split("=");
	    	  strReturn = aParam[1];
	    	  break;
	      }
	    }
	  }
	  
	  return unescape(strReturn);
}