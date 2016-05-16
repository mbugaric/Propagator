<?php 

class APIkey
{
	private $request;
	private $keys = Array();
	private $users = Array();
	
	public function __construct() 
	{
		
		$dbconn = pg_connect("host=localhost dbname=AdriaFirePropagator user=postgres password=AdriaDB4prop")
			or die('Could not connect to the database: ' . pg_last_error());
		
		$query = "SELECT username FROM users";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			foreach ($line as $col_value) {
				array_push($this->users, $col_value);
				array_push($this->keys,"3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
			}
		}
		
		// Free resultset
		pg_free_result($result);

		// Closing connection
		pg_close($dbconn);
		
		/*//All users will share the same key for now
		array_push($this->users, "in2");
		array_push($this->keys,"3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");

		array_push($this->users, "admin");
		array_push($this->keys,"3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
		
		array_push($this->users, "myUsername");
		array_push($this->keys,"3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
		
		for($cc=1;$cc<30;$cc++)
		{
			$users[$counter]["usrname"]="user".$cc;
			array_push($this->users, $users[$counter]["usrname"]);
			array_push($this->keys,"3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
		}*/
		
	}
	
	public function verifyKey($request)
	{

		if(array_key_exists('lat', $request) && array_key_exists('long', $request))
		{
			$this->request = $request;
			$found=0;

			for ($i = 0; $i<count($this->keys); $i++) {
				//var_dump(hash_hmac("sha256", $this->users[$i].$this->request['lat'].$this->request['long'], $this->keys[$i]));
				if ( (hash_hmac("sha256", $this->users[$i].$this->request['lat'].$this->request['long'], $this->keys[$i])) == $this->request['sig'])
				{
					if($this->users[$i] == $_GET["user"])
					{
						$found=1;
					}
				}
			}
			
			if($found)
				return true;
			else
				return false;
		}
		else if(array_key_exists('pid', $request))
		{
			$this->request = $request;
			$found=0;

			for ($i = 0; $i<count($this->keys); $i++) {
				if ( (hash_hmac("sha256", $this->users[$i].$this->request['pid'], $this->keys[$i])) == $this->request['sig'])
				{
					
					$found=1;
				}
			}
			
			if($found)
				return true;
			else
				return false;
		}
	}
	
	public function debug()
	{
		var_dump($this->keys);
	}
}

/*
You should look into request signing. A great example is Amazon's S3 REST API.

The overview is actually pretty straightforward. The user has two important pieces of information to use your API, a public user id and a private API Key. They send the public id with the request, and use the private key to sign the request. The receiving server looks up the user's key and decides if the signed request is valid. The flow is something like this:

User joins your service and gets a user id (e.g. 123) and an API key.
User wants to make a request to your API service to update their email address, so they need to send a request to your API, perhaps to /user/update?email=new@example.com.
In order to make it possible to verify the request, the user adds the user id and a signature to the call, so the call becomes /user/update?email=new@example.com&userid=123&sig=some_generated_string
The server receives the call, sees that it's from userid=123, and looks up the API key for that user. It then replicates the steps to create the signature from the data, and if the signature matches, the request is valid.
This methodology ensures the API key is never sent as part of the communication.

Take a look at PHP's hash_hmac() function, it's popular for sending signed requests. Generally you get the user to do something like put all the parameters into an array, sort alphabetically, concatenate into a string and then hash_hmac that string to get the sig. In this example you might do:

$sig = hash_hmac("sha256",$params['email'].$params['userid'],$API_KEY)
Then add that $sig onto the REST url as mentioned above.


//Za API
//$sig = hash_hmac("sha256", $params['email'].$params['userid'], $API_KEY)
*/

?>