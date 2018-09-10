
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?> 

<table width="100%" class="ContentHdr">
  <tr>
    <td><strong> Back Office Config </strong></td>
  </tr>
</table>
 <?php if($this->session->flashdata('message')) { ?>
    <table width="100%" class="SuccessMsg">
            <tbody>
                  <tr>
              <td width="45"><img width="45" height="34" alt="" src="<?php  echo base_url(); ?>/static/images/icon-success.png"></td>
              <td width="95%"><?php echo $this->session->flashdata('message');?></td>
               </tr>
            </tbody>
                 </table>
            <?php } ?>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
   <form action="<?php echo base_url(); ?>light/updatebackofficeconfigdata?rid=17" method="post" name="tsearchform" id="tsearchform">
        <tr>
          <td>
            <table width="100%" cellpadding="10" cellspacing="10">
             
<?php if(isset($results)){ 
    $res = count($results);
    
    for($i=0;$i<$res;$i++) { ?>
             <tr>
             <td width="30%"><span class="TextFieldHdr"><?php echo ucfirst($results[$i]->KEY_NAME); ?> : </span><br/></td> 
             <td width="10%" style="align:left"><label><input type="text"  id="ID<?php echo $i; ?>" class="TextField" name="<?php echo $results[$i]->CONFIG_ID; ?>" value="<?PHP echo ucfirst($results[$i]->VALUE); ?>"></label><br/></td>
             <td width="60%">&nbsp;</td>
             </tr>
    <? }
   // echo "<pre>";print_r($results);
}
?>
            <tr>
              <td><input name="save" type="submit" class="button" id="button" value="Save" style="float:left;" /></td>
            </tr>
            
              
            </table>
          </td>
        </tr>
   </form>
</table>

</div>
</div>
 </div>
</div>
