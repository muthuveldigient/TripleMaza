<table width="100%" id="rolesandPermissions" class="rolesandPermissions">
    <tr>
        <td class="mainRole" width="9%">Role Names</td>
        <td class="mainRole" width="5%">ALL</td>
        <td colspan="<?php echo $menuList['maxChild'];?>"></td>                                                                                 
    </tr>
    <tr>
        <td colspan="<?php echo $menuList['maxChild']+2?>">
            <table id="mytable" width="100%">
			<?php
                if(!empty($menuList['maxChild'])) {
                    $rowID=0;
                    foreach(array_slice($menuList, 1) as $mainRole) {
						if(in_array($mainRole['ROLE_ID'],$exitRole)) $mchk = 'checked="checked"'; else $mchk = '';
                        echo '<tr>';
                        echo '<td width="8%" class="mainRole">'.$mainRole['ROLE_NAME'].'</td>';
                        echo '<td><input type="checkbox" name="userRoles[]" id="RAP_'.$mainRole['ROLE_ID'].'" value="'.$mainRole['ROLE_ID'].'" '.$mchk.' class="parentCheckBox" /> ALL</td>';
                            
                        if($mainRole['ROLE_CHILD_CNT']>0) {
                            foreach($mainRole['ROLE_CHILD'] as $index=>$childRole) {	
								if(in_array($childRole->ROLE_ID,$exitRole)) $schk = 'checked="checked"'; else $schk = '';
                                echo '<td>';
                                echo '<input type="checkbox" name="userRoles[]" id="RAP_'.$childRole->ROLE_ID.'" value="'.$childRole->ROLE_ID.'" '.$schk.' class="childCheckBox" /> '.$childRole->ROLE_NAME;		
                                echo '</td>';
                            }
                        }
                        for($i=$mainRole['ROLE_CHILD_CNT'];$i<$menuList['maxChild'];$i++) {
                            echo '<td>&nbsp;</td>';	
                        }
                        echo '</tr>';	
                        $rowID++;										
                    }
                }
            ?>                                    
            </table>
        </td>
    </tr>
</table>