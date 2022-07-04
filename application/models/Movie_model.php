<?php 

class Movie_model extends CI_Model 
{

	public function userID()
	{
		$email = $this->session->userdata('email');
		return $this->db->query("SELECT * FROM `user` JOIN `user_role` ON `user_role`.`id` = `user`.`role_id` WHERE `user`.`email` = '$email'")->row_array();
	}

	public function getAllCrewBySelect($selectbyvessel,$selectbystatus)
	{
		$this->db->join('rekening_name','rekening_name.idrekening = crew.id_rekening');
		$this->db->join('position','position.idposition = crew.id_position');
		$this->db->join('vessel','vessel.idvessel = crew.id_vessel');
		$this->db->join('certificates_competency','certificates_competency.idcc = crew.id_cc');

		if (empty($selectbyvessel)) {
			
			if ($selectbystatus == 0) {
				$this->db->order_by('contract_expires', 'ASC');
				$this->db->where_in('crew.is_active',[$selectbystatus,'3']);
				return $this->db->get('crew')->result_array(); 
			}else{
				$this->db->order_by('contract_expires', 'ASC');
				$this->db->where('crew.is_active',$selectbystatus);
				return $this->db->get('crew')->result_array(); 
			}
		}
			if ($selectbystatus == 0) {
				$this->db->order_by('position.sort_position', 'ASC');
				$this->db->where_in('crew.is_active',[$selectbystatus,'3']);
				return $this->db->get_where('crew',['vessel' => $selectbyvessel])->result_array();
				
			} else {
				$this->db->order_by('position.sort_position', 'ASC');
				return $this->db->get_where('crew',['vessel.vessel' => $selectbyvessel, 'crew.is_active' => $selectbystatus])->result_array();
			 }
	}

	public function getCrewById($id)
	{
		$this->db->join('rekening_name','rekening_name.idrekening = crew.id_rekening');
		$this->db->join('position','position.idposition = crew.id_position');
		$this->db->join('vessel','vessel.idvessel = crew.id_vessel');
		$this->db->join('certificates_competency','certificates_competency.idcc = crew.id_cc');
		return $this->db->get_where('crew',['idcrew' => $id])->row_array();
	}

	public function getAllVessel()
	{
		$this->db->order_by('vessel', 'ASC');
		return	$this->db->get('vessel')->result_array();
	}

	public function getAllRekening()
	{
		$this->db->order_by('rekening_name', 'ASC');
		return	$this->db->get('rekening_name')->result_array();
	}

		public function getAllCertificatesC()
	{
		$this->db->order_by('cc_name', 'ASC');
		return	$this->db->get('certificates_competency')->result_array();
	}

	public function getVesselCrew($id)
	{
        return $this->db->get_where('crew', ['id_vessel' => $id]);
    }   

	public function getAllPosition()
	{
		return $this->db->get('position')->result_array();
	}

	public function getMutationById($id)
	{
		$this->db->join('crew', 'crew.idcrew = mutation.id_crew');
		$this->db->join('vessel', 'vessel.idvessel = mutation.id_vessel');
		$this->db->join('position', 'position.idposition = mutation.id_position');
		return $this->db->get_where('mutation', ['id_crew' => $id])->result_array();
		
	}

		public function getMutationEditById($id)
	{
		$this->db->join('crew', 'crew.idcrew = mutation.id_crew');
		$this->db->join('vessel', 'vessel.idvessel = mutation.id_vessel');
		$this->db->join('position', 'position.idposition = mutation.id_position');
		return $this->db->get_where('mutation', ['idmutation' => $id])->row_array();
	}

		public function getLastMutationId($id)
	{
		$this->db->order_by('idmutation', 'DESC');
		$row = $this->db->get_where('mutation', ['id_crew' => $id], 1)->row_array();
		$idmutation = $row['idmutation'];

		$this->db->join('crew', 'crew.idcrew = mutation.id_crew');
		$this->db->join('vessel', 'vessel.idvessel = mutation.id_vessel');
		$this->db->join('position', 'position.idposition = mutation.id_position');
		return $this->db->get_where('mutation', ['idmutation' => $idmutation])->row_array();
	}

	public function getCertificatesById($id)
	{
		$this->db->join('crew', 'crew.idcrew = certificates.id_crew');
		$this->db->order_by('certificates.idcertificates', 'ASC');
		return $this->db->get_where('certificates' , ['id_crew' => $id])->result_array();
	}
	
