function EventHelper(){};

EventHelper.addEventHandler = function (object, eventType, handler)
{ 
	 if (object.addEventListener)
	 { 
		 object.addEventListener(eventType, handler, false); 
		 return true; 
	 } 
	 else if (object.attachEvent){ return object.attachEvent("on" + eventType, handler); } 
	 else { return false; } 
};
