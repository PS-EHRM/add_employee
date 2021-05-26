<?php
class Excel_import_model extends CI_Model {
    
    public function getWorksetation($data = [])
    {
        $query = $this->db->select('*')
            ->where($data)
            ->from('hs_hr_service')
            ->get();
        return $query->result();
    }

    public function getWorkCompstructtree($data = [])
    {
        $query = $this->db->select('*')
            ->where($data)
            ->from('hs_hr_compstructtree')
            ->get();
        return $query->result();
    }
    

    public function insertWorksetation($data)
    {
        $this->db->insert('hs_hr_service', $data);
        $insert_id = $this->db->insert_id();
    }
    public function insertWorkPositionsetation($data)
    {
        $this->db->insert('hs_hr_compstructtree', $data);
        $insert_id = $this->db->insert_id();
    }

    

    

    public function insertData($data)
    {
        $num_row = 0;
        $is_added = false;
        if (!empty($data['emp_number'])){
            $query = $this->db->select('employee_id')
                        ->where('emp_number', $data['emp_number'])
                        ->from('hs_hr_employee')
                        ->get();
            $num_row = $query->num_rows();
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('emp_number', $data['emp_number']);
                $restule = $this->db->update('hs_hr_employee');
                $is_added = true;
            }

        } else if(!empty($data['employee_id'])){
            $query = $this->db->select('employee_id')
                        ->where('employee_id', $data['employee_id'])
                        ->from('hs_hr_employee')
                        ->get();
            $num_row = $query->num_rows();
            
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('employee_id', $data['employee_id']);
                $restule = $this->db->update('hs_hr_employee');
                $is_added = true;
            }
        }else if (!empty($data['emp_salary_no'])){
            $query = $this->db->select('employee_id')
                        ->where('emp_salary_no', $data['emp_salary_no'])
                        ->from('hs_hr_employee')
                        ->get();
            $num_row = $query->num_rows();
            
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('emp_salary_no', $data['emp_salary_no']);
                $restule = $this->db->update('hs_hr_employee');
                $is_added = true;
            }
        }  

        
                  
        if(!$is_added){            
            $this->db->insert('hs_hr_employee', $data);
        }

        echo "find rown".$num_row."\n";
        echo "-------------------------------\n\n\n";
    }

}