<?php
if(!defined("BASEPATH")) exit("No direct access to the script is allowed");

class House extends MY_Controller
{
	var $active_groups;
	var $houses_combo;
	function __construct()
	{
		parent:: __construct();
		$this->load->model('house_model');

		$this->load->library('upload');
        
        $this->pic_path = realpath(APPPATH . '../uploads/');
	}
	function index()
	{
		$data['content_page'] = 'house/houses';
		$data['sidebar'] = 'hr_side_bar';
		$data['houses_c'] = $this->all_house_combo();
		$data['all_houses'] = $this->allhouses('table');
		$data['housetypes'] = $this->gethousetypes();
		
		$data['houseestates'] = $this->gethouseestates();
		// echo "<pre>";print_r($data);die();
		$this->template->call_template($data);
	}


	function houseregistration()
	{
		$path = base_url().'uploads/houses/';
		       $config['upload_path'] = 'uploads/houses';
		       $config['allowed_types'] = 'jpeg|jpg|png|gif';
		       $config['encrypt_name'] = TRUE;
		       $this->load->library('upload', $config);
		       $this->upload->initialize($config);

		      $housepicture = $this->input->post('housepicture');
		      //echo '<pre>';print_r($housepicture);echo '</pre>';die();
			if ( ! $this->upload->do_upload('housepicture'))
		    {
			   $error = array('error' => $this->upload->display_errors());

			   print_r($error);die;
		    }
		     else
		     {
		       
                $data = array('upload_data' => $this->upload->data());
			     foreach ($data as $key => $value) {
				  //print_r($data);die;
				  $path = base_url().'uploads/houses/'.$value['file_name'];
				
                  }

		$houseno = $this->input->post('houseno');
		$housetype = $this->input->post('housetype');
		$houseblock = $this->input->post('houseblock');
		$houseestate = $this->input->post('houseestate');
		$housebedrooms = $this->input->post('housebedrooms');
		$housebathrooms = $this->input->post('housebathrooms');
		$housekitchen = $this->input->post('housekitchen');
		$housedescription = $this->input->post('housedescription');
// print_r($_FILES);
		$insert = $this->house_model->register_house($houseno, $housetype, $houseblock, $houseestate, $path, $housebedrooms, $housebathrooms, $housekitchen, $housedescription);

		return $insert;
		    }
		
	}

	

	function gethousetypes()
	{
        $results = $this->house_model->get_house_types();
        
        //echo '<pre>';print_r($results);echo '</pre>';die;
            $houtyp ='<select class="form-control selectpicker" required name="edithousetype" id="edithousetype"  data-live-search="true">';
            $houtyp .='<option selected="selected" value="">Select the House Type</option>';
        foreach ($results as $value) {
            $houtyp .= '<option value="' . $value['type'] . '">' . $value['type'] . '</option>';  
        }
            $houtyp .='</select>';
        return $houtyp;
	}


	function gethouseestates()
	{
        $results = $this->house_model->get_house_estates();
        
        //echo '<pre>';print_r($results);echo '</pre>';die;
            $houtyp ='<select class="form-control selectpicker js-example-placeholder-single" required name="houseestate" id="houseestate"  data-live-search="true">';
            $houtyp .='<option selected="selected" value="">Select the House Estate</option>';
        foreach ($results as $value) {
            $houtyp .= '<option value="' . $value['estate_name'] . '">' . $value['estate_name'] . '</option>';  
        }
            $houtyp .='</select>';
        return $houtyp;
	}



