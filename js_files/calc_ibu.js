function calc_ibu()
{
   var gms = 0;
   var aa = 0;
	var t = 0;
	var aau = 0;
	var f_G = 0;
	var f_T = 0;
	var ibu = 0;
	var og = document.forms[0].est_og.value;
   var oglitres = document.forms[0].batch_size.value;

	// boil converson factor used to calculate the starting boil volume
	var boilconversion = 1.3;
	var bglitres = oglitres * boilconversion;

	// calculate the boil gravity
	var bg = 1 + ((og - 1) * oglitres / bglitres);
	var e = Math.E;
	var flag = 0;

	/* for each hop, ibu is calculated as aau * U * 10 / oglitres, where:
	 * aau is alpha acid units
	 * U is utilisation
	 * oglitres is batch size
	 *
	 * Utilisation is a function of boil gravity and time:
	 * f_G = 1.65 * 0.000125^(bg-1)
	 * f_T = [1-e^(-0.04 * t)]/4.15
	 * U = f_G * f_T
	 */
	for (var i = 0; i < 15; i++)
	{
		// if there is an og and a hop amount and a hop alpha and a hop time, calculate the ibu for that row, otherwise try the next row
		if (document.forms[0].est_og.value && document.forms[0]["hop"+i+"_amount"].value && document.forms[0]["hop"+i+"_alpha"].value && document.forms[0]["hop"+i+"_time"].value)
		{
			// retrieve the amount, alpha acid rating, and boil time for the hop
			gms = document.forms[0]["hop"+i+"_amount"].value;
			aa = document.forms[0]["hop"+i+"_alpha"].value;
			t = document.forms[0]["hop"+i+"_time"].value;

			// calculate the alpha acid units for the hop
			aau = aa * gms;

			// calculate utilisation as a function of gravity
			f_G = 1.65 * Math.pow(0.000125,(bg - 1));

			// calculate utilisation as a function of time
			f_T = (1 - Math.pow(e,(-0.04 * t))) / 4.15;

			// calculate overall utilisation for gravity and time
			U = f_G * f_T;

			// increment the total ibus for the recipe
			ibu += aau * U * 10 / oglitres;

			// set a flag to say that at least one hop ibu value was calculated
			flag = 1;
		}
	}
	// if a hop ibu value exists, display it
	if (flag)
	{
		document.forms[0].est_ibu.value = ibu.toFixed(0);
	}
}
