<?php

	class  Weather
	{
		protected $location_ = false;
		protected $current_ = false;
		protected $future_ = false;

		public function __construct($location){

			//Location must not be empty    
			if($location != ""){
				$this->location_ = $location;
				$this->getWeather();    
			}       
		}

		private function getWeather(){

			//If location is set
			if($this->location_){
				$xml = simplexml_load_file('http://www.google.com/ig/api?weather='.urlencode($this->location_));
				$this->current_ = $xml->xpath("/xml_api_reply/weather/current_conditions");
				$this->future_ = $xml->xpath("/xml_api_reply/weather/forecast_conditions"); 
			}
		}

		/**
		 * Gets the current location
		 */
		public function getLocation(){
			return ucwords($this->location_);
		}
		
	}
	
	if(isset($_GET['location'])){
		require_once './php/displayWeather.php';
		$weather = new displayWeather($_GET['location'], "c"); 
	}

	<div class="weather_location">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
			<p><label for="location"><input type="text" id="location" name="location" placeholder="Enter your location" /></label></p>
			<input type="submit" value="Submit" name="submit" />
		</form>
		<hr/>
	</div>

	<?php if(isset($_GET['location']) && $_GET['location'] != ""){  

		$weather->displayCurrentWeather(); 

		$weather->displayFutureWeather();

	} ?>
?>