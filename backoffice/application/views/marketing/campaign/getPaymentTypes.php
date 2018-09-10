<?php
	if($campaignID!=1) {
?>
    <select name="paymenttype" id="paymenttype">
        <option value="">-- Select Payment Type --</option>
        <option value="1">Fixed</option>
    </select>
<?php } else { ?>
    <select name="paymenttype" id="paymenttype">
        <option value="">-- Select Payment Type --</option>
        <option value="1">Fixed</option>
        <option value="2">Percentage(%)</option>        
    </select>
<?php } ?>