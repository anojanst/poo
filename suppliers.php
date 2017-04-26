<?php
require_once 'conf/smarty-conf.php';
include 'functions/suppliers_functions.php';

if ($_SESSION['login']==1){

	if ($_REQUEST['job']=="supplier_form"){
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Supplier");
		$smarty->display('suppliers/suppliers.tpl');
	}

	elseif ($_REQUEST['job']=="add"){

		if ($_REQUEST['ok']=='Update') {

			$id=$_SESSION['id'];

			$supplier_name=$_POST['supplier_name'];
			$address=$_POST['address'];
			$telephone=$_POST['telephone'];
			$fax=$_POST['fax'];
			$email=$_POST['email'];
			$contact_person=$_POST['contact_person'];

			update_supplier($id, $supplier_name, $address, $telephone, $fax, $email, $contact_person);
		}
		else{
			$supplier_name=$_POST['supplier_name'];
			$address=$_POST['address'];
			$telephone=$_POST['telephone'];
			$fax=$_POST['fax'];
			$email=$_POST['email'];
			$contact_person=$_POST['contact_person'];

			save_supplier($supplier_name, $address, $telephone, $fax, $email, $contact_person);
		}

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Suppliers");
		$smarty->display('suppliers/suppliers.tpl');
	}
	elseif ($_REQUEST['job']=="edit"){
		$_SESSION['id']=$id=$_REQUEST['id'];
		$info=get_supplier_info_by_id($id);

		$smarty->assign('supplier_name',$info['supplier_name']);
		$smarty->assign('address',$info['address']);
		$smarty->assign('telephone',$info['telephone']);
		$smarty->assign('fax',$info['fax']);
		$smarty->assign('email',$info['email']);
		$smarty->assign('contact_person',$info['contact_person']);

		$smarty->assign('edit_mode','on');
		$smarty->assign('edit','Supplier');
		$smarty->assign('page',"Suppliers");
		$smarty->display('suppliers/suppliers.tpl');
	}
	elseif($_REQUEST['job']=='search'){

		$_SESSION['search']=$_POST['search'];

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('search',"$_SESSION[search]");
		$smarty->assign('search_mode',"on");
		$smarty->assign('page',"Suppliers");
		$smarty->display('suppliers/suppliers.tpl');
	}
	elseif ($_REQUEST['job']=="delete"){
		cancel_supplier($_REQUEST['id']);

		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Suppliers");
		$smarty->display('suppliers/suppliers.tpl');
	}
	else{
		$smarty->assign('org_name',"$_SESSION[org_name]");
		$smarty->assign('page',"Suppliers");
		$smarty->display('suppliers/suppliers.tpl');
	}
}
else{
	$smarty->assign('page',"Home");
	$smarty->display('index.tpl');
}