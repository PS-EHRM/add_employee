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
		$designation = []; //hs_hr_job_title - 3
		$job_titles = []; //4 hs_hr_compstructtree


		$work_station_id = 0;
		$designation_id = 0;

		$work_station = $this->excel_import_model->getWorkStation();
		foreach($work_station as $row_wk){
			if(!empty($row_wk->jobtit_name_si)){
				$job_titles[$row_wk->jobtit_name_si] = $row_wk->jobtit_code;
				$work_station_id = $work_station_id < intval(str_replace("JOB","",$row_wk->jobtit_code)) ? intval(str_replace("JOB","",$row_wk->jobtit_code)) : $work_station_id;
			}			
		}

		$designation_table = $this->excel_import_model->getDesignation();
		foreach($designation_table as $row_wk){
			if(!empty($row_wk->title_si)){
				$designation[$row_wk->title_si] = $row_wk->id;
				$designation_id = $designation_id < $row_wk->id ? $row_wk->id : $designation_id;
			}			
		}
		

		

		


		$path = FCPATH."upload/data.xlsx";
		$object = PHPExcel_IOFactory::load($path);
		foreach($object->getWorksheetIterator() as $worksheet)
		{
			
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
			for($row=2; $row<=$highestRow; $row++)
			{

				$data['emp_number'] = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$data['emp_salary_no'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$data['emp_lastname_si'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				//$job_title_code = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); //code to convert
				//$hs_hr_compstructtree = $worksheet->getCellByColumnAndRow(4, $row)->getValue();  //code to convert
				$data['emp_app_date'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				$data['emp_nic_no'] = strtoupper($worksheet->getCellByColumnAndRow(11, $row)->getValue());
				$data['employee_id'] = strtoupper($worksheet->getCellByColumnAndRow(11, $row)->getValue());

				$data['employee_id'] = !empty($data['employee_id']) ? $data['employee_id'] : null;

				$service_temp = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
				$service_temp = str_replace("(","-",$service_temp);
				$service_temp = str_replace(")","",$service_temp);

				$service_pos_temp = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

				
				$data['job_title_code'] = NULL;
				$data['work_station'] = NULL;
				if(!empty($service_temp)){
					if(!empty($job_titles[$service_temp])){
						$data['job_title_code'] = $job_titles[$service_temp];
					}else{
						$work_station_id = ++$work_station_id;
						$this->excel_import_model->insertJobTitle(['jobtit_code'=>"JOB".$work_station_id, 'jobtit_name'=>$service_temp,'jobtit_name_si'=>$service_temp, 'jobtit_name_ta'=>$service_temp]);
						
						$data['job_title_code'] = "JOB".$work_station_id;
						$job_titles[$service_temp] = "JOB".$work_station_id;
					}
				}

				$service_pos_temp = str_replace("(","-",$service_pos_temp);
				$service_pos_temp = str_replace(")","",$service_pos_temp);
				if(!empty($service_pos_temp)){
					if(!empty($designation[$service_pos_temp])){
						$data['work_station'] = $designation[$service_pos_temp];
					}else{
						++$designation_id;
						$this->excel_import_model->insertWorkStation(['id'=>$designation_id,'comp_code'=>$designation_id,'title_si'=>$service_pos_temp, 'title'=>$service_pos_temp]);
						
						$data['work_station'] = $designation_id;
						$designation[$service_pos_temp] = $designation_id;
					}
				}

				$data['emp_display_name'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				
				if($data['employee_id']=="ගුවන් හමුදාව"){
					$data['employee_id'] = NULL;
					$data['emp_nic_no'] = NULL;
				}
				if($data['employee_id']=="යුධ හමුදා"){
					$data['employee_id'] = NULL;
					$data['emp_nic_no'] = NULL;
				}
				if($data['employee_id']=="නාවික හමුදාව"){
					$data['employee_id'] = NULL;
					$data['emp_nic_no'] = NULL;
				}
				
				if(!empty($data['emp_number'])){
					echo "<pre>";
					print_r($service_pos_temp);
					print_r($data);
					$this->excel_import_model->insertData($data);
				}
				
			}
		}
		echo 'Data Imported successfully';
	}
}