<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();		
		$this->load->library('Excel');
		$this->load->model('excel_import_model');
	} 

	public function index()
	{
		//ini_set('memory_limit', '-1');
		print_r("Uploading start ");

		for($x = 11; $x <=11; $x++){
			$path = FCPATH."upload/".$x.".xlsx";
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $key => $worksheet)
			{
				echo "<pre>";
					print_r("excel ".$x." sheet ".$key);
				echo "</pre>";
				if(false && $key==0){
					//$this->add_sheet_1($worksheet);
				}else if($key==1){
					$this->add_address_sheet($worksheet);
				}else if(false && $key==2){
					//$this->add_dependent_sheet($worksheet);
				}else if(false && $key==3){
					//$this->add_emergency_sheet($worksheet);
				}else if(false && $key==4){
					//$this->add_job_sheet($worksheet);
				}else if(false && $key==5){
					//$this->add_service_sheet($worksheet);
				}else if(false && $key==6){
					//$this->add_education_sheet($worksheet);
				}else if(false && $key==7){
					//$this->add_job_sheet($worksheet);
				}else if(false && $key==8){
					//$this->add_job_sheet($worksheet);
				}else if(false && $key==9){
					//$this->add_job_sheet($worksheet);
				}else if(false && $key==10){
					//$this->add_job_sheet($worksheet);
				}else if(false && $key==11){
					//$this->add_job_sheet($worksheet);
				}else if(false && $key==12){
					//$this->add_job_sheet($worksheet);
				}
			}
		}
		


		
		echo 'Data Imported successfully';
	}

	public function add_sheet_1($worksheet){
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();
		for($row=4; $row<=$highestRow; $row++)
		{

			$data['emp_app_letter_no'] = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
			//$data['emp_number'] = $this->empid;//$worksheet->getCellByColumnAndRow(1, $row)->getValue();
			$data['employee_id'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
			
			$data['emp_birthday'] = strtoupper($worksheet->getCellByColumnAndRow(10, $row)->getValue());
			$data['gender_code'] = strtoupper($worksheet->getCellByColumnAndRow(5, $row)->getValue());
			
			$data['emp_nic_no'] = strtoupper($worksheet->getCellByColumnAndRow(1, $row)->getValue());
			$data['title_code'] = strtoupper($worksheet->getCellByColumnAndRow(4, $row)->getValue());
			
			
			
			$data['emp_display_name'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$data['emp_display_name_ta'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$data['emp_display_name_si'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			
			$data['emp_names_of_initials'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$data['emp_names_of_initials_si'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$data['emp_names_of_initials_ta'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			
			$data['emp_firstname'] = strtoupper($worksheet->getCellByColumnAndRow(8, $row)->getValue());
			$data['emp_firstname_si'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			$data['emp_firstname_ta'] = strtoupper($worksheet->getCellByColumnAndRow(6, $row)->getValue());
			
			$data['emp_lastname'] = strtoupper($worksheet->getCellByColumnAndRow(9, $row)->getValue());
			$data['emp_lastname_si'] = strtoupper($worksheet->getCellByColumnAndRow(9, $row)->getValue());
			$data['emp_lastname_ta'] = strtoupper($worksheet->getCellByColumnAndRow(9, $row)->getValue());
			
			$data['marst_code'] = strtoupper($worksheet->getCellByColumnAndRow(11	, $row)->getValue());
			$data['emp_married_date'] = strtoupper($worksheet->getCellByColumnAndRow(12, $row)->getValue());
			$data['rlg_code'] = strtoupper($worksheet->getCellByColumnAndRow(14, $row)->getValue());
			$data['ethnic_race_code'] = strtoupper($worksheet->getCellByColumnAndRow(13, $row)->getValue());
			
					


			if(empty($data['employee_id'])){
				break;
			}
			//$data['employee_id'] = strtoupper($worksheet->getCellByColumnAndRow(11, $row)->getValue());

			//$data['employee_id'] = !empty($data['employee_id']) ? $data['employee_id'] : null;

			//$service_temp = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
			//$service_temp = str_replace("(","-",$service_temp);
			//$service_temp = str_replace(")","",$service_temp);

			//$service_pos_temp = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

			
			//print_r($data);
			//die();

			
			
			if(!empty($data['employee_id'])){
				echo "<pre>";
				print_r($row." ".$data['employee_id']. " creating");
				print_r($data);
				echo "</pre>";
				//print_r($data);
				$this->excel_import_model->insertData($data);
			}
			
		}
	}

	
	public function add_address_sheet($worksheet){
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();
		for($row=4; $row<=$highestRow; $row++)
		{
			$employee_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
			$data['emp_number'] = $this->excel_import_model->getemp_number($employee_id);
			$data['con_per_addLine1'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
			$data['con_res_addLine1'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
			$data['con_per_del_postoffice'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
			$data['con_per_postal_code'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
			$data['con_per_district'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
			$data['con_per_div_sectretariat'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
			$data['con_per_policesation'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
			$data['con_per_phone'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
			$data['con_per_mobile'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
			$data['con_per_fax'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
			$data['con_per_email'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();


			if(empty($data['emp_number'])){
				break;
			}

			
			
			if(!empty($data['emp_number'])){
				echo "<pre>";
				print_r($row." ".$data['emp_number']. " address creating");
				print_r($data);
				echo "</pre>";
				$this->excel_import_model->insertAddressData($data);
			}
			
		}
	}

	public function add_dependent_sheet($worksheet){
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();
		for($row=5; $row<=$highestRow; $row++)
		{
			$employee_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
			$data['emp_number'] = $this->excel_import_model->getemp_number($employee_id);
			$data['ed_name'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
			$data['ed_nic'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
			$data['rel_code'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
			$data['ed_birthday'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
			$data['ed_workplace'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
			$data['ed_address'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
			//$data['ed_comments'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

			if(empty($data['ed_nic'])){
				continue;
			}

			if(empty($data['emp_number'])){
				break;
			}

			
			
			if(!empty($data['emp_number'])){
				echo "<pre>";
				print_r($row." ".$data['emp_number']. " address creating");
				print_r($data);
				echo "</pre>";
				$this->excel_import_model->insertDependentData($data);
			}
			
		}
	}

	public function add_emergency_sheet($worksheet){
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();
		for($row=5; $row<=$highestRow; $row++)
		{
			$employee_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
			$data['emp_number'] = $this->excel_import_model->getemp_number($employee_id);
			//$data['eec_seqno'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
			$data['eec_name'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
			$data['eec_relationship'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
			$data['eec_address'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
			$data['eec_home_no'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
			$data['eec_office_no'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
			$data['eec_mobile_no'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

			if(empty($employee_id)){
				break;
			}
			if(empty($data['emp_number'])){
				continue;
			}

			
			
			if(!empty($data['emp_number'])){
				echo "<pre>";
				print_r($row." ".$data['emp_number']. " address creating ".$employee_id);
				print_r($data);
				echo "</pre>";
				$this->excel_import_model->insertEmergencyData($data);
			}
			
		}
	}

	public function add_job_sheet($worksheet){
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();

		$job_title = $this->excel_import_model->getjob_title();
		$job_title_id = 0;
		foreach($job_title as $row_wk){
			if(!empty($row_wk->jobtit_name)){
				$job_titles[$row_wk->jobtit_name] = $row_wk->jobtit_code;
				$job_title_id = $job_title_id < intval(str_replace("JOB","",$row_wk->jobtit_code)) ? intval(str_replace("JOB","",$row_wk->jobtit_code)) : $job_title_id;
			}			
		}


		for($row=5; $row<=$highestRow; $row++)
		{
			$employee_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
			$data['emp_number'] = $this->excel_import_model->getemp_number($employee_id);
			$job = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

			if(!empty($job) && $job != NULL){					
				if(!empty($job_titles[$job])){
					$data['job_title_code'] = $job_titles[$job];
				}else{
					$job_title_id = ++$job_title_id;
					$this->excel_import_model->insertJobTitle(['jobtit_code'=>"JOB".$job_title_id, 'jobtit_name'=>$job,'jobtit_name_si'=>$job, 'jobtit_name_ta'=>$job]);
					
					$data['job_title_code'] = "JOB".$job_title_id;
					$job_titles[$job] = "JOB".$job_title_id;
				}
			}else{
				$data['job_title_code'] = "";
			}
			
			$data['emp_app_date'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
			$data['emp_com_date'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
			$data['emp_basic_salary'] = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
			$data['emp_salary_inc_date'] = $worksheet->getCellByColumnAndRow(19, $row)->getValue();

			if(empty($employee_id)){
				break;
			}
			if(empty($data['emp_number'])){
				continue;
			}

			
			
			if(!empty($data['emp_number'])){
				echo "<pre>";
				print_r($row." ".$data['emp_number']. " address creating ".$employee_id);
				print_r($data);
				echo "</pre>";
				$this->excel_import_model->insertData($data);
			}
			
		}
	}

	public function add_education_sheet($worksheet){
		$highestRow = $worksheet->getHighestRow();
		$highestColumn = $worksheet->getHighestColumn();

		$job_title = $this->excel_import_model->getjob_title();
		$job_title_id = 0;
		foreach($job_title as $row_wk){
			if(!empty($row_wk->jobtit_name)){
				$job_titles[$row_wk->jobtit_name] = $row_wk->jobtit_code;
				$job_title_id = $job_title_id < intval(str_replace("JOB","",$row_wk->jobtit_code)) ? intval(str_replace("JOB","",$row_wk->jobtit_code)) : $job_title_id;
			}			
		}


		for($row=5; $row<=$highestRow; $row++)
		{
			$employee_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
			$data['emp_number'] = $this->excel_import_model->getemp_number($employee_id);			
			$data['edu_type_id'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
			$data['grd_year'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

			if(empty($employee_id)){
				break;
			}
			if(empty($data['emp_number'])){
				continue;
			}

			
			
			if(!empty($data['emp_number'])){
				echo "<pre>";
				print_r($row." ".$data['emp_number']. " address creating ".$employee_id);
				print_r($data);
				echo "</pre>";
				$this->excel_import_model->insertEducationData($data);
			}
			
		}
	}

	
}