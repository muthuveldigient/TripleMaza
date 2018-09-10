<?php
	if($paymentID!=3) {
?>
    <select name="promotype" id="promotype">
        <option value="">-- Select Promo Type --</option>
        <option value="1">BONUS</option>
    </select>
<?php } else { ?>
    <select name="promotype" id="promotype">
        <option value="">-- Select Promo Type --</option>
        <option value="1">DEPOSITS</option>    
    </select>
<?php } ?>