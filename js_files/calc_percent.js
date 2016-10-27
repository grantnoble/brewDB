function calc_percent()
{
	var total_amount = 0;
	var percentage = 0;
	var flag = 0;
	
	// for each fermentable, if there is an amount, add it to the total amount
	for (var i = 0; i < 15; i++)
	{
		if (document.forms[0]["fermentable"+i+"_amount"].value)
		{
			// multiply the fermentable amount by 1 to ensure it is treated as a number, not a string
			total_amount += (document.forms[0]["fermentable"+i+"_amount"].value * 1);
			flag = 1;
		}
	}
	if (flag)
	{
		// for each fermentable, if there is an amount, calculate the percentage of the batch
		for (var i = 0; i < 15; i++)
		{
			if (document.forms[0]["fermentable"+i+"_amount"].value)
			{
				percentage = document.forms[0]["fermentable"+i+"_amount"].value / total_amount;
				document.forms[0]["fermentable"+i+"_percent"].value = (percentage * 100).toFixed(2);
			}
		}
	}
}
