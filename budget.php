<?php
		$page = explode("/", $_SERVER["SCRIPT_NAME"]);
		$page = end($page);
		//echo $page;
		if($page == "budget.php") include("../config.php");
		//$table->create("budget", "id i nn a, month_year v nn, income v nn, expenses v nn, body t nn");
		//$table->drop("budget");
		
		if(isset($_GET["fetchbudget"])){
			header("Content-Type: application/json; charset=utf-8");
			$budget = "";
			$budgets = $table->fetch("budget","");
			if($budgets != false){
				while($res = mysqli_fetch_array($budgets)){
				  $income = number_format($res["income"]);
				  $expense = number_format($res["expenses"]);
				  $diff = $res["income"] - $res["expenses"];
				  $body = $res["body"];
				  $col = "green";
				  if($diff <= 0) $col = "red";
				  elseif($diff < (0.1*$res["income"])) $col = "orange";
					$budget .= <<<eol
						<div class="clientBody">
							<span>
								<h4>{$res["month_year"]}</h4>
								<span><b style="color:green">Income ₦</b> {$income}</span>
								<span><b style="color:red">Expenditure ₦</b> {$expense}</span>
								<span><b style="color:{$col}">Difference ₦</b> {$diff}</span>
								<span>{$res["body"]}</span>
							</span>
							<span>
							<span class="button" style="display:noe">Edit</span>
							<span class="button red" onclick="removeBudget({$res['id']})">Remove</span>
							</span>
						</div>
					eol;
				}
			}
			else{
				$budget = "error...";
			}
			echo json_encode(["res"=>$budget]);
			exit;
		}
		
		
		if(isset($_GET["addbudget"])){
			header("Content-Type: application/json; charset=utf-8");
			$query = [];
			if(isset($_POST)){
				foreach($_POST as $p => $v){
					$query[] = $p . "='".mysqli_real_escape_string($conn, $v)."' ";
					if($v == ""){
						echo json_encode(["res"=>"please, fill all fields to save client info."]);
						exit;
					}
				}
			}
			$query = implode(",",$query);
			//echo json_encode(["res"=>$query]);
			//exit;
			
			$budgets = $table->insert("budget", "s ".$query);
			if($budgets != false){
				$budget = "Budget Added";
			}
			else{
				$budget = $budgets;
			}
			echo json_encode(["res"=>$budget]);
			exit;
		}
		
		
		if(isset($_GET["removebudget"])){
			header("Content-Type: application/json; charset=utf-8");
			$budgets = $table->remove("budget", "w id='".$_GET["removebudget"]."'");
			if($budgets != false){
				$budget = "Budget Removed";
			}
			else{
				$budget = $budgets;
			}
			echo json_encode(["res"=>$budget]);
			exit;
		}
		//$table->alter("budget","aa timestamp t nn ");
		//$table->update("budget","s client_address='benin city'");
		//$table->insert("budget","s client_name='Sam Doe'");
		
?>
<div>
	<span class="button" onclick="showForm()">Add A Client</span>
	<span class="button" onclick="fetchBudgets()">View Budgets</span>
</div>

<div id="clientView">
	<span>Clients</span>
	<div class="clientHeading">
		<span>Budget Info</span>
		<span>Action</span>
	</div>
	<div id="viewContainer"></div>
</div>

<div id="clientForm">
	<span>Client Form</span>
	<div id="formContainer">
		<span class="label">Month/Year</span>
		<span contenteditable="true" class="input" id="b_month"></span>
		
		<span class="label">Budget Info</span>
		<div id="b_body">
			<h3>Income</h3>
			<ul id="incomeBox">
				<li><span class="source" contenteditable="true" subtype="source"></span> : ₦ <span class="amount" contenteditable="true" subtype="amount"></span></li>
			</ul>
			<span class="button white" filter onclick="newRow(incomeBox)">+</span>
			<h3>Expenditure</h3>
			<ul id="expenseBox">
				<li><span class="source" contenteditable="true" subtype="source"></span> : ₦ <span class="amount" contenteditable="true" subtype="amount"></span></li>
			</ul>
			<span class="button white" filter onclick="newRow(expenseBox)">+</span>
		</div>
		<div id="bodyClone" style="display:none"></div>
		<span class="label">Total Income</span>
		<span class="input" id="income"></span>
		
		<span class="label">Total Expense</span>
		<span class="input" id="expense"></span>
		
		<hr>
		<span class="label">Difference(Income - Expenses)</span>
		<span class="input" id="diff"></span>
		
		<span class="button" onclick="addBudget()">Add Budget</span>
	</div>
</div>