		public function getCertificatesFromId($id)
	{
		$this->db->join('crew', 'crew.idcrew = certificates.id_crew');
		return $this->db->get_where('certificates', ['idcertificates' => $id])->row_array();
	}

	public function getAllCertificates($selectbyvessel,$selectbystatus)
	{	
		$this->db->join('vessel', 'vessel.idvessel = certificates.id_vessel');
		$this->db->join('crew', 'crew.idcrew = certificates.id_crew');
		$this->db->order_by('date_expaired','ASC');
		
		if (empty($selectbyvessel)) {
			if (empty($selectbystatus)) {
				return $this->db->get_where('certificates',['vessel.vessel' => 'TB.Amazon Harbour'])->result_array();
			}else{
				return $this->db->get_where('certificates',['vessel.vessel' => 'TB.Amazon Harbour', 'certificates.code_status' => $selectbystatus])->result_array();
		 	}
		}
		if (empty($selectbystatus)) {
			return $this->db->get_where('certificates',['vessel.vessel' => $selectbyvessel])->result_array();
		} else {
			return $this->db->get_where('certificates',['vessel.vessel' => $selectbyvessel, 'certificates.code_status' => $selectbystatus])->result_array();
		}
	}

	public function addNewCrew()
	{
		$upload_image = $_FILES['image']['name'];
		
		$date_entry = strtotime(htmlspecialchars($this->input->post('date_entry', true)));
		// pilih contract menentuakn expaired contract
		$contract = htmlspecialchars($this->input->post('contract', true));
		if ($contract == "Contract Employees 6 Mount") {
			$month = 6;
		}elseif ($contract == "Contract Employees 9 Mount") {
			$month = 9;
		} else {
			$month = 12;
		}
		$contract_expires = strtotime('+'.$month.'month', $date_entry);

            $date_now = time();
            $m = -1;
            $d = -7;
            $contract_expires_30 = strtotime($m.'month', $contract_expires); 
            $contract_expires_7 = strtotime($d.'days', $contract_expires); 
           

		//pilih masa probation
		$probation = htmlspecialchars($this->input->post('probation', true));
		if ($probation == "Probation 3 Mount") {
			$pmonth = 3;
		} else {
			$pmonth = 0;
		}

		$probation_expires = strtotime('+'.$pmonth.'month', $date_entry);

		// pilih status 
		$marital_status = htmlspecialchars($this->input->post('marital_status', true));
		if ($marital_status == "Single") {
			$children = 0;
		} else {
			$children = htmlspecialchars($this->input->post('children', true));
		}
//ubah training jadi stand by
		$status = htmlspecialchars($this->input->post('statuss', true));
		if ($status == "Sign Off") {
			$status_mutation = 1;
		}elseif($status == "Stand By"){
			$status_mutation = 2;
		}elseif($probation == "Probation 3 Mount"){
			$status_mutation = 3;
		}else{
			$status_mutation = 0;
		}


		if ($upload_image) {
			$config['allowed_types'] = 'png|jpeg|jpg';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/profile/';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$new_image = $this->upload->data('file_name');
					$data = [
						"seafarer_code" => htmlspecialchars($this->input->post('seafarer_code', true)),
						"gender" => htmlspecialchars($this->input->post('gender', true)),
						"email" => htmlspecialchars($this->input->post('email', true)),
						"crewname" => htmlspecialchars($this->input->post('name', true)),
						"place" => htmlspecialchars($this->input->post('place', true)),
						"date_birth" => strtotime(htmlspecialchars($this->input->post('date_birth', true))),
						"religion" => htmlspecialchars($this->input->post('religion', true)),
						"thr_religion" => htmlspecialchars($this->input->post('thr_religion', true)),
						"marital_status" => $marital_status,
						"children" => $children,
						"address" => htmlspecialchars($this->input->post('address', true)),
						"phone" => htmlspecialchars($this->input->post('phone', true)),
						"rekening" => htmlspecialchars($this->input->post('rekening', true)),
						"rekening_account" => htmlspecialchars($this->input->post('rekening_account', true)),
						"id_rekening" => htmlspecialchars($this->input->post('rekening_name', true)),
						"npwp" => htmlspecialchars($this->input->post('npwp', true)),
						"salary1" => htmlspecialchars($this->input->post('salary1', true)),
						"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
						"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),	
						"contact_urgent" => htmlspecialchars($this->input->post('contact_urgent', true)),
						"id_position" => htmlspecialchars($this->input->post('idposition', true)),
						"date_entry" => $date_entry,
						"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
						"status" => $contract,
						"probation" => $probation,
						"contract_expires" => $contract_expires,
						"contract_expires_7" => $contract_expires_7,
						"contract_expires_30" => $contract_expires_30,
						"date_probation" => $probation_expires,
						"id_cc" => htmlspecialchars($this->input->post('certificates_competency', true)),
						"is_active" => $status_mutation,
						"bpjs_active" => htmlspecialchars($this->input->post('bpjs', true)),
						"bpjs_active2" => htmlspecialchars($this->input->post('bpjs2', true)),
						"date_created" => time(),
						"image" => $new_image	
					];
						$this->db->insert('crew', $data);
						$idcrew = $this->db->insert_id();

					$data2 = [
						"id_crew" => $idcrew,
						"id_position" => htmlspecialchars($this->input->post('idposition', true)),
						"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
						"date_mutation" => $date_entry,
						"probation2" => $probation,
						"explanation" => "New Crew",
						"status_mutation" => $status
					];
						$this->db->insert('mutation', $data2);

		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('crew/addCrew');
			}
		}
		else{	
			$data = [
				"seafarer_code" => htmlspecialchars($this->input->post('seafarer_code', true)),
				"gender" => htmlspecialchars($this->input->post('gender', true)),
				"email" => htmlspecialchars($this->input->post('email', true)),
				"crewname" => htmlspecialchars($this->input->post('name', true)),
				"place" => htmlspecialchars($this->input->post('place', true)),
				"date_birth" => strtotime(htmlspecialchars($this->input->post('date_birth', true))),
				"religion" => htmlspecialchars($this->input->post('religion', true)),
				"thr_religion" => htmlspecialchars($this->input->post('thr_religion', true)),
				"marital_status" => $marital_status,
				"children" => $children,
				"address" => htmlspecialchars($this->input->post('address', true)),
				"phone" => htmlspecialchars($this->input->post('phone', true)),
				"rekening" => htmlspecialchars($this->input->post('rekening', true)),
				"rekening_account" => htmlspecialchars($this->input->post('rekening_account', true)),
				"id_rekening" => htmlspecialchars($this->input->post('rekening_name', true)),
				"npwp" => htmlspecialchars($this->input->post('npwp', true)),
				"salary1" => htmlspecialchars($this->input->post('salary1', true)),
				"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
				"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),	
				"contact_urgent" => htmlspecialchars($this->input->post('contact_urgent', true)),
				"id_position" => htmlspecialchars($this->input->post('idposition', true)),
				"date_entry" => $date_entry,
				"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
				"status" => $contract,
				"probation" => $probation,
				"contract_expires" => $contract_expires,
				"contract_expires_7" => $contract_expires_7,
				"contract_expires_30" => $contract_expires_30,
				"date_probation" => $probation_expires,
				"id_cc" => htmlspecialchars($this->input->post('certificates_competency', true)),
				"is_active" => $status_mutation,
				"bpjs_active" => htmlspecialchars($this->input->post('bpjs', true)),
				"bpjs_active2" => htmlspecialchars($this->input->post('bpjs2', true)),
				"date_created" => time(),
				"image" => "default.jpg"	
			];
				$this->db->insert('crew', $data);
				$idcrew = $this->db->insert_id();

			$data2 = [
				"id_crew" => $idcrew,
				"id_position" => htmlspecialchars($this->input->post('idposition', true)),
				"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
				"date_mutation" => $date_entry,
				"probation2" => $probation,
				"explanation" => "New Crew",
				"status_mutation" => $status
			];
				$this->db->insert('mutation', $data2);

		}
	}

	public function crewEdit()
	{
		
		$idcrew = htmlspecialchars($this->input->post('id', true));
		// pilih status 
		$marital_status = htmlspecialchars($this->input->post('marital_status', true));
		if ($marital_status == "Single") {
			$children = 0;
		} else {
			$children = htmlspecialchars($this->input->post('children', true));
		}

		$loan = htmlspecialchars($this->input->post('loan', true));
		$perloan = htmlspecialchars($this->input->post('perloan', true));

		$m= +ceil($loan/$perloan);
		$date_loan1 = time();
    	$date_loan2 = strtotime($m.'month', $date_loan1); 

		$imagename = htmlspecialchars($this->input->post('imagename', true));
		$upload_image = $_FILES['image']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'png|jpeg|jpg';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/profile/';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$old_image = $imagename;
				if ($old_image != 'default.jpg') {
					unlink(FCPATH . 'assets/img/profile/' . $old_image);
				}
				$new_image = $this->upload->data('file_name');
						$data = [
						"email" => htmlspecialchars($this->input->post('email', true)),
						"crewname" => htmlspecialchars($this->input->post('name', true)),
						"gender" => htmlspecialchars($this->input->post('gender', true)),
						"place" => htmlspecialchars($this->input->post('place', true)),
						"date_birth" => strtotime(htmlspecialchars($this->input->post('date_birth', true))),
						"religion" => htmlspecialchars($this->input->post('religion', true)),
						"thr_religion" => htmlspecialchars($this->input->post('thr_religion', true)),
						"marital_status" => $marital_status,
						"children" => $children,
						"address" => htmlspecialchars($this->input->post('address', true)),
						"phone" => htmlspecialchars($this->input->post('phone', true)),
						"rekening" => htmlspecialchars($this->input->post('rekening', true)),
						"rekening_account" => htmlspecialchars($this->input->post('rekening_account', true)),
						"id_rekening" => htmlspecialchars($this->input->post('rekening_name', true)),
						"npwp" => htmlspecialchars($this->input->post('npwp', true)),
						"contact_urgent" => htmlspecialchars($this->input->post('contact_urgent', true)),
						"id_cc" => htmlspecialchars($this->input->post('certificates_competency', true)),
						"bpjs_active" => htmlspecialchars($this->input->post('bpjs', true)),
						"bpjs_active2" => htmlspecialchars($this->input->post('bpjs2', true)),
						"explanation_loan" => htmlspecialchars($this->input->post('explanation_loan', true)),
						"loan" => $loan,
						"perloan" => $perloan,
						"date_loan1" => $date_loan1,
						"date_loan2" => $date_loan2,
						"date_created" => time(),
					"image" => $new_image
					];
			$this->db->where('idcrew', htmlspecialchars($this->input->post('id', true)));
			$this->db->update('crew', $data);	
			
		}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('crew/crewEdit/'.$idcrew);
		}
			}else{
				$data = [
						"email" => htmlspecialchars($this->input->post('email', true)),
						"crewname" => htmlspecialchars($this->input->post('name', true)),
						"gender" => htmlspecialchars($this->input->post('gender', true)),
						"place" => htmlspecialchars($this->input->post('place', true)),
						"date_birth" => strtotime(htmlspecialchars($this->input->post('date_birth', true))),
						"religion" => htmlspecialchars($this->input->post('religion', true)),
						"thr_religion" => htmlspecialchars($this->input->post('thr_religion', true)),
						"marital_status" => $marital_status,
						"children" => $children,
						"address" => htmlspecialchars($this->input->post('address', true)),
						"phone" => htmlspecialchars($this->input->post('phone', true)),
						"rekening" => htmlspecialchars($this->input->post('rekening', true)),
						"rekening_account" => htmlspecialchars($this->input->post('rekening_account', true)),
						"id_rekening" => htmlspecialchars($this->input->post('rekening_name', true)),
						"npwp" => htmlspecialchars($this->input->post('npwp', true)),
						"contact_urgent" => htmlspecialchars($this->input->post('contact_urgent', true)),
						"id_cc" => htmlspecialchars($this->input->post('certificates_competency', true)),
						"bpjs_active" => htmlspecialchars($this->input->post('bpjs', true)),
						"bpjs_active2" => htmlspecialchars($this->input->post('bpjs2', true)),
						"explanation_loan" => htmlspecialchars($this->input->post('explanation_loan', true)),
						"loan" => $loan,
						"perloan" => $perloan,
						"date_loan1" => $date_loan1,
						"date_loan2" => $date_loan2,
						"date_created" => time()
					];	
		$this->db->where('idcrew', htmlspecialchars($this->input->post('id', true)));
		$this->db->update('crew', $data);			
		}
	}

	public function deleteCrew($id)
	{	
		//buat delete certificates dan mutation by idcrew
		$this->db->delete('crew', ['idcrew' => $id]);
		$this->db->delete('certificates', ['id_crew' => $id]);
		$this->db->delete('mutation', ['id_crew' => $id]);

		
	}

	public function addNewCertificates()
	{
		$idcrew =  htmlspecialchars($this->input->post('idcrew', true));
		$date_expaired = strtotime(htmlspecialchars($this->input->post('date_expaired', true)));

			 $status_cname = htmlspecialchars($this->input->post('status_certificates', true));
			if ($status_cname == 1) {
				$d_exp = 4056940539;
			} else {
				$d_exp = $date_expaired;
			}

            $date_now = time();
            $m = -1;
            $d = -7;
            $date_expaired_30 = strtotime($m.'month', $d_exp); 
            $date_expaired_7 = strtotime($d.'days', $d_exp); 

            if ((($date_now >= $date_expaired_30) AND ($date_now < $d_exp)) AND ($status_certificates == 0)) {
            	$code_status = 2;
            }elseif (($date_now >= $d_exp) AND ($status_cname == 0)){
            	$code_status = 1;
            }elseif(($date_now < $date_expaired_30) AND ($status_cname == 0)){
            	$code_status = 0;
            }elseif ($status_cname == 1) {
            	$code_status = 3;
            }

		$upload_image = $_FILES['image']['name'];
		
		if ($upload_image) {
			$config['allowed_types'] = 'jpeg|jpg|png|pdf';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/certificates/';

			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')) {
				$new_image = $this->upload->data('file_name');

			$data = [
				"id_crew" => $idcrew,
				"id_vessel" => htmlspecialchars($this->input->post('idvessel', true)),
				"certificates" => htmlspecialchars($this->input->post('certificates', true)),
				"no_certificates" => htmlspecialchars($this->input->post('no_certificates', true)),
				"date_issued" => strtotime(htmlspecialchars($this->input->post('date_issued', true))),
				"date_expaired" => $d_exp,
				"date_expaired_7" => $date_expaired_7,
				"date_expaired_30" => $date_expaired_30,
				"status_certificates" => $status_cname,
				"code_status" => $code_status,
				"image_certificates" => $new_image
			];

				$this->db->insert('certificates', $data);
		}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('crew/crewdetail/'.$idcrew);
			}
		}else{
			$data = [
				"id_crew" => $idcrew,
				"id_vessel" => htmlspecialchars($this->input->post('idvessel', true)),
				"certificates" => htmlspecialchars($this->input->post('certificates', true)),
				"no_certificates" => htmlspecialchars($this->input->post('no_certificates', true)),
				"date_issued" => strtotime(htmlspecialchars($this->input->post('date_issued', true))),
				"date_expaired" => $d_exp,
				"date_expaired_7" => $date_expaired_7,
				"date_expaired_30" => $date_expaired_30,
				"status_certificates" => $status_cname,
				"code_status" => $code_status,
				"image_certificates" => "default.png"
			];

		$this->db->insert('certificates', $data);
		}			
	}

	public function editCertificates()
	{
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));

		$date_expaired = strtotime(htmlspecialchars($this->input->post('date_expaired', true)));

		$status_cname = htmlspecialchars($this->input->post('status_certificates', true));
			if ($status_cname == 1) {
				$d_exp = 4056940539;
			} else {
				$d_exp = $date_expaired;
			} 

            $date_now = time();
            $m = -1;
            $d = -7;
            $date_expaired_30 = strtotime($m.'month', $d_exp); 
            $date_expaired_7 = strtotime($d.'days', $d_exp);

            if ((($date_now >= $date_expaired_30) AND ($date_now < $d_exp)) AND ($status_certificates == 0)) {
            	$code_status = 2;
            }elseif (($date_now >= $d_exp) AND ($status_cname == 0)){
            	$code_status = 1;
            }elseif(($date_now < $date_expaired_30) AND ($status_cname == 0)){
            	$code_status = 0;
            }elseif ($status_cname == 1) {
            	$code_status = 3;
            }

		$imagename = htmlspecialchars($this->input->post('imagename', true));
		$upload_image = $_FILES['image']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'jpeg|jpg|png|pdf';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/img/certificates/';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$old_image = $imagename;
				if ($old_image != 'default.png') {
					unlink(FCPATH . 'assets/img/certificates/' . $old_image);
				}
				$new_image = $this->upload->data('file_name');
				$data = [
					"id_crew" => $idcrew,
					"certificates" => htmlspecialchars($this->input->post('certificates', true)),
					"no_certificates" => htmlspecialchars($this->input->post('no_certificates', true)),
					"date_issued" => strtotime(htmlspecialchars($this->input->post('date_issued', true))),
					"date_expaired" => $d_exp,
					"date_expaired_7" => $date_expaired_7,
					"date_expaired_30" => $date_expaired_30,
					"status_certificates" => $status_cname,
					"code_status" => $code_status,
					"image_certificates" => $new_image
				];
				$this->db->where('idcertificates', htmlspecialchars($this->input->post('id', true)));
				$this->db->update('certificates', $data);
				}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('crew/crewdetail/'.$idcrew);
			}
		}else{
			$data = [
					"id_crew" => $idcrew,
					"certificates" => htmlspecialchars($this->input->post('certificates', true)),
					"no_certificates" => htmlspecialchars($this->input->post('no_certificates', true)),
					"date_issued" => strtotime(htmlspecialchars($this->input->post('date_issued', true))),
					"date_expaired" => $d_exp,
					"date_expaired_7" => $date_expaired_7,
					"date_expaired_30" => $date_expaired_30,
					"code_status" => $code_status,
					"status_certificates" => $status_cname
				];
				$this->db->where('idcertificates', htmlspecialchars($this->input->post('id', true)));
				$this->db->update('certificates', $data);
		}
	}

		public function deleteCertificates($id)
	{	

		$row  = $this->db->query("SELECT * FROM `certificates` WHERE `certificates`.`idcertificates` = $id ORDER BY `idcertificates` DESC limit 1")->row();
		$image_certificates = $row->image_certificates;
		$old_image_certificates = $image_certificates;
				if ($old_image_certificates != 'default.png') {
					unlink(FCPATH . 'assets/img/certificates/' . $old_image_certificates);
				}
		$this->db->delete('certificates', ['idcertificates' => $id]);
	}

	

	public function addMutation()
	{
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));
		$date_entry = strtotime(htmlspecialchars($this->input->post('date_entry', true)));
		//pilih masa probation
		$probation = htmlspecialchars($this->input->post('probation', true));
		if ($probation == "Probation 3 Mount") {
			$pmonth = 3;
		} else {
			$pmonth = 0;
		}

		$probation_expires = strtotime('+'.$pmonth.'month', $date_entry);
		
		// pilih contract menentuakn expaired contract
		$contract = htmlspecialchars($this->input->post('contract', true));
		if ($contract == "Contract Employees 6 Mount") {
			$contract_name = $contract;
			$month = 6;
		} elseif($contract == "Contract Employees 9 Mount") {
			$contract_name = $contract;
			$month = 9;
		} elseif($contract == "Contract Employees 12 Mount") {
			$contract_name = $contract;
			$month = 12;
		} else{
			$contract_name = $contract;
			$month = 0;
		}

		$contract_expires = strtotime('+'.$month.'month', $date_entry);

            $date_now = time();
            $m = -1;
            $d = -7;
            $contract_expires_30 = strtotime($m.'month', $contract_expires); 
            $contract_expires_7 = strtotime($d.'days', $contract_expires);
		// status_mutation = 3 on, status_mutation = 2 stand by, status_mutation = 1 off, status_mutation = 4 Jump Ship, status_mutation = 0 on
		$status = htmlspecialchars($this->input->post('status', true));
		if ($status == "Sign Off") {
			$status_mutation = 1;
		}elseif($status == "Stand By"){
			$status_mutation = 2;
		}elseif($status == "Jump Ship"){
			$status_mutation = 4;
		}elseif(($status != "Sign Off") AND ($probation == "Probation 3 Mount") OR ($status != "Stand By") AND ($probation == "Probation 3 Mount")){
			$status_mutation = 3;
		}elseif(($status != "Sign Off") AND ($probation == "No Probation") OR ($status != "Stand By") AND ($probation == "No Probation")){
			$status_mutation = 0;
		}

		$position = htmlspecialchars($this->input->post('idposition', true));
		if ($position == 0) {
			$idposition = htmlspecialchars($this->input->post('idposition2', true));
			}else{
			$idposition = htmlspecialchars($this->input->post('idposition', true));
			}

		$data1 = [
				"id_crew" => htmlspecialchars($this->input->post('idcrew', true)),
				"id_position" => $idposition,
				"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
				"date_mutation" => $date_entry,
				"status_mutation" => $status,
				"probation2" => $probation,
				"explanation" => htmlspecialchars($this->input->post('explanation', true))
			];
		$this->db->insert('mutation', $data1);

		$row  = $this->db->query("SELECT * FROM `crew` WHERE `crew`.`idcrew` = '$idcrew' ORDER BY `idcrew` DESC limit 1")->row();
		$getsalary1 = $row->salary1;
		$getjob_allowance1 = $row->job_allowance1;
		$getcertificate_allowance1 = $row->certificates_allowance1;

		$salary1 = htmlspecialchars($this->input->post('salary1', true));
		$job_allowance1 = htmlspecialchars($this->input->post('job_allowance1', true));
		$certificates_allowance1 = htmlspecialchars($this->input->post('certificates_allowance1', true));

		if (($salary1 == 0) AND ($job_allowance1 == 0) AND ($certificates_allowance1 == 0)) {
			$newsalary1 = $getsalary1;
			$newjob_allowance1 = $getjob_allowance1;
			$newcertificates_allowance1 = $getcertificates_allowance1;
		} else {
			$newsalary1 = $salary1;
			$newjob_allowance1 = $job_allowance1;
			$newcertificates_allowance1 = $certificates_allowance1;
		}

		//pilih change hire date atau ngga klo pilih hire date = date mutation
		if ($change_hd == 1) {
			$data2 = [
			"id_position" => htmlspecialchars($this->input->post('idposition', true)),
			"salary1" => htmlspecialchars($this->input->post('salary1', true)),
			"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
			"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),
			"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),	
			"date_mutation2" => $date_entry,
			"status" => $contract_name,
			"probation" => $probation,
			"date_probation" => $probation_expires,
			"contract_expires" => $contract_expires,
			"contract_expires_7" => $contract_expires_7,
			"contract_expires_30" => $contract_expires_30,
			"is_active" => $status_mutation,
			"date_created" => time()
					];
		} else {
			$data2 = [
			"id_position" => htmlspecialchars($this->input->post('idposition', true)),
			"salary1" => htmlspecialchars($this->input->post('salary1', true)),
			"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
			"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),
			"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),	
			"date_mutation2" => $date_entry,
			"date_entry" => $date_entry,
			"status" => $contract_name,
			"probation" => $probation,
			"date_probation" => $probation_expires,
			"contract_expires" => $contract_expires,
			"contract_expires_7" => $contract_expires_7,
			"contract_expires_30" => $contract_expires_30,
			"is_active" => $status_mutation,
			"date_created" => time()
			];
		}	
		$this->db->where('idcrew', $idcrew);
		$this->db->update('crew', $data2);					
					
	}
		//lagi disini perbaiki status contractnya
		public function editMutation()
	{
		$idcrew = htmlspecialchars($this->input->post('idcrew', true));
		$date_entry = strtotime(htmlspecialchars($this->input->post('date_entry', true)));

		//pilih masa probation
		$probation = htmlspecialchars($this->input->post('probation', true));
		if ($probation == "Probation 3 Mount") {
			$pmonth = 3;
		} else {
			$pmonth = 0;
		}

		$probation_expires = strtotime('+'.$pmonth.'month', $date_entry);

		// pilih contract menentuakn expaired contract
		$contract = htmlspecialchars($this->input->post('contract', true));
		if ($contract == "Contract Employees 6 Mount") {
			$contract_name = $contract;
			$month = 6;
		} elseif($contract == "Contract Employees 9 Mount") {
			$contract_name = $contract;
			$month = 9;
		} elseif($contract == "Contract Employees 12 Mount") {
			$contract_name = $contract;
			$month = 12;
		}  else{
			$contract_name = $contract;
			$month = 0;
		} 

		$contract_expires = strtotime('+'.$month.'month', $date_entry);

            $date_now = time();
            $m = -1;
            $d = -7;
            $contract_expires_30 = strtotime($m.'month', $contract_expires); 
            $contract_expires_7 = strtotime($d.'days', $contract_expires);

		$status = htmlspecialchars($this->input->post('status', true));
		// status_mutation = 3 on, status_mutation = 2 stand by, status_mutation = 1 off, status_mutation = 4 Jump Ship, status_mutation = 0 on
		if ($status == "Sign Off") {
			$status_mutation = 1;
		}elseif($status == "Stand By"){
			$status_mutation = 2;
		}elseif($status == "Jump Ship"){
			$status_mutation = 4;
		}elseif(($status != "Sign Off") AND ($probation == "Probation 3 Mount") OR ($status != "Stand By") AND ($probation == "Probation 3 Mount")){
			$status_mutation = 3;
		}elseif(($status != "Sign Off") AND ($probation == "No Probation") OR ($status != "Stand By") AND ($probation == "Probation 3 Mount")){
			$status_mutation = 0;
		}

		$position = htmlspecialchars($this->input->post('idposition', true));
		if ($position == 0) {
			$idposition = htmlspecialchars($this->input->post('idposition2', true));
			}else{
			$idposition = htmlspecialchars($this->input->post('idposition', true));
			}

		$result = $this->db->get_where('mutation', ['id_crew' => $idcrew]);

		if ($result->num_rows() > 1){
			$data1 = [
				"id_position" => $idposition,
				"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
				"date_mutation" => strtotime(htmlspecialchars($this->input->post('date_entry', true))),
				"status_mutation" => $status,
				"probation2" => $probation,
				"explanation" => htmlspecialchars($this->input->post('explanation', true))
			];
			$this->db->where('idmutation', htmlspecialchars($this->input->post('idmutation', true)));
		$this->db->update('mutation', $data1);

		$change_hd = htmlspecialchars($this->input->post('change_hd', true));

		
		//pilih change hire date atau ngga klo pilih hire date = date mutation
		if ($change_hd == 1) {
			$data2 = [
			"id_position" => htmlspecialchars($this->input->post('idposition', true)),
			"salary1" => htmlspecialchars($this->input->post('salary1', true)),
			"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
			"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),
			"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),	
			"date_mutation2" => $date_entry,
			"status" => $contract_name,
			"probation" => $probation,
			"date_probation" => $probation_expires,
			"contract_expires" => $contract_expires,
			"contract_expires_7" => $contract_expires_7,
			"contract_expires_30" => $contract_expires_30,
			"is_active" => $status_mutation,
			"date_created" => time()
					];
		} else {
			$data2 = [
			"id_position" => htmlspecialchars($this->input->post('idposition', true)),
			"salary1" => htmlspecialchars($this->input->post('salary1', true)),
			"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
			"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),
			"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),	
			"date_mutation2" => $date_entry,
			"date_entry" => $date_entry,
			"status" => $contract_name,
			"probation" => $probation,
			"date_probation" => $probation_expires,
			"contract_expires" => $contract_expires,
			"contract_expires_7" => $contract_expires_7,
			"contract_expires_30" => $contract_expires_30,
			"is_active" => $status_mutation,
			"date_created" => time()
			];
		}	
		$this->db->where('idcrew', $idcrew);
		$this->db->update('crew', $data2);	
		

		
		} else{
			$data1 = [
				"id_position" => htmlspecialchars($this->input->post('idposition', true)),
				"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),
				"date_mutation" => $date_entry,
				"status_mutation" => $status,
				"probation2" => $probation,
				"explanation" => htmlspecialchars($this->input->post('explanation', true))
			];
			$this->db->where('idmutation', htmlspecialchars($this->input->post('idmutation', true)));
		$this->db->update('mutation', $data1);

			
		$data2 = [
			"id_position" => htmlspecialchars($this->input->post('idposition', true)),
			"salary1" => htmlspecialchars($this->input->post('salary1', true)),
			"job_allowance1" => htmlspecialchars($this->input->post('job_allowance1', true)),
			"certificates_allowance1" => htmlspecialchars($this->input->post('certificates_allowance1', true)),
			"id_vessel" => htmlspecialchars($this->input->post('vessel', true)),	
			"date_mutation2" => strtotime(htmlspecialchars($this->input->post('date_entry', true))),
			"date_entry" => $date_entry,
			"status" => $contract_name,
			"probation" => $probation,
			"date_probation" => $probation_expires,
			"contract_expires" => $contract_expires,
			"contract_expires_7" => $contract_expires_7,
			"contract_expires_30" => $contract_expires_30,
			"is_active" => $status_mutation,
			"date_created" => time()
					];	
			
		$this->db->where('idcrew', $idcrew);
		$this->db->update('crew', $data2);
		}
					
	}


	  function coba($title){
        $this->db->like('position', $title , 'both');
        $this->db->order_by('position', 'ASC');
        $this->db->limit(10);
        return $this->db->get('position')->result();
    }

}