	function allhouses($type)
	{
		$active_job_groups = $this->house_model->get_all_houses();
		// echo "<pre>";print_r($active_job_groups);die();
		$count = 0;
		$column_data = $row_data = array();
		$this->active_groups .= "<tbody>";
		$html_body = '
		<table class="data-table">
		<thead>
		<tr>
			<th><b>House ID</b></th>
			<th><b>House No</b></th>
			<th><b>House Type</b></th>
			<th><b>Block Name</b></th>
			<th><b>Estate Name</b></th>
			<th><b>Bedroom No</b></th>
			<th><b>Bathroom No</b></th>
			<th><b>Kitchen No</b></th>
			<th><b>Availability</b></th>
			<th><b>House Status</b></th>
			<th><b>Date Registered</b></th>
		</tr> 
		</thead>
		<tbody>
		<ol type="a">';

		foreach ($active_job_groups as $key => $data) {
				if ($data['House Status'] == 1) {
					$span = '<span class="label label-info">Activated</span>';
					$spans = 'Activated';
				} else if ($data['House Status'] == 0) {
					$span = '<span class="label label-alert">Deactivated</span>';
					$spans = 'Deactivated';
				}
				if ($data['Assign Status'] == 0) {
					$sign = '<span class="label success">Vacant</span>';
					$signs = 'Vacant';
				} else if ($data['Assign Status'] == 1) {
					$sign = '<span class="label label-warning">Occupied</span>';
					$signs = 'Occupied';
				}
			$count++;

		switch ($type) {
			case 'table':

				$this->active_groups .= '<tr>';
				$this->active_groups .= '<td>'.$count.'</td>';

				$this->active_groups .= '<td>'.$data['House No'].'</td>';
				$this->active_groups .= '<td>'.$data['House Type'].'</td>';
				$this->active_groups .= '<td>'.$data['Block Name'].'</td>';
				$this->active_groups .= '<td>'.$data['Estate Name'].'</td>';
				$this->active_groups .= '<td>'.$data['Bedrooms'].'</td>';
				$this->active_groups .= '<td>'.$data['Bathrooms'].'</td>';
				$this->active_groups .= '<td>'.$data['Kitchen'].'</td>';
				
                $this->active_groups .= '<td>'.$sign.'</td>';
				$this->active_groups .= '<td>'.$span.'</td>';

				$this->active_groups .= '<td>'.$data['Date Registered'].'</td>';
				
				$this->active_groups .= '</tr>';

				break;
			
			case 'excel':

				array_push($row_data, array($data['House ID'], $data['House No'], $data['House Type'], $data['Block Name'],
					$data['Estate Name'], $data['Bedrooms'], $data['Bathrooms'], $data['Kitchen'],
				    $signs, $spans, $data['Date Registered'])); 
				
				break;

			case 'pdf':
				
			//echo'<pre>';print_r($active_payment_payments);echo'</pre>';die();
           
				$html_body .= '<tr>';
				$html_body .= '<td>'.$data['House ID'].'</td>';
				$html_body .= '<td>'.$data['House No'].'</td>';
				$html_body .= '<td>'.$data['House Type'].'</td>';
				$html_body .= '<td>'.$data['Block Name'].'</td>';
				$html_body .= '<td>'.$data['Estate Name'].'</td>';
				$html_body .= '<td>'.$data['Bedrooms'].'</td>';
				$html_body .= '<td>'.$data['Bathrooms'].'</td>';
				$html_body .= '<td>'.$data['Kitchen'].'</td>';
				$html_body .= '<td>'.$signs.'</td>';
				$html_body .= '<td>'.$spans.'</td>';
				$html_body .= '<td>'.$data['Date Registered'].'</td>';
				
				$html_body .= "</tr></ol>";
				
				break;
		}
		
			
				
			}

		if($type == 'excel'){

            $excel_data = array();
		    $excel_data = array('doc_creator' => 'Asset Management ', 'doc_title' => 'House Excel Report', 'file_name' => 'House Report', 'excel_topic' => 'House');
		    $column_data = array('House ID','House No','House Type','Block Name','Estate Name','Bedroom No','Bathroom No','Kitchen No','Availability','House Status','Date Registered');
		    $excel_data['column_data'] = $column_data;
		    $excel_data['row_data'] = $row_data;

		      //echo'<pre>';print_r($excel_data);echo'</pre>';die();

		    $this->export->create_excel($excel_data);

		}elseif($type == 'pdf'){
			
			$html_body .= '</tbody></table>';
            $pdf_data = array("pdf_title" => "House PDF Report", 'pdf_html_body' => $html_body, 'pdf_view_option' => 'download', 'file_name' => 'House Report', 'pdf_topic' => 'House');

            //echo'<pre>';print_r($pdf_data);echo'</pre>';die();

		    $this->export->create_pdf($pdf_data);

		}else{

			$this->active_groups .= "</tbody>";

		    return $this->active_groups;
		}
		
		
		
	}

