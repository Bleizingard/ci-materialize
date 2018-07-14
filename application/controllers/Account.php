<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Account extends CI_Controller
{

	/*
	 * Set Error Delimiter
	 */
	public function __construct()
	{
		parent::__construct ();
		
		$this->load->model ( "account_model" );
		$this->load->helper ( "form" );
		$this->load->library ( 'form_validation' );
	}

	public function index()
	{
		signin ();
	}

	public function signin()
	{
		// Page Title
		$data ["title_page"] = "Sign In";
		$data ["template_home"] = "";
		
		$user_data = FALSE;
		
		/*
		 * Sign In Form Script
		 */
		if ($this->form_validation->run () == FALSE || ($user_data = $this->account_model->check_credential ( set_value ( 'email' ), set_value ( 'password' ) )) == FALSE)
		{
			/*
			 * Sign In Form Prep Data
			 */
			$data ["form_password"] = array (
					"name" => 'password',
					"id" => 'password',
					"value" => set_value ( "password" ),
					"class" => (empty ( form_error ( "password" ) )) ? "validate" : "validate invalid",
					"required" => "required"
			);
			$data ["form_password_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'password', null, null )
					
			);
			
			$data ["form_email"] = array (
					"name" => 'email',
					"id" => 'email',
					"value" => set_value ( "email" ),
					"class" => (empty ( form_error ( "email" ) )) ? "validate" : "validate invalid",
					"required" => "required"
			);
			$data ["form_email_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'email', null, null )
					
			);
			
			if (! $user_data && $this->form_validation->run ())
			{
				$data ["form_password"] ["class"] = "validate invalid";
				
				$data ["form_password_error"] ["data-error"] = "Bad combinaison login/password";
			}
			
			$this->load->view ( 'template/head', $data );
			$this->load->view ( 'template/header' );
			$this->load->view ( 'account/signin', $data );
			$this->load->view ( 'template/footer' );
		}
		else
		{
			unset ( $user_data->password );
			
			$this->session->set_userdata ( "user", $user_data );
			
			redirect ( '/account/me' );
		}
	}

	public function success($type_success = "default")
	{
		// Page Title
		$data ["title_page"] = "Success !";
		
		switch ($type_success)
		{
			case "signup" :
				$data ["text"] = "Congratulation ! You can now sign in.";
				$data ["mini_text"] = "You will be redirect in 5 sec...";
				break;
			case "signout" :
				$data ["text"] = "You are now sign out. We hope see you soon !";
				break;
			default :
				$data ["text"] = "All is good.";
				break;
		}
		
		$this->load->view ( 'template/head', $data );
		$this->load->view ( 'template/header' );
		$this->load->view ( 'account/success', $data );
		$this->load->view ( 'template/footer' );
	}

	public function failed()
	{
		// Page Title
		$data ["title_page"] = "Oups !";
		
		$this->load->view ( 'template/head', $data );
		$this->load->view ( 'template/header' );
		$this->load->view ( 'account/failed', $data );
		$this->load->view ( 'template/footer' );
	}

	public function signout()
	{
		$this->session->sess_destroy ();
		// Page Title
		$data ["title_page"] = "Goodbye";
		
		$this->load->view ( 'template/head', $data );
		$this->load->view ( 'template/header' );
		$this->load->view ( 'account/signout' );
		$this->load->view ( 'template/footer' );
		
		$this->output->set_header ( 'refresh:5; url=' . base_url () );
	}

	public function signup()
	{
		//Upload file config
		$config['upload_path'] = '/var/www/html/mfh/upload/';
		$config['allowed_types'] = 'jpg';
		$config['max_size']     = '256';
		$config['max_width'] = '1024';
		$config['max_height'] = '1200';
		$config['encrypt_name'] = true;
		$config['file_ext_tolower'] = true;
		
		
		// Page Title
		$data ["title_page"] = "Sign Up";
		$data ["template_home"] = "";
		
		$footer["extra_js"] = "init_signup.js";
		
		$this->load->library('upload', $config);
		
		
		$upload_result = $this->upload->do_upload('prooffile');
		
		if ($this->form_validation->run () == FALSE || ! $upload_result)
		{
			/*
			 * Sign Up Form Prep Data
			 */
			$data ["form_login"] = array (
					"name" => 'login',
					"id" => 'login',
					"value" => set_value ( "login" ),
					"class" => (empty ( form_error ( "login" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_login_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'login', null, null ) 
			
			);
			
			$data ["form_password"] = array (
					"name" => 'password',
					"id" => 'password',
					"value" => set_value ( "password" ),
					"class" => (empty ( form_error ( "password" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_password_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'password', null, null ) 
			
			);
			
			$data ["form_password_confirm"] = array (
					"name" => 'password_confirm',
					"id" => 'password_confirm',
					"class" => (empty ( form_error ( "password_confirm" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_password_confirm_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'password_confirm', null, null ) 
			
			);
			
			$data ["form_email"] = array (
					"name" => 'email',
					"id" => 'email',
					"value" => set_value ( "email" ),
					"class" => (empty ( form_error ( "email" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_email_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'email', null, null ) 
			
			);
			
			$data ["form_firstname"] = array (
					"name" => 'firstname',
					"id" => 'firstname',
					"value" => set_value ( "firstname" ),
					"class" => (empty ( form_error ( "firstname" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_firstname_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'firstname', null, null ) 
			
			);
			
			$data ["form_lastname"] = array (
					"name" => 'lastname',
					"id" => 'lastname',
					"value" => set_value ( "lastname" ),
					"class" => (empty ( form_error ( "lastname" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_lastname_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'lastname', null, null ) 
			
			);
			
			$data ["form_street"] = array (
					"name" => 'street',
					"id" => 'street',
					"value" => set_value ( "street" ),
					"class" => (empty ( form_error ( "street" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_street_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'street', null, null ) 
			
			);
			
			$data ["form_city"] = array (
					"name" => 'city',
					"id" => 'city',
					"value" => set_value ( "city" ),
					"class" => (empty ( form_error ( "city" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_city_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'city', null, null ) 
			
			);
			
			$data ["form_zipcode"] = array (
					"name" => 'zipcode',
					"id" => 'zipcode',
					"value" => set_value ( "zipcode" ),
					"class" => (empty ( form_error ( "zipcode" ) )) ? "validate" : "validate invalid",
					"required" => "required" 
			);
			$data ["form_zipcode_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'zipcode', null, null ) 
			
			);
			
			$data ["form_country"] = array (
					"name" => 'country',
					"options" => $this->account_model->get_countries (),
					"selected" => set_value ( "country" ),
					"extra" => array (
							"id" => 'country',
							"class" => (empty ( form_error ( "country" ) )) ? "validate" : "validate invalid",
							"required" => "required" 
					) 
			);
			$data ["form_country_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'country', null, null ) 
			
			);
			$data["form_prooffile"] = array (
					"class" => (!$this->input->post() || empty ( $this->upload->display_errors('', ''))) ? "file-path validate" : "file-path validate invalid"
			);
			$data["form_prooffile_error"] = array(
					"class" => "helper-text",
					"data-error" => $this->upload->display_errors('', ''));
			$data ["form_tos"] = array (
					"name" => 'tos',
					"id" => 'tos',
					"value" => "tos",
					"checked" => set_value("tos"),
					"class" => (empty ( form_error ( "tos" ) )) ? "validate" : "validate invalid",
					"required" => "required"
			);
			$data ["form_tos_error"] = array (
					"class" => "helper-text",
					"data-error" => form_error ( 'tos', null, null )
					
			);
			
			$this->load->view ( 'template/head', $data );
			$this->load->view ( 'template/header' );
			$this->load->view ( 'account/signup', $data );
			$this->load->view ( 'template/footer', $footer );
		}
		else
		{
			/*
			 * Format data for insert
			 */
			$user = array (
					"Login" => set_value ( "login" ),
					"Email" => set_value ( "email" ),
					"Password" => set_value ( "password" ),
					"Firstname" => set_value ( "firstname" ),
					"Lastname" => set_value ( "lastname" ),
					"Street" => set_value ( "street" ),
					"City" => set_value ( "city" ),
					"ZipCode" => set_value ( "zipcode" ),
					"IdCountry" => set_value ( "country" )
			);
			
			$prooffile = $this->upload->data();
			
			/*
			 * Insert into BDD
			 */
			if ($this->account_model->insert_user ( $user, $prooffile ))
			{
				$this->success ( "signup" );
				
				$this->output->set_header ( 'refresh:5; url=' . base_url () );
			}
			else
			{
				$this->failed ();
			}
		}
	}

	public function me()
	{
		if ($this->toolbox->is_logged ())
		{
			
			// Page Title
			$data ["title_page"] = "";
			$data ["user"] = $this->session->get_userdata ( "user" ) ["user"];
			
			/*
			 * Edit Mail Form Prep Data
			 */
			$data ["form_email"] = array (
					"name" => 'email',
					"id" => 'email',
					"value" => $data ["user"]->Email,
					"class" => "validate",
					"required" => "required" 
			);
			
			$this->load->view ( 'template/head', $data );
			$this->load->view ( 'template/header' );
			$this->load->view ( 'account/profile', $data );
			$this->load->view ( 'template/footer' );
		}
		else
		{
			redirect ( '/signin' );
		}
	}

	public function dashboard()
	{
		if ($this->toolbox->is_logged ())
		{
			// Page Title
			$data ["title_page"] = "";
			$data ["user_data"] = $this->session->get_userdata ( "user" );
			
			$this->load->view ( 'template/head', $data );
			$this->load->view ( 'template/header' );
			$this->load->view ( 'account/dashboard', $data );
			$this->load->view ( 'template/footer' );
		}
		else
		{
			redirect ( '/signin' );
		}
	}

	public function edit($type)
	{
		if ($this->toolbox->is_logged ())
		{
			// Page Title
			$data ["title_page"] = "Change my informations";
			$data ["user"] = $this->session->get_userdata ( "user" ) ["user"];
			
			if ($this->form_validation->run () == FALSE)
			{
				switch ($type)
				{
					case "infos" :
					/*
					 * Edit Infos Form Prep Data
					 */
					$data ["form_email"] = array (
								"name" => 'email',
								"id" => 'email',
								"value" => (! empty ( set_value ( "email" ) )) ? set_value ( "email" ) : $data ["user"]->email,
								"class" => (empty ( form_error ( "email" ) )) ? "validate" : "validate invalid",
								"required" => "required" 
						);
						$data ["form_email_label"] = array (
								"data-error" => form_error ( 'email', null, null ) 
						
						);
						
						break;
					case "password" :
					/*
					 * Sign Up Form Prep Data
					 */
					$data ["form_old_password"] = array (
								"name" => 'old_password',
								"id" => 'old_password',
								"value" => set_value ( "old_password" ),
								"class" => (empty ( form_error ( "old_password" ) )) ? "validate" : "validate invalid",
								"required" => "required" 
						);
						$data ["form_old_password_label"] = array (
								"data-error" => form_error ( 'old_password', null, null ) 
						
						);
						
						$data ["form_password"] = array (
								"name" => 'password',
								"id" => 'password',
								"value" => set_value ( "password" ),
								"class" => (empty ( form_error ( "password" ) )) ? "validate" : "validate invalid",
								"required" => "required" 
						);
						$data ["form_password_label"] = array (
								"data-error" => form_error ( 'password', null, null ) 
						
						);
						
						$data ["form_password_confirm"] = array (
								"name" => 'password_confirm',
								"id" => 'password_confirm',
								"class" => (empty ( form_error ( "password_confirm" ) )) ? "validate" : "validate invalid",
								"required" => "required" 
						);
						$data ["form_password_confirm_label"] = array (
								"data-error" => form_error ( 'password_confirm', null, null ) 
						
						);
						break;
					default :
						show_404 ();
						break;
				}
				$this->load->view ( 'template/head', $data );
				$this->load->view ( 'template/header' );
				$this->load->view ( 'account/edit_' . $type, $data );
				$this->load->view ( 'template/footer' );
			}
			else
			{
				switch ($type)
				{
					case "infos" :
						$this->account_model->update_infos_user ( array (
								"email" => set_value ( "email" ) 
						), $data ["user"]->id );
						/*
						 * Mise à jour des nouvelles données
						 */
						$updated_user = $this->account_model->get_user_by_id ( $data ["user"]->id )->row ();
						unset ( $updated_user->password );
						$this->session->set_userdata ( "user", $updated_user );
						redirect ( '/account/me' );
						break;
					case "password" :
						$this->account_model->update_password_user ( set_value ( "password" ), $data ["user"]->id );
						redirect ( '/account/me' );
						break;
					default :
						break;
				}
				
				redirect ( '/account/me' );
			}
		}
		else
		{
			redirect ( '/signin' );
		}
	}
}
?>