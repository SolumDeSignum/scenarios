<?php
	/**
	 * Created by PhpStorm.
	 * User: Faks
	 * GitHub: https://github.com/Faks
	 *******************************************
	 * Company Name: Solum DeSignum
	 * Company Website: http://solum-designum.com
	 * Company GitHub: https://github.com/SolumDeSignum
	 ********************************************************
	 * Date: 2018.07.30.
	 * Time: 20:19
	 */
	
	namespace SolumDeSignum\Scenarios;
	
	use Illuminate\Support\Facades\Route;
	use function ucfirst;
	
	
	/**
	 * Trait Scenarios
	 * @package SolumDeSignum\Scenarios
	 */
	trait Scenarios
	{
		/**
		 *
		 */
		public static $CURRENT_CONTROLLER_NAME_PATTERN = "/[_]([a-zA-Z]+)[_]|[_]([a-zA-Z]+)/m";
		/**
		 *
		 */
		public static $SCENARIO_PATTERN = '/create|update/im';
		/**
		 *
		 */
		public static $SCENARIO_CREATE = 'create';
		/**
		 *
		 */
		public static $SCENARIO_UPDATE = 'update';
		/**
		 * @var
		 */
		public static $SCENARIO_DESTROY = 'destroy';
		/**
		 * @var
		 */
		public $Scenario;
		
		
		/**
		 * Create a new rule instance.
		 *
		 * @return void
		 */
		
		public function __construct()
		{
			$this->Scenario;
		}
		
		/**
		 * @param $method
		 * @return bool
		 */
		public function Scenario_Pattern_Filter($method)
		{
			preg_match_all(self::$SCENARIO_PATTERN , strtolower($method), $matches);
			
			return $matches[0][0] ?? isset($matches[0][0]);
		}
		
		/**
		 * @return bool
		 */
		public function Scenario_Set_From_Current_Url()
		{
			$getActionMethod = self::Scenario_Pattern_Filter(self::Scenario_Current_Controller());
			$getRequestUri = self::Scenario_Pattern_Filter(self::Scenario_Current_Request_Uri());
			
			if ($getActionMethod === $getRequestUri)
			{
				return $this->Scenario = $getActionMethod;
			}
			else
			{
				#FallBack Scenario / Mitigate Artisan Issues
				return $this->Scenario = self::$SCENARIO_CREATE;
			}
		}
		
		/**
		 * @return string
		 */
		public function Scenario_Current_Controller()
		{
			if (!empty(Route::current()))
			{
				return Route::current()->getActionMethod();
			}
		}
		
		/**
		 * @return string
		 */
		public function Scenario_Current_Request_Uri()
		{
			if (!empty(Route::getCurrentRequest()))
			{
				return Route::getCurrentRequest()->getRequestUri();
			}
		}
		
		/**
		 * @return string
		 */
		public function Current_Controller_Function_Name()
		{
			preg_match_all(self::$CURRENT_CONTROLLER_NAME_PATTERN , self::Scenario_Current_Controller(), $matches, PREG_SET_ORDER, 1);
			return ucfirst($matches[0][1] ?? isset($matches[0][1]) ?:  $matches[0][2] ?? isset($matches[0][2]));
		}
	}