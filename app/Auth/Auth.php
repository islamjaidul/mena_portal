<?php
/**
 * Created by PhpStorm.
 * User: shiblie
 * Date: 11/11/16
 * Time: 9:33 PM
 */

namespace App\Auth;

use App\Models\Applicant;
use App\Models\Employee;
use App\Models\EmployeeTitle;
use App\Models\User;
use App\Models\ProfileSetting;

class Auth {

	public function check () {
		return isset($_SESSION['user']);
	}

	public function attempt ($user, $password) {
		$user = User::where('username', $user)->first();
		if (!$user) {
			return false;
		}
		if(password_verify($password, $user->password)){
			$_SESSION['user'] = $user->id;
			return true;
		}
		return false;
	}

	public function logout() {
		unset($_SESSION['user']);
		session_destroy($_SESSION['user']);
	}

	public function allUsers(){
		return User::all();
	}

	public function user() {
		if (isset($_SESSION['user'])) {
			return User::find($_SESSION['user']);
		} else {
			return false;
		}
	}

	public function allEmployees(){
		return Employee::all();
	}

	public function employee(){
		return Employee::where('id', $this->user()->first()->emp_id);
	}

	public function allApplicants () {
		return Applicant::all();
	}

	public function applicant(){
		return Applicant::where('id', $this->employee()->first()->applicant_id);
	}

	public function profile () {
		if (isset($_SESSION['user'])) {
			return ProfileSetting::where('user_id', $_SESSION['user'])->first();
		} else {
			return false;
		}
	}

	public function title() {
		return EmployeeTitle::where('emp_id', $this->employee()->first()->id);
	}





}
