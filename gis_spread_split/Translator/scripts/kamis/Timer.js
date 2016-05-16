function Timer(){};

Timer.intervalElapsed = function (intervalInSeconds, handler)
{
	var intervalInMiliSeconds = intervalInSeconds * 1000;
	setTimeout(handler, intervalInMiliSeconds);
}