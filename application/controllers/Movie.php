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
		

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('movie/index', $data);
		$this->load->view('templates/footer', $data);
		
	}

	public function detail($id,$type_detail)
	{
	
		$data['title'] = 'YAR MOVIE';
		$curl = curl_init();
		if ($type_detail == 1) {
		curl_setopt($curl, CURLOPT_URL, 'https://api.themoviedb.org/3/movie/'.$id.'?api_key=28112d15341f7f84fb5953983547c82a');
		}else{
		curl_setopt($curl, CURLOPT_URL, 'https://api.themoviedb.org/3/tv/'.$id.'?api_key=28112d15341f7f84fb5953983547c82a');
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$detail = curl_exec($curl);
		curl_close($curl);
		
		$data['detail'] = json_decode($detail, true);

		$curl2 = curl_init();
		if ($type_detail == 1) {
			curl_setopt($curl2, CURLOPT_URL, 'https://api.themoviedb.org/3/movie/'.$id.'/credits?api_key=28112d15341f7f84fb5953983547c82a');
		}else{
			curl_setopt($curl2, CURLOPT_URL, 'https://api.themoviedb.org/3/tv/'.$id.'/credits?api_key=28112d15341f7f84fb5953983547c82a');
		}
		curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
		$credits = curl_exec($curl2);
		curl_close($curl2);
		
		$data['credits'] = json_decode($credits, true);
		
		$curl3 = curl_init();
		if ($type_detail == 1) {
			curl_setopt($curl3, CURLOPT_URL, 'https://api.themoviedb.org/3/movie/'.$id.'/videos?api_key=28112d15341f7f84fb5953983547c82a');	
		}else{
			curl_setopt($curl3, CURLOPT_URL, 'https://api.themoviedb.org/3/tv/'.$id.'/videos?api_key=28112d15341f7f84fb5953983547c82a');	
		}
		curl_setopt($curl3, CURLOPT_RETURNTRANSFER, 1);
		$videos = curl_exec($curl3);
		curl_close($curl3);
		
		$data['videos'] = json_decode($videos, true);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		if ($type_detail == 1){
			$this->load->view('movie/detail', $data);
		}else{
			$this->load->view('movie/detail_tv', $data);			
		}
		$this->load->view('templates/footer', $data);
	}

	public function detail_season($id,$idseason)
	{
		$data['title'] = 'YAR MOVIE';
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, 'https://api.themoviedb.org/3/tv/'.$id.'/season/'.$idseason.'?api_key=28112d15341f7f84fb5953983547c82a');
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$detail_season = curl_exec($curl);
		curl_close($curl);
		
		$data['detail_season'] = json_decode($detail_season, true);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('movie/detail_season', $data);		
		$this->load->view('templates/footer', $data);
	}

}
