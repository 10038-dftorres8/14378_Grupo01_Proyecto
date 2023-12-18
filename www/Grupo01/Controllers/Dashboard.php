<?php 
session_start();

	class Dashboard extends Controllers{
		public function __construct()
		{
			parent::__construct();
			
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/home');
			}
				
		}

		public function dashboard()
		{
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard - VERIS";
			$data['page_title'] = "Dashboard - VERIS";
			$data['page_name'] = "dashboard";
			$data['page_functions_js'] = "functions_dashboard.js";
			$this->views->getView($this,"dashboard",$data);
		}

	}
 ?>