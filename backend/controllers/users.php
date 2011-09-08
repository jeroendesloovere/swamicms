<?php if(!defined('SWAMI')){die('External Access to File Denied');}

class users_controller extends backend_controller
{
	// All users + rights
	// -----------------------------------------------
	public function index()
	{
		// TOTRY
		/*
		block('sidebar',array(
			'save'=>'',
			'save_and_continue'=>'',
			'cancel'=>'',
		));
		block('table',array(
			'data'=>user::$table->all()
		));
		// END TOTRY
		*/
		
		set('users', user::$table->all());
		view('users/index');
	}
	
	// Edit user
	// -----------------------------------------------
	public function edit($id)
	{
		// Get user
		$user = user::get($id);
		set('user', $user);
			
		// View
		breadcrumb($user->username.' - "'.$user->email.'"');
		view('users/edit');
	}
	
	// Edit own profile
	// -----------------------------------------------
	public function profile()
	{
		if(isAllowed('profile'))
		{
			set('user', user::get(user::id()));
			view('users/edit');
		}
		else url::redirect('admin/users');
	}
	
	// Add user
	// -----------------------------------------------
	public function add()
	{
		set('user', user::get(0));
		view('users/edit');
	}
	
	// Save user
	// -----------------------------------------------
	public function save()
	{
		// Get
		$data = $_POST['user'];
		
		// Update or delete
		if(isset($data['id']))
		{
			// Delete
			if(isset($_POST['delete'])) user::delete($data['id']);
			
			// Update
			user::update($data['id'])
			   ->username($data['username'])
			   ->email($data['email'])
			   ->type($data['type'])
			   ->save();
		}	
		// Insert
		else
		{
			user::create(array(
				'username'=>$data['username'],
				'email'=>$data['email'],
				'password'=>'test',
				'type'=>'admin'
			));
		}
			note::success('save','complete');
		
		// Return view
		if(isset($_POST['saveAndEdit'])) url::redirect('admin/users/edit/'.$data['id']);
		else url::redirect('admin/users');
	}
	
	// Delete user
	// -----------------------------------------------
	public function delete($user_id)
	{
		// Delete user
		user::delete($user_id);
			
		// Redirect
		note::success('delete','complete');
		url::redirect('admin/users');
	}
	
	// Login
	// -----------------------------------------------
	public function login()
	{	
		$this->setLayout('login');
		if(user::valid()){ url::redirect('admin/pages'); }
		else{
			// Get previous page for redirecting when logged in
			$prev_page = '';
			if($prev_page = note::get('prev_page')) $prev_page = $prev_page['content'];
			elseif(isset($_SERVER['HTTP_REFERER']))
			{
				$referer = str_replace(BASE_URL,'',$_SERVER['HTTP_REFERER']);
				if($referer!='login'&&$referer!='user/login') $prev_page = $referer;
			}
			
			// View
			view('users/login', array('prev_page'=>$prev_page));
		}
	}
	
	// Login check
	// -----------------------------------------------
	public function _login()
	{
		// Get prev page
		$prev_page = input::post('prev_page');
		note::regular("prev_page",$prev_page);
		
		// User found in DB - correct username/id/email and password
		if(user::check(input::post('username'),user::hash(input::post('password'))))
		{
			// Permission to login
			if(acl::get('users')->isAllowed(user::get(input::post('username'))->type,'login'))
			{
				user::login(input::post('username'),input::post('password'));
				if(!empty($prev_page)) url::redirect($prev_page);
				else url::redirect('admin');
			}
			// No permission to login
			else
			{
				note::error("login_error","You have no permission to login!");
				url::redirect('admin/login');
			}
		}
		// User not found - wrong username/id/email and/or password
		else
		{
			note::error("login_error","Username and password do not match the system!");
			url::redirect('admin/login');
		}
	}
	
	// Password recovery
	// -----------------------------------------------
	public function password_recovery()
	{
		$this->setLayout('login');
		view('users/login', array('password_forgotten'=>true));
	}
	
	// TODO: password omzetten van sha1 naar leesbaar...
	// Password recovery
	// -----------------------------------------------
	public function _password_recovery()
	{
		// Check login
		$user = user::get(input::post('email'));
		print_r($user);
	}
	
	// Logout
	// -----------------------------------------------
	public function logout()
	{
		user::logout();
		url::redirect('admin/login');
	}
}