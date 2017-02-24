<div class="container">
		<div class="panel panel-success">
			<div class="panel-heading">info</div>
				<table class="table">
				<?php foreach($records as $data):?>
						<tr>
							<td><h4>ID: <?php echo $data->empid?></h4></td>
							
						</tr>

						<tr>
							<td><h4>Name: <?php echo $data->L_name.",".$data->F_name ?></h4></td>
							<td><h4>Date Employeed: <?php echo $data->date_applied?></h4></td>
							
						</tr>

						<tr>
							<td><h4>Position: <?php echo $data->position?></h4></td>
							
						</tr>
				<?php endforeach;?>
				</table>
		</div>
		
</div>
		<div class="panel panel-success">
			<div class="panel-heading">Payroll History</div>

				<table class="table table-bordered">
					
				<tr>
					<th>Date Period</th>
					<th>Basic Pay</th>
					<th>Days Worked</th>
					<th>Overtime Rate/Hrs</th>
					<th>OT Hours</th>
					<th>Allowance</th>
					<th>Gross Pay</th>
					<th>W/Tax</th>
					<th>Advances</th>
					<th>Insurance</th>
					<th>Total Deduction</th>
					<th>Net Pay</th>
					<?php if($position == 'Administrator'):?>
					<th>Print</th>
				    <?php endif;?>

				</tr>
				<?php if ($payrolls == null) {
					echo "<center><h3>No Payroll Record Found</h3></center>";
				} else {?>
					
				
				<?php 
					foreach($payrolls  as $pay):

					  $gross= ($pay->Pay * $pay->dayswork) + ($pay->otrate * $pay->othrs) + $pay->allow;


					  if ($gross>=50000)
					   $tax = $gross * .15;
					  if ($gross>=30000 && $gross <=49999)
					   $tax = $gross * .10;
					  if ($gross>=10000 && $gross <=29999)
					   $tax = $gross * .05;
					  if ($gross>=5000 && $gross <=9999)
					   $tax = $gross * .03;
					  if ($gross < 5000)
						$tax = 0;
						
					  $totdeduct = $tax + $pay->advance + $pay->insurance; 
					  $netpay = $gross - $totdeduct;
					  ?>

					  <tr>
					  	<td><?php echo $pay->date?></td>
					  	<td>Php <?php echo number_format($pay->Pay,2)?></td>
					  	<td><?php echo $pay->dayswork?>Days</td>
					  	<td>Php <?php echo number_format($pay->otrate,2)?> /hrs</td>
					  	<td><?php echo $pay->othrs?> hrs</td>
					  	<td>Php <?php echo number_format($pay->allow,2)?></td>
					  	<td>Php <?php echo number_format($gross,2)?></td>
					  	<td>Php <?php echo number_format($tax,2)?></td>
					  	<td>Php <?php echo number_format($pay->advance,2)?></td>
					  	<td>Php <?php echo number_format($pay->insurance,2)?></td>
					  	<td>Php <?php echo number_format($totdeduct,2)?></td>
					  	<td>Php <?php echo number_format($netpay,2)?></td>
					  	<?php if($position == 'Administrator'):?>
					  	<td><a href=""><i class="fa fa-cog fa-2x"></i></a></td>
					  	<?php endif;?>
					  </tr>
					  	
				
					  

				<?php endforeach;?>
				 <p style="float:right;"> Print: <a href="<?php echo base_url('print_pdf/payroll_pdf/'.$pay->account_id)?>">
					  <i class="fa fa-print fa-2x"></i></a></p>
				</table>
<?php }?>
		</div>		

	
