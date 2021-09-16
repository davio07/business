//alert("hello world");
const fetchClients = ()=>{
	event.preventDefault();
	viewContainer.innerHTML = "loading content...";
	//return false
	fetch("apps/clientele.php?clients").
	then((response)=>response.json()).
	then((data)=>{
		//alert(data.res);
		viewContainer.innerHTML = data.res;
	})
}
const showForm = ()=>{
	formContainer.style.display = "grid";
}
const addClient = ()=>{
	event.preventDefault();
	const formBody = new FormData();
	formBody.append("client_name",c_name.innerText);
	formBody.append("client_email",c_email.innerText);
	formBody.append("client_phone",c_phone.innerText);
	formBody.append("client_address",c_addr.innerText);
	fetch("apps/clientele.php?addclient",{
		method: "POST",
		body: formBody
	}).
	then((response)=>response.json()).
	then((data)=>{
		c_name.innerText = "";
		c_email.innerText = "";
		c_phone.innerText = "";
		c_addr.innerText = "";
		alert(data.res);
		fetchClients();
	})
}
const removeClient = (c_id)=>{
	event.preventDefault();
	if(confirm("Do you really want to remove this client from your list?")==false) {
		return false;
	}
	fetch("apps/clientele.php?removeclient="+c_id,{
	}).
	then((response)=>response.json()).
	then((data)=>{
		alert(data.res);
		fetchClients();
	})
}
const searchClients=()=>{
	var term = searchForm.innerText.toLowerCase();
	var clientBody = document.getElementsByClassName("clientBody");
	if(clientBody.length == 0) {
		fetchClients();
	}
	for(i=0;i<clientBody.length;i++){
		//clientBody[i].style.display = "none";
		if(clientBody[i].innerHTML.toLowerCase().search(term) > -1){
			clientBody[i].style.display = "";
		}
		else{
			clientBody[i].style.display = "none";
			//clientBody[i].style.backgroundColor = "blue";
		}
		if(term.length < 2){
			clientBody[i].removeAttribute("style")
		}
	}
}

const newRow = (elem)=>{
	event.preventDefault();
	elem.innerHTML +="<li><span class='source' contenteditable='true' subtype='Source'></span> : ₦ <span class='amount' contenteditable='true' subtype='amount'></span><span class='source' filter onclick='delList(this)'>×</span></li>";
}

const delList = (elem)=>{
	elem.parentElement.remove();
}
setInterval(()=>{
	var ib = incomeBox.querySelectorAll("span");
	var ibArr = [];
	for(i=0;i<ib.length;i++){
		if(ib[i].className == "amount" && ib[i].innerText.length > 0){
			ibArr.push(ib[i].innerText);
		}
	}
	var sum = 0
	for(i=0;i<ibArr.length;i++){
		sum += parseInt(ibArr[i])
	}
	income.innerHTML = sum;
	
	var eb = expenseBox.querySelectorAll("span");
	var ebArr = [];
	for(i=0;i<eb.length;i++){
		if(eb[i].className == "amount" && eb[i].innerText.length > 0){
			ebArr.push(eb[i].innerText);
		}
	}
	var sume = 0
	for(i=0;i<ebArr.length;i++){
		sume += parseInt(ebArr[i])
	}
	expense.innerHTML = sume;
	
	var dob = parseInt(income.innerHTML) - parseInt(expense.innerHTML);
	var verd;
	if(dob <= 0){
		diff.style.border = "1px solid red";
		verd = "❗❗❗";
	}
	else{
		diff.style.border = "1px solid green";
		verd = "✔️";
		if(dob < (0.1 * parseInt(income.innerHTML))){
			verd = "⚠️less than 10% of your income...";
		}
	}
	diff.innerHTML = dob +" <small>"+ verd+"</small>"
},100)
const fetchBudgets = ()=>{
	event.preventDefault();
	viewContainer.innerHTML = "loading content...";
	//return false
	fetch("apps/budget.php?fetchbudget").
	then((response)=>response.json()).
	then((data)=>{
		//alert(data.res);
		viewContainer.innerHTML = data.res;
	})
}
const addBudget = ()=>{
	event.preventDefault();
	const formBody = new FormData();
	formBody.append("month_year",b_month.innerText);
	formBody.append("income",income.innerText);
	formBody.append("expenses",expense.innerText);
	bodyClone.innerHTML = b_body.innerHTML;
	var bChild = bodyClone.querySelectorAll("*");
	for(i=0;i<bChild.length;i++){
	  bChild[i].removeAttribute("class");
	  bChild[i].removeAttribute("id");
	  bChild[i].removeAttribute("onclick");
	  bChild[i].removeAttribute("contenteditable");
	  if(bChild[i].hasAttribute("filter")){
	    bChild[i].remove();
	  }
	}
	formBody.append("body",bodyClone.innerHTML);
	fetch("apps/budget.php?addbudget",{
		method: "POST",
		body: formBody
	}).
	then((response)=>response.json()).
	then((data)=>{
		/*b_month.innerText = "";
		income.innerText = "";
		expense.innerText = "";*/
		if(data.res.toLowerCase().search("added") > -1)
		b_body.parentElement.innerHTML= "Reload to Add Another";
		alert(data.res);
		fetchBudgets();
	})
}
const removeBudget = (b_id)=>{
	event.preventDefault();
	if(confirm("Do you really want to remove this budget from your list?")==false) {
		return false;
	}
	fetch("apps/budget.php?removebudget="+b_id,{
	}).
	then((response)=>response.json()).
	then((data)=>{
		alert(data.res);
		fetchClients();
	})
}
