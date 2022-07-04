<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Movie extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('movie_model', 'MMovie');
	}

	public function index()
	{
		$data['title'] = 'YAR MOVIE';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://api.themoviedb.org/3/trending/all/day?api_key=28112d15341f7f84fb5953983547c82a');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);

		$data['result'] = json_decode($result, true);
		
		
		$curl2 = curl_init();
		curl_setopt($curl2, CURLOPT_URL, 'https://api.themoviedb.org/3/movie/upcoming?api_key=28112d15341f7f84fb5953983547c82a&page=1');
		curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
		$upcoming = curl_exec($curl2);
		curl_close($curl2);		 
		$data['upcoming'] = json_decode($upcoming, true);
		

		$this->load->view('movie/index', $data);
		
	}

}
