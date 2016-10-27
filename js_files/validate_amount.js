function validate_amount() 
{
	var i;
	var error = "";

	for (i=0; i<=14; i++)
	{
		var name = document.forms[0]["fermentable"+i+"_name"].value;
		var amount = document.forms[0]["fermentable"+i+"_amount"].value;
		var yield = document.forms[0]["fermentable"+i+"_yield"].value;
		var color = document.forms[0]["fermentable"+i+"_color"].value;

		if (name)
		{
			document.forms[0]["fermentable"+i+"_amount"].setCustomValidity("Amount must not be zero.");
		}
	}
    return;
}
