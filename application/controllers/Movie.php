<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crew extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('movie_model', 'MMovie');
		check_login();
	}

	public function index()
	{
		$data['title'] = 'My Profile';
		$data['user'] = $this->MCrew->userID();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/index', $data);
		$this->load->view('templates/footer');
	}

	public function crewlist()
	{
		$selectbyvessel = htmlspecialchars($this->input->post('selectbyvessel', true));
		
		$selectbystatus = htmlspecialchars($this->input->post('selectbystatus', true));
		
		if ($selectbystatus == 0) {
			$status = "On Board";
		} elseif($selectbystatus == 1) {
			$status = "Sign Off";
		}elseif($selectbystatus == 2) {
			$status = "Stand By";
		}elseif($selectbystatus == 4) {
			$status = "Jump Ship";
		}else{
			$status = "Probation";
		}

		$data['selectbyvessel'] = $selectbyvessel;
		$data['selectbystatus'] = $selectbystatus;
		$data['user'] = $this->MCrew->userID();

		$data['crewlist'] = $this->MCrew->getAllCrewBySelect($selectbyvessel,$selectbystatus);
		if (empty($selectbyvessel)) {
			$data['title'] = 'All Crew '. $status ;
		}else{
		$data['title'] = 'Crew '. $selectbyvessel .  ' ' . $status;			
		}

		
		$data['vessel'] = $this->MCrew->getAllVessel();
		$data['position'] = $this->MCrew->getAllPosition();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/listcrew', $data);
		$this->load->view('templates/footer');
	}


	public function crewDetail($id)
	{
		$data['title'] = 'crew Detail';
		$data['crewbyid'] = $this->MCrew->getCrewById($id);
		$data['user'] = $this->MCrew->userID();
		$data['certificates'] = $this->MCrew->getCertificatesById($id);
		$data['mutation'] = $this->MCrew->getMutationById($id);
		$data['idmutation'] = $this->MCrew->getLastMutationId($id);
		
		$this->form_validation->set_rules('certificates', 'Certificates', 'required|trim');
		$this->form_validation->set_rules('no_certificates', 'No Certificates', 'required|trim');
		$this->form_validation->set_rules('date_issued', 'Date Issued', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/crewdetail', $data);
		$this->load->view('templates/footer');
		}else {
		$this->MCrew->addNewCertificates();
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New certificates added</div>');
		redirect('crew/crewdetail/'.$idcrew);
		}
	}

	public function addCrew()
	{
		$data['title'] = 'Add Crew';
		$data['user'] = $this->MCrew->userID();
		$data['rekening_name'] = $this->MCrew->getAllRekening();
		$data['vessel'] = $this->MCrew->getAllVessel();
		$data['certificatesC'] = $this->MCrew->getAllCertificatesC();
		$data['position'] = $this->MCrew->getAllPosition();

		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

		$this->form_validation->set_rules('seafarer_code', 'Seafarer Code', 'required|trim|is_unique[crew.seafarer_code]', [
			'is_unique' => 'This Seafarer Code has already registered!'
		]);

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('place', 'Place', 'required|trim');
		$this->form_validation->set_rules('date_birth', 'Date Birth', 'required|trim');
		$this->form_validation->set_rules('religion', 'Religion', 'required|trim');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
		$this->form_validation->set_rules('address', 'Address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		$this->form_validation->set_rules('contact_urgent', 'Contact Urgent', 'required|trim');

		$this->form_validation->set_rules('salary1', 'Salary', 'required|trim');
		$this->form_validation->set_rules('job_allowance1', 'Job Allowance', 'required|trim');
		$this->form_validation->set_rules('certificates_allowance1', 'Certificates Allowance', 'required|trim');
		
		$this->form_validation->set_rules('idposition', 'Position', 'required|trim', [
			'required' => 'Selected Position'
		]);

		$this->form_validation->set_rules('thr_religion', 'THR Religion', 'required|trim', [
			'required' => 'Selected THR'
		]);

		$this->form_validation->set_rules('rekening', 'No Rekening', 'required|trim');

		$this->form_validation->set_rules('probation', 'Probation', 'required|trim', [
			'required' => 'Selected Probation'
		]);

		$this->form_validation->set_rules('bpjs', 'Bpjs', 'required|trim', [
			'required' => 'Selected BPJS Kesehatan'
		]);

		$this->form_validation->set_rules('bpjs2', 'Bpjs', 'required|trim', [
			'required' => 'Selected BPJS Ketenagakerjaan'
		]);


		$this->form_validation->set_rules('date_entry', 'Date Entry', 'required|trim');

		$this->form_validation->set_rules('vessel', 'Vessel', 'required|trim', [
			'required' => 'Selected Vessel'
		]);

		$this->form_validation->set_rules('statuss', 'Statuss', 'required|trim', [
			'required' => 'Selected Status'
		]);
		$this->form_validation->set_rules('contract', 'Contract', 'required|trim', [
			'required' => 'Selected Contract'
		]);
		$this->form_validation->set_rules('certificates_competency', 'Certificates Competency', 'required|trim', [
			'required' => 'Selected Certificates Competency'
		]);
		$this->form_validation->set_rules('rekening_name', 'Rekening Name', 'required|trim', [
			'required' => 'Selected Rekening Name'
		]);

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/addcrew', $data);
		$this->load->view('templates/footer');
		} else {
		$this->MCrew->addNewCrew();
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New crew added</div>');
		redirect('crew/crewlist');
		}

	}

		public function crewEdit($id)
	{
		$data['title'] = 'Form Edit Crew';
		
		$data['crewbyid'] = $this->MCrew->getCrewById($id);
		$data['user'] = $this->MCrew->UserID();
		
		$data['vessel'] = $this->MCrew->getAllVessel();
		$data['rekening_name'] = $this->MCrew->getAllRekening();
		$data['certificatesC'] = $this->MCrew->getAllCertificatesC();
		$data['position'] = $this->MCrew->getAllPosition();

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('place', 'Place', 'required|trim');
		$this->form_validation->set_rules('date_birth', 'Date Birth', 'required|trim');
		$this->form_validation->set_rules('religion', 'Religion', 'required|trim');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'required|trim');
		$this->form_validation->set_rules('address', 'Address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		$this->form_validation->set_rules('rekening', 'No Rekening', 'required|trim');
		$this->form_validation->set_rules('contact_urgent', 'Contact Urgent', 'required|trim');
		
		$this->form_validation->set_rules('bpjs', 'Bpjs', 'required|trim', [
			'required' => 'Selected BPJS Kesehatan'
		]);

		$this->form_validation->set_rules('bpjs2', 'Bpjs', 'required|trim', [
			'required' => 'Selected BPJS Ketenagakerjaan'
		]);

		$this->form_validation->set_rules('certificates_competency', 'Certificates Competency', 'required|trim', [
			'required' => 'Selected Certificates Competency'
		]);

		$this->form_validation->set_rules('rekening_name', 'Rekening Name', 'required|trim', [
			'required' => 'Selected Rekening Name'
		]);

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/editcrew', $data);
		$this->load->view('templates/footer');
		} else {
		$this->MCrew->crewEdit();
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> crew edited</div>');
		redirect('crew/crewlist');
		}

	}

	public function crewDelete($id)
	{
		$row  = $this->db->query("SELECT * FROM `crew` WHERE `crew`.`idcrew` = $id ORDER BY `idcrew` DESC limit 1")->row();
		$image_certificates = $row->image_certificates;
		$old_image_certificates = $image_certificates;
				if ($old_image_certificates != 'default.jpg') {
					unlink(FCPATH . 'assets/img/profile/' . $old_image_certificates);
				}

		$query1 = "SELECT * FROM `certificates` JOIN `crew` ON `crew`.`idcrew` = `certificates`.`id_crew` WHERE `certificates`.`id_crew` = '$id'";
		$certificatesfile = $this->db->query($query1)->result_array();

		foreach ($certificatesfile as $cf) {
			if ($cf['image_certificates'] != 'default.png' ) {
			unlink(FCPATH . '/assets/img/certificates/' . $cf['image_certificates']);
			}
		}		
		$this->MCrew->deleteCrew($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> crew deleted</div>');
				redirect('crew/crewlist');
	}

		public function certificates()
	{
		$selectbyvessel = htmlspecialchars($this->input->post('selectbyvessel', true));
		
		$selectbystatus = htmlspecialchars($this->input->post('selectbystatus', true));
		

		$data['selectbyvessel'] = $selectbyvessel;
		$data['selectbystatus'] = $selectbystatus;
		$data['user'] = $this->MCrew->userID();

		$data['certificates'] = $this->MCrew->getAllCertificates($selectbyvessel,$selectbystatus);
		if (empty($selectbyvessel)) {
		$data['title'] = 'All Crew ';
		}else{
		$data['title'] = 'Crew '. $selectbyvessel;			
		}
		$data['vessel'] = $this->MCrew->getAllVessel();
		
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/certificates', $data);
		$this->load->view('templates/footer');
	}
	
	public function certificatesEdit($id)
	{
		$data['title'] = 'Certificates Edit';
		$data['user'] = $this->MCrew->userID();
		$data['certificatesbyid'] = $this->MCrew->getCertificatesFromId($id);
	

		$this->form_validation->set_rules('certificates', 'Certificates', 'required|trim');
		$this->form_validation->set_rules('no_certificates', 'No Certificates', 'required|trim');
		$this->form_validation->set_rules('date_issued', 'Date Issued', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/editcertificates', $data);
		$this->load->view('templates/footer');
		} else {
		$this->MCrew->editCertificates();
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">certificates edited</div>');
		redirect('crew/crewdetail/'.$idcrew);
		}
	}

		public function certificatesDelete($id)
	{
		$row  = $this->db->query("SELECT `id_crew` FROM `certificates` WHERE `certificates`.`idcertificates` = $id")->row();
             $idcrew  = $row->id_crew;
		$this->MCrew->deleteCertificates($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Certificates deleted</div>');
				redirect('crew/crewdetail/'.$idcrew);
	}

	public function AddMutation($id)
	{
		$data['title'] = 'Add Mutation';
		$data['crewbyid'] = $this->MCrew->getCrewById($id);
		$data['user'] = $this->MCrew->userID();
		$data['vessel'] = $this->MCrew->getAllVessel();
		$data['mutation'] = $this->MCrew->getMutationById($id);


		$this->form_validation->set_rules('date_entry', 'Date Entry', 'required|trim');

		$this->form_validation->set_rules('vessel', 'Vessel', 'required|trim', [
			'required' => 'Selected Vessel'
		]);

		$this->form_validation->set_rules('change_hd', 'Change Hire Date', 'required|trim', [
			'required' => 'Selected Change Hire Date'
		]);
		

		$this->form_validation->set_rules('status', 'Status', 'required|trim', [
			'required' => 'Selected Status'
		]);

		$this->form_validation->set_rules('contract', 'Contract', 'required|trim', [
			'required' => 'Selected Contract'
		]);

		$this->form_validation->set_rules('probation', 'Probation', 'required|trim', [
			'required' => 'Selected Probation'
		]);


		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/addmutation', $data);
		$this->load->view('templates/footer');
		}else {
		$this->MCrew->AddMutation();
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> New mutation added</div>');
		redirect('crew/crewdetail/'.$idcrew);
		}
	}

	public function MutationEdit($id)
	{
		$data['title'] = 'Edit Mutation';
		$data['user'] = $this->MCrew->userID();
		$data['vessel'] = $this->MCrew->getAllVessel();
		$data['mutationbyid'] = $this->MCrew->getMutationEditById($id);
		$row  = $this->db->query("SELECT * FROM `mutation` WHERE `mutation`.`idmutation` = $id")->row();
		$id = $row->id_crew;
		$data['crewbyid'] = $this->MCrew->getCrewById($id);

		$this->form_validation->set_rules('probation', 'Probation', 'required|trim', [
			'required' => 'Selected Probation'
		]);


		$this->form_validation->set_rules('date_entry', 'Date Entry', 'required|trim');

		$this->form_validation->set_rules('vessel', 'Vessel', 'required|trim', [
			'required' => 'Selected Vessel'
		]);

		$this->form_validation->set_rules('change_hd', 'Change Hire Date', 'required|trim', [
			'required' => 'Selected Change Hire Date'
		]);

		$this->form_validation->set_rules('status', 'Status', 'required|trim', [
			'required' => 'Selected Status'
		]);

		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('crew/editmutation', $data);
		$this->load->view('templates/footer');
		}else {
		$this->MCrew->EditMutation();
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Mutation edited</div>');
		redirect('crew/crewdetail/'.$idcrew);
		}
	}

	

	function getVesselCrew(){
        $id = $this->input->post('id',TRUE);
        $data = $this->MCrew->getVesselCrew($id)->result();
        echo json_encode($data);
    }
	

	public function excelbycrew()
	{
		$selectbyvessel = htmlspecialchars($this->input->post('selectbyvessel', true));
		$selectbystatus = htmlspecialchars($this->input->post('selectbystatus', true));

		if ($selectbystatus == 0) {
			$status = "On Board";
		} elseif($selectbystatus == 1) {
			$status = "Sign Off";
		}elseif($selectbystatus == 2) {
			$status = "Stand By";
		}elseif($selectbystatus == 4) {
			$status = "Jump Ship";
		}else{
			$status = "Probation";
		}

		$data['crewlist'] = $this->MCrew->getAllCrewBySelect($selectbyvessel,$selectbystatus);
		if (empty($selectbyvessel)) {
		$data['title'] = 'All Crew '. $status;
		}else{
		$data['title'] = 'Crew '. $selectbyvessel. ' ' . $status;			
		}

		$this->load->view('templates/header', $data);
		$this->load->view('crew/excelbycrew', $data);		
	}

	public function printbycrewdetail($id)
	{
		$data['title'] = 'Crew';
		$data['crewbyid'] = $this->MCrew->getCrewById($id);
		$data['user'] = $this->MCrew->userID();
		$data['certificates'] = $this->MCrew->getCertificatesById($id);
		$data['mutation'] = $this->MCrew->getMutationById($id);
		$data['idmutation'] = $this->MCrew->getLastMutationId($id);

		$this->load->view('templates/header', $data);
		$this->load->view('crew/printbycrewdetail', $data);		
	}

	public function excelbycrewmutation($id)
	{
		$data['title'] = 'Crew';
		$data['crewbyid'] = $this->MCrew->getCrewById($id);
		$data['user'] = $this->MCrew->userID();
		$data['certificates'] = $this->MCrew->getCertificatesById($id);
		$data['mutation'] = $this->MCrew->getMutationById($id);
		$data['idmutation'] = $this->MCrew->getLastMutationId($id);

		$this->load->view('templates/header', $data);
		$this->load->view('crew/excelbycrewmutation', $data);		
	}

		public function excelbylistcertificates()
	{
		$selectbyvessel = htmlspecialchars($this->input->post('selectbyvessel', true));
		$selectbystatus = htmlspecialchars($this->input->post('selectbystatus', true));
		

		$data['selectbyvessel'] = $selectbyvessel;
		$data['selectbystatus'] = $selectbystatus;


		$data['title'] = 'Certificates Crew';
		$data['user'] = $this->MCrew->userID();
		$data['certificates'] = $this->MCrew->getAllCertificates($selectbyvessel,$selectbystatus);
		

		$this->load->view('templates/header', $data);
		$this->load->view('crew/excelbylistcertificates', $data);		
	}

	public function downloadfile($id)
	{
		$row  = $this->db->query("SELECT * FROM `certificates` WHERE `certificates`.`idcertificates` = $id ORDER BY `idcertificates` DESC limit 1")->row();
		$doc_name = $row->image_certificates;
		$filename = 'assets/img/certificates/'.$doc_name;
		force_download($filename, NULL);
	}

	

	function get_autocomplete(){
    if (isset($_GET['term'])) {
        $result = $this->MCrew->coba($_GET['term']);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label'         => $row->position,
                    'idposition'    => $row->idposition,
                    'salary'   => $row->salary,
                    'job_allowance'   => $row->job_allowance,
                    'certificates_allowance'   => $row->certificates_allowance,
                    'salary_bpjs'   => $row->salary_bpjs
                    
             );
                echo json_encode($arr_result);
        }
    }
}



}
