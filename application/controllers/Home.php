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
		$service = [];
		$service_id = 0;
		$wkservice_id = 0;
		$work_station = $this->excel_import_model->getWorksetation();
		foreach($work_station as $row_wk){
			if(!empty($row_wk->service_name_si)){
				$service[$row_wk->service_name_si] = $row_wk->service_code;
				$service_id = $service_id < $row_wk->service_code ? $row_wk->service_code : $service_id;
			}			
		}

		$workposition = [];
		$work_station = $this->excel_import_model->getWorkCompstructtree();
		foreach($work_station as $row_wk){
			if(!empty($row_wk->title_si)){
				$workposition[$row_wk->title_si] = $row_wk->id;
				$wkservice_id = $wkservice_id < $row_wk->id ? $row_wk->id : $wkservice_id;
			}			
		}


		//print_r($service);
		//die();


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
				//$data['job_title_code'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); //code to convert
				$data['work_station'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();  //code to convert
				$data['emp_app_date'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$data['emp_nic_no'] = strtoupper($worksheet->getCellByColumnAndRow(11, $row)->getValue());
				$data['employee_id'] = strtoupper($worksheet->getCellByColumnAndRow(11, $row)->getValue());

				$data['employee_id'] = !empty($data['employee_id']) ? $data['employee_id'] : null;

				$service_temp = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
				$service_temp = str_replace("(","-",$service_temp);
				$service_temp = str_replace(")","",$service_temp);

				$service_pos_temp = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
				$data['service_code'] = NULL;
				$data['work_station'] = NULL;
				if(!empty($service_temp)){
					if(!empty($service[$service_temp])){
						$data['service_code'] = $service[$service_temp];
					}else{
						$work_station_id = ++$service_id;
						$this->excel_import_model->insertWorksetation(['service_code'=>$work_station_id,'service_name'=>$service_temp, 'service_name_si'=>$service_temp]);
						
						$data['service_code'] = $work_station_id;
						$service[$service_temp] = $work_station_id;
					}
				}

				$service_pos_temp = str_replace("(","-",$service_pos_temp);
				$service_pos_temp = str_replace(")","",$service_pos_temp);
				if(!empty($service_pos_temp)){
					if(!empty($workposition[$service_pos_temp])){
						$data['work_station'] = $workposition[$service_pos_temp];
					}else{
						++$wkservice_id;
						$work_station_id = $wkservice_id;
						$this->excel_import_model->insertWorkPositionsetation(['id'=>$work_station_id,'comp_code'=>$work_station_id,'title_si'=>$service_pos_temp, 'title'=>$service_pos_temp]);
						
						$data['work_station'] = $work_station_id;
						$workposition[$service_pos_temp] = $work_station_id;
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
					//print_r($service);
					print_r($data);
					$this->excel_import_model->insertData($data);
				}

				
			}
		}
		echo 'Data Imported successfully';
	}
}