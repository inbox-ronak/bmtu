<?php
	class Dashboard_model extends CI_Model{

	
		public function all_project(){
			return $this->db->count_all('ci_projects');
		}
                
        public function all_equipment(){
			return $this->db->count_all('ci_equipment');
		}

                
		public function get_all_suppliers(){
			$this->db->where('user_type', 3);
			return $this->db->count_all_results('ci_users');
		}
		public function get_all_procurer(){
			$this->db->where('user_type', 2);
			return $this->db->count_all_results('ci_users');
		}

		public function get_all_tenders(){
			return $this->db->count_all('ci_tenders');
		}
		public function get_all_biders(){
			return $this->db->count_all('ci_tenders');
		}
		
		
	}

?>
