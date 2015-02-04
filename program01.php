<!DOCTYPE HTML>
<html id="">
<head>
   <meta name="author" content="David Hughen" />
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
   <link href="style01.css" rel="stylesheet" type="text/css" />
   <title>Work hours</title>
</head>
<body id="php_body">

<?php
// Author: David Hughen
// Date:   February 4, 2015
// Course: CS 368 - Advanced Web Programming
// This php program processes a html form by taking its input
// and calculating the net pay and tithe for the user's salary.

// Defined constants
define('REGULAR_HOURS', 40);
define('OVERTIME_RATE', 1.5);
define('SOCIAL_SECURITY', .062);
define('MEDICARE', .0145);
define('BASE_FED_TAX', 99.10);
define('FED_TAX_CAP', 764.00);
define('FED_TAX_RATE', .25);
define('TITHE', .10);  
?>
   <h1>Your net pay and tithe.</h1>
   
	<?php
		
		if($hoursWorked = $_POST['hours_worked'] == NULL)
		{
			$hoursWorked = "<h1>Didn't enter in hours worked.</h1>";
			$newString   = filter_var($hoursWorked, FILTER_SANITIZE_STRING);
		}
		else
			$hoursWorked = $_POST['hours_worked'];
		
		if($payRate = $_POST['pay_rate'] == NULL)
		{
			$payRate = "";
		}
		else
		{
			$payRate = $_POST['pay_rate'];
		}
			
		$overtime = 0;
		if ($hoursWorked > REGULAR_HOURS)
		{	
			// Set the amount of overtime
			$overtime = $hoursWorked - REGULAR_HOURS;
			
			// Subtract overtime hours from total hours
			$hoursWorked -= $overtime;
		}
		$totalPay = $payRate * $hoursWorked + ($overtime * OVERTIME_RATE);
		
		$federalTax = BASE_FED_TAX;
		
		if($totalPay > FED_TAX_CAP)
		{
			$federalTax += FED_TAX_RATE * $totalPay;
		}
		
		// Calculate all taxes
		$totalTaxes = ($totalPay * SOCIAL_SECURITY) + ($totalPay * MEDICARE) + $federalTax;
		$titheTotal = $totalPay * TITHE;
		$netPay = $totalPay - $totalTaxes - $titheTotal;	
	?>	 
			<div class="divPayTable">
			<table style="width:100%" id="payTable" class="payTable" border="1">
				<tr>
					<td>Hours Worked:</td>
					<td><?php echo $hoursWorked; ?></td> 
				</tr>
				<tr>
					<td>Pay Rate:</td>
					<td><?php
							if($payRate == NULL)
							{
								echo "<h1>Pay rate not entered</h1>";
							}
							else
								echo "$ " .number_format($payRate, 2, '.', ',');
						?>
					</td>
				</tr>
				<tr>
					<td>Total Pay:</td>
				    <td><?php echo "$ " .number_format($totalPay, 2, '.', ',');?></td>
			    </tr>
				<tr>
					<td>Overtime Pay:</td>
					<td><?php echo "$ " .number_format($overtime * OVERTIME_RATE, 2, '.', ',');?></td>
			    </tr>
				<tr>
					<td>Social Security:</td>
					<td><?php echo "$ " .number_format($totalPay * SOCIAL_SECURITY, 2, '.', ',');?></td>
				</tr>
				<tr>
					<td>Medicare:</td>
					<td><?php echo "$ " .number_format($totalPay * MEDICARE, 2, '.', ',');?></td>
				</tr>
				<tr>
					<td>Federal Tax:</td>
					<td><?php echo "$ " .number_format($federalTax, 2, '.', ',');?></td>
				</tr>
				<tr>
					<td>Tithes:</td>
					<td><?php echo "$ " .number_format($titheTotal, 2, '.', ',');?></td>
				</tr>
				<tr>
					<td>Net Pay:</td>
					<td><?php echo "$ " .number_format($netPay, 2, '.', ',');?></td>
				</tr>
			</table>
			</div>
		</body>
</html>