	function ajax_get_house($id)
	{
		$house = $this->house_model->search_house($id);
		 //echo "<pre>";print_r($house[0]);die();
		$house = json_encode($house[0]);
		echo $house;
	}


	public function edithouse()
	{
		$id = $this->input->post('edithouseid');
		$house_houseno = $this->input->post('edithouseno');
		$house_housetype = $this->input->post('housetype');
		$house_block = $this->input->post('edithouseblock');
		$house_estate = $this->input->post('edithouseestate');
		$house_bedrooms = $this->input->post('edithousebedrooms');
		$house_bathrooms = $this->input->post('edithousebathrooms');
		$house_kitchen = $this->input->post('edithousekitchen');
		$house_description = $this->input->post('edithousedescription');
		$house_status = $this->input->post('edithousestatus');

		$result = $this->house_model->house_update($id,$house_houseno,$house_housetype,$house_block,$house_estate,$house_bedrooms,$house_bathrooms,$house_kitchen,$house_description,$house_status);
		

		$this->index();
		
	}

	

	function all_house_combo()
	{
		$houses = $this->house_model->get_all_houses();
		// echo "<pre>";print_r($houses);die();
		$this->houses_combo .= '<select name="table_search_house" id="table_search_house" onchange="get_house()" class="form-control input-sm js-example-placeholder-single pull-right" style="width: 350px;">';
		$this->houses_combo .= '<option value="0" selected>Select: House no -- Estate Name</option>';
		foreach ($houses as $key => $value) {
			$this->houses_combo .= '<option value="'.$value['House ID'].'">'.$value['House No'].' -- '.$value['Estate Name'].'</option>';
		}
		$this->houses_combo .= '</select>';

		return $this->houses_combo;
	}


	public function searchhouse()
	{
		$search_array = array();
		if($this->input->post())
		{
			foreach ($this->input->post() as $key => $value) {
				if($value)
				{
					
					$data[$key] = $value;
				}
				else
				{
					$data = array();
				}
			}

			$query = $this->db->get_where('house', $data);

			$result = $query->result_array();
			$search_array = $result;
		}

		return $search_array;
	}

	public function generate_search_table()
	{
		$house_list = '';
		$data = $this->searchhouse();
		$house_list .= '<thead><tr><th>#</th><th>house Number</th><th>First Name</th><th>Last Name</th><th>National ID / Passport No</th><th>Phone Number</th><th>Status</th><th>Date Registered</td></tr></thead>';
		$house_list .= '<tbody>';
		if($data)
		{
			$counter = 0;
			foreach ($data as $key => $value) {
				$counter++;
				$house_list .= '<tr>';
				$house_list .= '<td>' . $counter. '</td>';
				$house_list .= '<td>' . $value['firstname'] . '</td>';
				$house_list .= '<td>' . $value['lastname'] . '</td>';
				$house_list .= '<td>' . $value['nationalid_passport'] . '</td>';
				$house_list .= '<td>' . $value['phone_number'] . '</td>';
				$house_list .= '<td>' . $value['status'] . '</td>';
				$house_list .= '<td>' . $value['date_registered'] . '</td>';
				$house_list .= '<td><a href = "'.base_url().'house/search/housemember/' . $value['house_id'] . '">View More</a></td>';
				$house_list .= '</tr>';
			}
		}
		else
		{
			$house_list .= '<tr><td colspan = "7"><center>No data found</center></td></tr>';
		}
		$house_list .= '</tbody>';

		return $house_list;
	}

	public function housemember($house_id)
	{
		$house_details = $this->house_model->get_house_searched($house_id);
		if ($house_details) {
			# code...
		}
	}

	public function searchresult()
	{
		$data['content_page'] = 'house/houses';
		$data['sidebar'] = 'hr_side_bar';
		$data['search_result'] = $this->generate_search_table();
		
		$this->template->call_template($data);
	}

}
?>