function validate_fermentables() 
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
			if (amount == null || amount == "")
			{
				error += "- Fermentable requires an amount\n";
			}
			if (yield == null || yield == "")
			{
				error += "- Fermentable requires a yield\n";
			}
			if (color == null || color == "")
			{
				error += "- Fermentable requires a color\n";
			}
		}
	}
    return error;
}
