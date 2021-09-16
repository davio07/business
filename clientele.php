<?php
		$page = explode("/", $_SERVER["SCRIPT_NAME"]);
		$page = end($page);
		//echo $page;
		if($page == "clientele.php") include("../config.php");
		//$table->create("clientele", "id i nn a, client_name v nn, client_address t n, client_phone t nn, client_email t nn");
		//$table->drop("clientele");
		
		if(isset($_GET["clients"])){
			header("Content-Type: application/json; charset=utf-8");
			$clientele = "";
			$clients = $table->fetch("clientele","");
			if($clients != false){
				while($res = mysqli_fetch_array($clients)){
					$clientele .= <<<eol
						<div class="clientBody">
							<span>
								<h4>{$res["client_name"]}</h4>
								<span>📍 {$res["client_address"]}</span>
								<span>📞 {$res["client_phone"]}</span>
								<span>📨 {$res["client_email"]}</span>
							</span>
							<span>
							<span class="button" style="display:noe">Edit</span>
							<span class="button red" onclick="removeClient({$res['id']})">Remove</span>
							</span>
						</div>
					eol;
				}
			}
			else{
				$clientele = "error...";
			}
			echo json_encode(["res"=>$clientele]);
			exit;
		}
		
		
		if(isset($_GET["addclient"])){
			header("Content-Type: application/json; charset=utf-8");
			$query = "";
			if(isset($_POST)){
				foreach($_POST as $p => $v){
					$query .= $p . "='".mysqli_real_escape_string($conn, $v)."', ";
					if($v == ""){
						echo json_encode(["res"=>"please, fill all fields to save client info."]);
						exit;
					}
				}
			}
			$clients = $table->insert("clientele", "s ".$query." timestamp='".time()."'");
			if($clients != false){
				$clientele = "Client Added";
			}
			else{
				$clientele = $clients;
			}
			echo json_encode(["res"=>$clientele]);
			exit;
		}
		
		
		if(isset($_GET["removeclient"])){
			header("Content-Type: application/json; charset=utf-8");
			$clients = $table->remove("clientele", "w id='".$_GET["removeclient"]."'");
			if($clients != false){
				$clientele = "Client Removed";
			}
			else{
				$clientele = $clients;
			}
			echo json_encode(["res"=>$clientele]);
			exit;
		}
		//$table->alter("clientele","aa timestamp t nn ");
		//$table->update("clientele","s client_address='benin city'");
		//$table->insert("clientele","s client_name='Sam Doe'");
		
?>
<div>
	<span class="button" onclick="showForm()">Add A Client</span>
	<span class="button" onclick="fetchClients()">View Clients</span>
</div>

<div id="clientView">
	<span>Clients</span>
	<div class="clientHeading">
		<span>Client Info</span>
		<span>Action</span>
	</div>
	<span id="searchForm" class="input" contenteditable="true" oninput="searchClients()"></span>
	<div id="viewContainer"></div>
</div>

<div id="clientForm">
	<span>Client Form</span>
	<div id="formContainer">
		<span class="label">Client's Name</span>
		<span contenteditable="true" class="input" id="c_name"></span>
		
		<span class="label">Client's Phone</span>
		<span contenteditable="true" class="input" id="c_phone"></span>
		
		<span class="label">Client's Address</span>
		<span contenteditable="true" class="input" id="c_addr"></span>
		
		<span class="label">Client's Email</span>
		<span contenteditable="true" class="input" id="c_email"></span>
		
		<span class="button" onclick="addClient()">Add A Client</span>
	</div>
</div>
