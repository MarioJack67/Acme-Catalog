let pass = document.getElementById('pass');
let verify = document.getElementById('verify');
let createForm = document.getElementById('create-form');
let clear = document.getElementById('clear');
pass.addEventListener('keyup', validate);
verify.addEventListener('keyup', validate);
clear.addEventListener('click', newForm);

function newForm(event)
{
	form.reset();
	validate(event);
}
function validate(event)
{
	let number = document.getElementById('number');
	let eight = document.getElementById('eight');
	let match = document.getElementById('match');
	let create = document.getElementById('create');
	const numex = /\d/;
	const eightex = /^.{8,}$/;
	
	if(verify.value.trim().length == 0)
	{
		match.className = "blank";
		match.innerText = "";
	}
	else
	{
		if(pass.value == verify.value)
		{
			match.innerText = "Password and Verify match";
			match.className = "valid";
		}
		else
		{
			match.innerText = "Password and Verify do not match";
			match.className = "invalid";
		}
	}
	
	if(numex.test(pass.value))
	{
		number.className = "valid";
	}
	else
	{
		number.className = "invalid";
	}
	
	if(eightex.test(pass.value))
	{
		eight.className = "valid";
	}
	else
	{
		eight.className = "invalid";
	}
	
		
	if(number.className == "valid" && eight.className == "valid" && match.className == "valid")
	{
		create.disabled = false;
	}
	else
	{
		create.disabled = true;
	}
}