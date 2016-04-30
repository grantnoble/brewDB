function validate_form() 
{
	var message = "";
	message += validate_details();
	message += validate_fermentables();
	message += validate_hops();
	message += validate_miscs();
	if (message != "")
	{
		alert("The form has the following errors:\n" + message);
		return false;
	}
}
