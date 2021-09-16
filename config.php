<?php
		$conn = mysqli_connect("0.0.0.0","root","root");
		mysqli_query($conn,"create database if not exists business");
		mysqli_select_db($conn, "business");
		
class Table{
	public function create($tbl,$arg){
		$conn = mysqli_connect("0.0.0.0","root","root","business");
		$arg = preg_replace("~\bn\b~","null", $arg);
		$arg = preg_replace("~\bnn\b~","not null", $arg);
		$arg = preg_replace("~\bv\b~","varchar(255)", $arg);
		$arg = preg_replace("~\bi\b~","int", $arg);
		$arg = preg_replace("~\bt\b~","text", $arg);
		$arg = preg_replace("~\ba\b~","auto_increment primary key", $arg);
		$query = mysqli_query($conn, "create table if not exists ".$tbl. " (" .$arg.")");
		if($query) echo $tbl . " created successfully";
		else echo "Issue: ".mysqli_error($conn);
	}
	function fetch($tbl,$arg){
		$conn = mysqli_connect("0.0.0.0","root","root","business");
		$arg = preg_replace("~\bw\b~"," where ", $arg);
		$arg = preg_replace("~\ba\b~"," and ", $arg);
		$arg = preg_replace("~\bo\b~"," or ", $arg);
		$arg = preg_replace("~\bl\b~"," like ", $arg);
		$query = mysqli_query($conn, "select * from ".$tbl.$arg);
		if($query){
			return $query;
		}else{
			return mysqli_error($conn);
		}
	}
	function insert($tbl,$arg){
		$conn = mysqli_connect("0.0.0.0","root","root","business");
		$arg = preg_replace("~\bw\b~"," where ", $arg);
		$arg = preg_replace("~\ba\b~"," and ", $arg);
		$arg = preg_replace("~\bo\b~"," or ", $arg);
		$arg = preg_replace("~\bl\b~"," like ", $arg);
		$arg = preg_replace("~\bs\b~"," set ", $arg);
		$query = mysqli_query($conn, "insert into ".$tbl.$arg);
		if($query){
			return $query;
		}else{
			return mysqli_error($conn);
		}
	}
	function update($tbl,$arg){
		$conn = mysqli_connect("0.0.0.0","root","root","business");
		$arg = preg_replace("~\bw\b~"," where ", $arg);
		$arg = preg_replace("~\ba\b~"," and ", $arg);
		$arg = preg_replace("~\bo\b~"," or ", $arg);
		$arg = preg_replace("~\bl\b~"," like ", $arg);
		$arg = preg_replace("~\bs\b~"," set ", $arg);
		$query = mysqli_query($conn, "update ".$tbl.$arg);
		if($query){
			return "successful";
		}else{
			return mysqli_error($conn);
		}
	}
	function remove($tbl,$arg){
		$conn = mysqli_connect("0.0.0.0","root","root","business");
		$arg = preg_replace("~\bw\b~"," where ", $arg);
		$arg = preg_replace("~\ba\b~"," and ", $arg);
		$arg = preg_replace("~\bo\b~"," or ", $arg);
		$arg = preg_replace("~\bl\b~"," like ", $arg);
		$arg = preg_replace("~\bs\b~"," set ", $arg);
		$query = mysqli_query($conn, "delete from ".$tbl.$arg);
		if($query){
			return true;
		}else{
			return mysqli_error($conn);
		}
	}
	function alter($tbl,$arg){
		$conn = mysqli_connect("0.0.0.0","root","root","business");
		$arg = preg_replace("~\bn\b~","null", $arg);
		$arg = preg_replace("~\bnn\b~","not null", $arg);
		$arg = preg_replace("~\bv\b~","varchar(255)", $arg);
		$arg = preg_replace("~\bi\b~","int", $arg);
		$arg = preg_replace("~\bt\b~","text", $arg);
		$arg = preg_replace("~\baa\b~","add column", $arg);
		$arg = preg_replace("~\ba\b~","auto_increment primary key", $arg);
		
		if(mysqli_query($conn, "alter table ".$tbl. " " .$arg)) echo $tbl . " altered successfully";
		else echo "Issue: ".mysqli_error($conn);
	}
	
	function drop($tbl){
		$conn = mysqli_connect("0.0.0.0","root","root","business");

		if(mysqli_query($conn, "drop table ".$tbl)) echo $tbl . " dropped successfully";
		else echo "Issue: ".mysqli_error($conn);
	}
}
		/*
		for the clientele;
		#id,client_name, client_need, 
		client_type, client_phone, client_buys, 
		client_email
		*/
		$table = new Table();
?>
