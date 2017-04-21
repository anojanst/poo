<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/employees_functions.php';

$module_no = 10;
if ($_SESSION['login'] == 1) {
	if (check_access($module_no, $_SESSION['user_id']) == 1) {
		if ($_REQUEST['job'] == 'add') {
			if ($_REQUEST['ok'] == 'Save') {
				$employee_name = $_POST['employee_name'];
				$full_name = $_POST['full_name'];
				$department = $_POST['department'];
				$branch=$_POST['branch'];
				$email = $_POST['email'];
				$telephone = $_POST['telephone'];
				$mobile = $_POST['mobile'];
				$address = addslashes($_POST['address']);
				$user = $_POST['user'];
				$user_name = $_POST['user_name'];
				$password = $_POST['password'];

				save_employees($employee_name, $full_name, $department,$branch, $email, $telephone, $mobile, $address, $user, $user_name, $password);

				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Employees");
				$smarty->display('employees/employees.tpl');
			}
            else {

				$id = $_SESSION['id'];
				$employee_name = $_POST['employee_name'];
				$full_name = $_POST['full_name'];
				$department = $_POST['department'];
                $branch=$_POST['branch'];
				$email = $_POST['email'];
				$telephone = $_POST['telephone'];
				$mobile = $_POST['mobile'];
				$address = addslashes($_POST['address']);
				$user = $_POST['user'];
				$user_name = $_POST['user_name'];
				$password = $_POST['password'];

				update_employees($id, $employee_name, $full_name, $department,$branch, $email, $telephone, $mobile, $address, $user, $user_name, $password);

				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "Employees");
				$smarty->display('employees/employees.tpl');
			}
		}
        elseif($_REQUEST['job']== 'add_new'){
            
            $smarty->assign('page', "Employees");
			$smarty->display('employees/add_new.tpl');
        }
		elseif ($_REQUEST['job'] == 'edit') {
			$info = get_employee_info($_REQUEST['id']);
			$_SESSION['id'] = $_REQUEST['id'];

			$smarty->assign('employee_name', $info['employee_name']);
			$smarty->assign('full_name', $info['full_name']);
			$smarty->assign('department', $info['department']);
            $smarty->assign('branch', $info['branch']);
			$smarty->assign('email', $info['email']);
			$smarty->assign('telephone', $info['telephone']);
			$smarty->assign('mobile', $info['mobile']);
			$smarty->assign('address', $info['address']);
			if ($info['user'] == 1) {
				$smarty->assign('user', "checked");
			}
			$smarty->assign('user_name', $info['user_name']);
			$smarty->assign('password', $info['code']);

			$smarty->assign('edit_mode', "on");
			$smarty->assign('edit', "Employee");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Employees");
			$smarty->display('employees/add_new.tpl');
		}
		elseif ($_REQUEST['job'] == 'search') {

			$_SESSION['search'] = $_POST['search'];

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('search', "$_SESSION[search]");
			$smarty->assign('search_mode', "on");
			$smarty->assign('page', "Employees");
			$smarty->display('employees/employees.tpl');
		}
		elseif ($_REQUEST['job'] == 'delete') {
			cancel_employee($_REQUEST['id']);

			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Employees");
			$smarty->display('employees/employees.tpl');
		}
		elseif ($_REQUEST['job'] == 'access') {
			$module_no = 12;
			if (check_access($module_no, $_SESSION['user_id']) == 1) {
				$_SESSION['id'] = $_REQUEST['id'];
				$info = get_employee_info($_REQUEST['id']);

				$smarty->assign('full_name', "$info[full_name]");
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('page', "User Access Management");
				$smarty->display('employees/access.tpl');
			} else {
				$user_name = $_SESSION['user_name'];
				$smarty->assign('org_name', "$_SESSION[org_name]");
				$smarty->assign('error_report', "on");
				$smarty->assign('error_message', "Dear $user_name, you don't have permission to USER ACCESS an item.");
				$smarty->assign('page', "Access Error");
				$smarty->display('user_home/access_error.tpl');
			}
		}
		elseif ($_REQUEST['job'] == "remove_access") {
			$id = $_SESSION['id'];
			$module_no = $_REQUEST['module_no'];

			remove_user_module($id, $module_no);

			$info = get_employee_info($id);

			$smarty->assign('full_name', "$info[full_name]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "User Access Management");
			$smarty->display('employees/access.tpl');
		}
		elseif ($_REQUEST['job'] == "add_access") {
			$id = $_SESSION['id'];
			$module_no = $_REQUEST['module_no'];

			add_user_module($id, $module_no);

			$info = get_employee_info($id);

			$smarty->assign('full_name', "$info[full_name]");
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "User Access Management");
			$smarty->display('employees/access.tpl');
		} else {
			$smarty->assign('org_name', "$_SESSION[org_name]");
			$smarty->assign('page', "Employees");
			$smarty->display('employees/employees.tpl');
		}
	} else {
		$user_name = $_SESSION['user_name'];
		$smarty->assign('org_name', "$_SESSION[org_name]");
		$smarty->assign('error_report', "on");
		$smarty->assign('error_message', "Dear $user_name, you don't have permission to access EMPLOYEE.");
		$smarty->assign('page', "Access Error");
		$smarty->display('user_home/access_error.tpl');
	}
} else {
	$smarty->assign('error', "Incorrect Login Details!");
	$smarty->display('login.tpl');
}