function validate_miscs() 
{
	var i;
	var error = "";

	for (i=0; i<=3; i++)
	{
		var name = document.forms[0]["misc"+i+"_name"].value;
		var amount = document.forms[0]["misc"+i+"_amount"].value;
		var unit = document.forms[0]["misc"+i+"_unit"].value;

		if (name)
		{
			if (amount == null || amount == "")
			{
				error += "- Misc ingredient requires an amount\n";
			}
			if (unit == null || unit == "")
			{
				error += "- Misc ingredient requires a unit\n";
			}
		}
	}
    return error;
}
