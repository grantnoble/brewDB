function calc_og()
{
	var max_ppg = 0;
	var kgs = 0;
	var lbs = 0;
	var litres = document.forms[0].batch_size.value;
	var gallons = 0;
	var eff = document.forms[0].mash_efficiency.value / 100;
	var gravity_points = 0;
	var og = 0;
	var fg = 0;
	var atten = document.forms[0].yeast0_attenuation.value / 100;
	var abv = 0;
	var flag = 0;

	for (var i = 0; i < 15; i++)
	{
		if (document.forms[0]["fermentable"+i+"_name"].value)
		{
			max_ppg = document.forms[0]["fermentable"+i+"_yield"].value * .47;
			kgs = document.forms[0]["fermentable"+i+"_amount"].value;
			lbs = kgs * 2.20462;
			gallons = litres * 0.264172;
			gravity_points += max_ppg * eff * lbs / gallons;
			flag = 1;
		}
	}
	if (flag)
	{
		og = 1 + (gravity_points / 1000);
		document.forms[0].est_og.value = og.toFixed(3);
	}

	if (document.forms[0].yeast0_attenuation.value)
	{
		fg = 1 + ((gravity_points - (gravity_points * atten)) / 1000)
		document.forms[0].est_fg.value = fg.toFixed(3);
		abv = (og-fg) * 131;
		document.forms[0].est_abv.value = abv.toFixed(1);
	}
}
