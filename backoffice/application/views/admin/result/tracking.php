<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
<script>
 $(document).ready(function() {
    $('#example').DataTable({
		//"searching": false
	});
} ); 
</script>
<style>

.table .child:nth-child(odd)		{ background-color:rgb(0, 169, 169);     float: left;
    width: 100%;}
.table .child:nth-child(even)		{ background-color:rgb(0, 138, 138);    float: left;
    width: 100%; }


.heading-table {
    background: rgb(19, 88, 99);
    color: #fff;
    text-align: center;
}

</style>

<div class="form-style-2-heading">Tracking</div><p></p>

<div class ="table">
<?php  if(!empty( $tracking )) { ?>
	
	<table id="example" class="example" cellspacing="1" border="1" width="100%">
        <thead class="heading-table">
            <tr>
                <th>USERNAME</th>
                <th>ACTION NAME</th>
                <th>SYSTEM IP</th>
                <th class="info">INFO</th>
                <th>DATE</th>
            </tr>
        </thead>
  
        <tbody class="body-table">
			<?php foreach($tracking as $track ) { ?>
				<tr>
					<td><?php echo $track->USERNAME; ?></td>
					<td><?php echo $track->ACTION_NAME; ?></td>
					<td><?php echo $track->SYSTEM_IP; ?></td>
					<td><?php echo $track->CUSTOM1; ?></td>
					<td><?php echo $track->DATE_TIME; ?></td>
				</tr>
			<?php }exit; ?>
        </tbody>
    </table>
<?php } else {
			echo '<div class="child"> <h3 style="text-align:center;">No Data Found</h3> </div>';
	}?>

</div>