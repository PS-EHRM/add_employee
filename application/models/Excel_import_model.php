<?php
class Excel_import_model extends CI_Model {
    
    public function getjob_title($data = [])
    {
        $query = $this->db->select('*')
            ->where($data)
            ->from('hs_hr_job_title')
            ->get();
        return $query->result();
    }

    public function getDesignation($data = [])
    {
        $query = $this->db->select('*')
            ->where($data)
            ->from('hs_hr_compstructtree')
            ->get();
        return $query->result();
    }

    
    public function insertWorkStation($data)
    {
        $this->db->insert('hs_hr_compstructtree', $data);
        $insert_id = $this->db->insert_id();
    }

    public function insertJobTitle($data)
    {
        $this->db->insert('hs_hr_job_title', $data);
        $insert_id = $this->db->insert_id();
    }

    public function getemp_number($employee_id)
    {
        $query = $this->db->select('emp_number')
                        ->where('employee_id', $employee_id)
                        ->from('hs_hr_employee')
                        ->get()->result_array();
        return !empty($query[0]['emp_number']) ? $query[0]['emp_number'] : 0;
    }
    

    

    public function insertData($data)
    {
        $num_row = 0;
        $is_added = false;
        if (!empty($data['employee_id'])){
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

        }
        if(!$is_added){ 
            if (!empty($data['emp_number'])){
                $query = $this->db->select('emp_number')
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

            }
        }

        
                  
        if(!$is_added){          
            $this->db->insert('hs_hr_employee', $data);

              
            $insert_id = $this->db->insert_id();
            $data1['emp_number'] = $insert_id;
            $this->db->set($data1);
            $this->db->where('employee_id', $data['employee_id']);
            $restule = $this->db->update('hs_hr_employee');
            $is_added = true;
        }

        echo "find rown".$num_row."\n";
        echo "-------------------------------\n\n\n";
    }


    

    public function insertAddressData($data)
    {
        $num_row = 0;
        $is_added = false;
        if (!empty($data['emp_number'])){
            $query = $this->db->select('emp_number')
                        ->where('emp_number', $data['emp_number'])
                        ->from('hs_hr_emp_contact')
                        ->get();
            $num_row = $query->num_rows();
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('emp_number', $data['emp_number']);
                $restule = $this->db->update('hs_hr_emp_contact');
                $is_added = true;
            }

        }

        
                  
        if(!$is_added){          
            $this->db->insert('hs_hr_emp_contact', $data);
            $is_added = true;
        }

        echo "find rown".$num_row."\n";
        echo "-------------------------------\n\n\n";
    }
    public function insertDependentData($data)
    {
        $num_row = 0;
        $is_added = false;
        if (!empty($data['emp_number'])){
            $query = $this->db->select('emp_number')
                        ->where('emp_number', $data['emp_number'])
                        ->from('hs_hr_emp_dependents')
                        ->get();
            $num_row = $query->num_rows();
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('emp_number', $data['emp_number']);
                $restule = $this->db->update('hs_hr_emp_dependents');
                $is_added = true;
            }

        }

        
                  
        if(!$is_added){          
            $this->db->insert('hs_hr_emp_dependents', $data);
            $is_added = true;
        }

        echo "find rown".$num_row."\n";
        echo "-------------------------------\n\n\n";
    }
    
    public function insertEmergencyData($data)
    {
        $num_row = 0;
        $is_added = false;
        if (!empty($data['emp_number'])){
            $query = $this->db->select('emp_number')
                        ->where('emp_number', $data['emp_number'])
                        ->from('hs_hr_emp_emergency_contacts')
                        ->get();
            $num_row = $query->num_rows();
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('emp_number', $data['emp_number']);
                $restule = $this->db->update('hs_hr_emp_emergency_contacts');
                $is_added = true;
            }

        }

        
                  
        if(!$is_added){          
            $this->db->insert('hs_hr_emp_emergency_contacts', $data);
            $is_added = true;
        }

        echo "find rown".$num_row."\n";
        echo "-------------------------------\n\n\n";
    }


    public function insertEducationData($data)
    {
        $num_row = 0;
        $is_added = false;
        if (!empty($data['emp_number'])){
            $query = $this->db->select('emp_number')
                        ->where('emp_number', $data['emp_number'])
                        ->from('hs_hr_edu_emp_head')
                        ->get();
            $num_row = $query->num_rows();
            if($num_row > 0){
                $this->db->set($data);
                $this->db->where('emp_number', $data['emp_number']);
                $restule = $this->db->update('hs_hr_edu_emp_head');
                $is_added = true;
            }

        }

        
                  
        if(!$is_added){          
            $this->db->insert('hs_hr_edu_emp_head', $data);
            $is_added = true;
        }

        echo "find rown".$num_row."\n";
        echo "-------------------------------\n\n\n";
    }

    
}