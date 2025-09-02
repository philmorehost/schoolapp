
	<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
		
		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=fees_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'fees_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				FEES TYPE LIST
			</button>
		</a>
		<?php if(in_array(strip_tags($_GET['tab']),array("fees_list","add_fees_type"))){ ?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_fees_type&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_fees_type'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD FEES TYPE
			</button>
		</a>
		<?php } ?>
		<?php } ?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=fees_payment_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'fees_payment_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				FEES PAYMENT LIST
			</button>
		</a>
		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<?php if(in_array(strip_tags($_GET['tab']),array("fees_payment_list","add_fees_payment"))){ ?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_fees_payment&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_fees_payment'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD FEES PAYMENT
			</button>
		</a>
		<?php } ?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=fees_payment_type&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'fees_payment_type'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				FEES PAYMENT TYPE
			</button>
		</a>
		<?php } ?>
		<?php
    		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
		?>
		<?php if(in_array(strip_tags($_GET['tab']),array("view_payment_invoice"))){ ?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=view_payment_invoice&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'view_payment_invoice'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				VIEW PAYMENT INVOICE
			</button>
		</a>
		<?php } ?>
		<?php } ?>
	</div>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
	<?php if(strip_tags($_GET['tab']) == "fees_list"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth)) > 0){
			$count_fee_list_listed = mysqli_num_rows($select_all_fee_list_table_lists);
    ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
		<div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
			<?php
				if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
			?>
        	<form method="post">
        		<div class="form-group-borderless mobile-width-20 system-width-7 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
        			<select onchange="pageListNumber();" id="page_list_number" class="form-select">
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 10){ echo "selected"; } ?> value="10">10</option>
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 25){ echo "selected"; } ?> value="25">25</option>
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 50){ echo "selected"; } ?> value="50">50</option>
						<option <?php if(trim(strip_tags($_GET["pnum"])) == 100){ echo "selected"; } ?> value="100">100</option>
        			</select>
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_fee_list_listed; ?> entries</span>
        	
        		<div class="form-group-borderless mobile-width-85 system-width-50 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-14 mobile-margin-right-2 system-margin-right-1">
        			<input name="search-item" value="<?php echo $search_text; ?>" type="text" placeholder="Search... " class="form-input" />
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
           	</form>
           	<?php } ?>
           	<form method="post" enctype="multipart/form-data">
           		<table class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
           			<tr>
           				<td>Tick</td>
           				<td class="mobile-width-10 system-width-10">Fee</td>
           				<td>Fees Title</td>
           				<td>Class Name</td>
           				<td>Session</td>
						<td>Fees Amount</td>
           				<td>Description</td>
           				<td style="width:10%;">Action</td>
           			</tr>
					<?php
					
						function feeClassName($class_info,$session_info,$school_id){
							global $connection_server;
							
							$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
							if(mysqli_num_rows($get_class_name) == 1){
								while($class_name_array = mysqli_fetch_array($get_class_name)){
									$class_name .= $class_name_array["class_name"];
								}
							}else{
								$class_name = "N/A";
							}
							
							return $class_name;
						}
						
						function feeTypeName($fee_info,$school_id){
							global $connection_server;
							
							$get_fee_name = mysqli_query($connection_server,"SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$fee_info'");
							if(mysqli_num_rows($get_fee_name) == 1){
								while($fee_name_array = mysqli_fetch_array($get_fee_name)){
									$fee_name .= $fee_name_array["fee_name"];
								}
							}else{
								$fee_name = "N/A";
							}
							
							return $fee_name;
						}
						
						if(mysqli_num_rows($select_all_fee_list_table_lists) > 0){
							while(($fee_list_details = mysqli_fetch_assoc($select_fee_list_table_lists))){
								$fee_list_view_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=add_fees_type',$_SERVER['REQUEST_URI'])."&view=".$fee_list_details["fee_id"];
								$fee_list_edit_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=add_fees_type',$_SERVER['REQUEST_URI'])."&edit=".$fee_list_details["fee_id"];
								
								echo '<tr>
									<td>
										<input type="checkbox" name="fee_id[]" value="'.$fee_list_details["fee_id"].'" class="feeListChecked" />
										<input hidden type="text" name="school_id[]" value="'.$fee_list_details["school_id_number"].'" />
									</td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Payment.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.feeTypeName($fee_list_details["fee_type_id"], $fee_list_details["school_id_number"]).' ( '.$fee_list_details["fee_type_id"].' )</td>
           							<td>'.feeClassName($fee_list_details["numeric_class_name"], $fee_list_details["session"], $fee_list_details["school_id_number"]).' ( '.$fee_list_details["numeric_class_name"].' )</td>
           							<td>'.str_replace("-","/",$fee_list_details["session"]).'</td>
									<td>'.$fee_list_details["amount"].'</td>
           							<td>'.checkIfEmpty($fee_list_details["description"]).'</td>
									<td>
										<img onclick="return popUpAlert([``,``,`'.$fee_list_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
									</td>
									</tr>';
							}
						}
					?>
           		</table>
				   
           		<div style="float: right;" class="container-box bg-3 mobile-width-100 system-width-22">
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$prev_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Previous
						</button>
					</a>
					<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-right-8 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
						<?php echo $current_page_no; ?>
					</button>
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$next_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Next
						</button>
					</a>
				</div>
           		<button type="button" onclick="checkALL();" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			<input type="checkbox" onclick="checkALL();" class="checkALL" value="2" />
           			SELECT ALL
           		</button>
           		<a style="cursor: pointer;" onclick="deleteItems();">
           			<img src="imgfile/Delete.png" style="position: relative; height: 2.6rem; margin: 0 0 -14px 0; pointer-events: none;" class="mobile-width-12 system-width-5" />
           		</a>
				<button name="delete-fee-list" type="submit" id="delfeeList" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete fee List
           		</button><br>
			</form>
		</div>
		</center>
		
		<script>
			function pageListNumber(){
				var pageListNo = document.getElementById("page_list_number");
				if((pageListNo.value > 0) && (pageListNo.value != "")){
					window.location.href = '<?php echo $page_list_number_link; ?>'+pageListNo.value;
				}
			}

			function checkALL(){
				var allBoxToChecked = document.getElementsByClassName("feeListChecked");
				if(document.getElementsByClassName("feeListChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("feeListChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("feeListChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("feeListChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this Record?")){
						document.getElementById("delfeeList").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Record");
						if(confirm("Are you sure you want to delete this Record?")){
							document.getElementById("delfeeList").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Record");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'fees_payment_type'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$get_flutterwave_fees_gateway_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_fees_payment_gateway WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && gateway_name='flutterwave')"));
			?>
			<form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    PAYMENT INFORMATION
                </div>
				
				<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    Flutterwave Gateway
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="flutterwave-public-key" value="<?php echo $get_flutterwave_fees_gateway_detail['public_key']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Public Key*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="flutterwave-secret-key" value="<?php echo $get_flutterwave_fees_gateway_detail['secret_key']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Secret Key*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="flutterwave-encrypt-key" value="<?php echo $get_flutterwave_fees_gateway_detail['encrypt_key']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Encrypt Key*</span>
                </div>
                
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="" value="<?php if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')){ echo 'https://'.$_SERVER['HTTP_HOST'].'/include/pay/flutterwave.php'; }else{ echo 'http://'.$_SERVER['HTTP_HOST'].'/include/pay/flutterwave.php';} ?>" type="text" placeholder="" class="form-input" readonly />
                    <span class="form-span mobile-font-size-12 system-font-size-14">Webhook</span>
                </div>
				
				<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<input name="enable-flutterwave" type="checkbox" value="1" <?php if($get_flutterwave_fees_gateway_detail['status'] === '1'){ echo 'checked'; } ?> placeholder="" class="form-input" />
					Flutterwave <?php if($get_flutterwave_fees_gateway_detail['status'] === '1'){ echo '<span style="color: green;">Enabled</span>'; }else{ echo '<span style="color: red;">Disabled</span>'; } ?>
                </div>

				<button name="update-payment" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    SAVE PAYMENT DETAILS
				</button>
				
            </form>
        </center>
    </div>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_fees_type'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_fee_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && fee_id='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_fee_list_checkmate) == 1)){
					if(mysqli_num_rows($edit_fee_list_checkmate) == 1){
						$edit_fee_list_detail = mysqli_fetch_array($edit_fee_list_checkmate);
						
						$edit_fee_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<form method="post" enctype="multipart/form-data">
			<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
				<div class="form-group mobile-width-90 system-width-35 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="fee-type" id="select-fee-type-id" class="form-select" required>
						<option disabled hidden selected value="">Select Fee Type</option>
						<?php
							$select_fee_type_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_fee_type WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
							
							if(mysqli_num_rows($select_fee_type_detail_using_id) > 0){
								while($fee_type_details = mysqli_fetch_assoc($select_fee_type_detail_using_id)){
									if($fee_type_details["id_number"] == $edit_fee_list_detail['fee_type_id']){
										$selected = "selected";
										echo '<option value="'.$fee_type_details["id_number"].'" '.$selected.'>'.$fee_type_details["fee_name"].'</option>';
									}else{
										echo '<option value="'.$fee_type_details["id_number"].'">'.$fee_type_details["fee_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Fee Type*</span>
				</div>
				
				<?php $sch_id_numb = $get_logged_user_details["school_id_number"]; ?>
				<button onclick="largePopUp(`Add Fee Type`,`Fee Type Name*`,`ADD`,`select-fee-type-id`,`sm_fee_type`,`school_id_number='<?php echo $sch_id_numb; ?>' && id_number='null'`,`fee_name`);" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-6 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD
				</button>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findFeeTypeClassSession();" id="find-fee-type-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
							
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_name"] == $edit_fee_list_detail['numeric_class_name']){
										$selected = "selected";
										echo '<option value="'.$classes_details["numeric_class_name"].'" '.$selected.'>'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}else{
										echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class-session" id="add-fee-type-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							if((mysqli_num_rows($edit_fee_list_checkmate) == 1)){
								$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_fee_list_detail['numeric_class_name']."'");
								
								if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
									while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
										if($sessions_details["session"] == $edit_fee_list_detail['session']){
											$selected = "selected";
											echo '<option value="'.$sessions_details["session"].'" '.$selected.'>'.str_replace("-","/",$sessions_details["session"]).'</option>';
										}else{
											echo '<option value="'.$sessions_details["session"].'" >'.str_replace("-","/",$sessions_details["session"]).'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
				</div>
				
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="amount" value="<?php echo $edit_fee_list_detail['amount']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Fees Amount*</span>
                </div>

				<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<input name="desc" value="<?php echo $edit_fee_list_detail['description']; ?>" type="text" placeholder="" class="form-input" />
                    <span class="form-span mobile-font-size-12 system-font-size-14">Description</span>
                </div>
				
				<input hidden id="fee-type-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_fee_list_checkmate) < 1)){ ?>
                <button name="create-fee-type" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    CREATE FEE TYPE
				</button>
				<?php }else{ ?>
				<button name="update-fee-type" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE FEE TYPE
				</button>
				<?php } ?>
				
            </form>
			<script>
				function findFeeTypeClassSession(){
					const find_fee_type_class_session = document.getElementById("find-fee-type-class-session");
					const add_fee_type_class_session = document.getElementById("add-fee-type-class-session");
					const fee_type_school_id_number = document.getElementById("fee-type-school-id");

					add_fee_type_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_fee_type_class_session.add(createSelectSessionOption);

					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: fee_type_school_id_number.value, class_id_no: find_fee_type_class_session.value});

					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_fee_type_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
				}
			</script>
        </center>
    </div>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'fees_payment_list'){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_admission_id_statement_auth)) > 0){
			$count_fee_payment_list_listed = mysqli_num_rows($select_all_fee_payment_list_table_lists);
    ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
		<div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
			<?php
				if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
			?>
        	<form method="post">
        		<div class="form-group-borderless mobile-width-20 system-width-7 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
        			<select onchange="pageListNumber();" id="page_list_number" class="form-select">
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 10){ echo "selected"; } ?> value="10">10</option>
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 25){ echo "selected"; } ?> value="25">25</option>
        				<option <?php if(trim(strip_tags($_GET["pnum"])) == 50){ echo "selected"; } ?> value="50">50</option>
						<option <?php if(trim(strip_tags($_GET["pnum"])) == 100){ echo "selected"; } ?> value="100">100</option>
        			</select>
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_fee_payment_list_listed; ?> entries</span>
        	
        		<div class="form-group-borderless mobile-width-85 system-width-50 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-14 mobile-margin-right-2 system-margin-right-1">
        			<input name="search-item" value="<?php echo $search_text; ?>" type="text" placeholder="Search... " class="form-input" />
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
           	</form>
           	<?php } ?>
           	<form method="post" enctype="multipart/form-data">
           		<table class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
           			<tr>
					   	<?php
							if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
						?>
						<td>Tick</td>
						<?php } ?>
           				<td class="mobile-width-10 system-width-10">Fee</td>
						<td>Receipt No</td>
						<td>Status</td>
           				<td>Student Name</td>
           				<td>Class Name</td>
						<td>Fee Type</td>
           				<td>Session</td>
						<td>Amount</td>
						<td>Starting Date</td>
						<td>Ending Date</td>
           				<td>Description</td>
						<td style="width:10%;">Action</td>
           			</tr>
					<?php
					
						function feeStudentName($student_info,$school_id){
							global $connection_server;
							
							$get_student_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_info'");
							if(mysqli_num_rows($get_student_name) == 1){
								while($student_name_array = mysqli_fetch_array($get_student_name)){
									$student_name .= $student_name_array["firstname"]." ".$student_name_array["lastname"]." ".$student_name_array["othername"];
								}
							}else{
								$student_name = "N/A";
							}
							
							return $student_name;
						}

						function feeClassName($class_info,$session_info,$school_id){
							global $connection_server;
							
							$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
							if(mysqli_num_rows($get_class_name) == 1){
								while($class_name_array = mysqli_fetch_array($get_class_name)){
									$class_name .= $class_name_array["class_name"];
								}
							}else{
								$class_name = "N/A";
							}
							
							return $class_name;
						}
						
						function feeTypeName($fee_info,$school_id){
							global $connection_server;
							
							$get_fee_name = mysqli_query($connection_server,"SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$fee_info'");
							if(mysqli_num_rows($get_fee_name) == 1){
								while($fee_name_array = mysqli_fetch_array($get_fee_name)){
									$fee_name .= $fee_name_array["fee_name"];
								}
							}else{
								$fee_name = "N/A";
							}
							
							return $fee_name;
						}

						function feeRefNumber($online_ref, $manual_ref){
							global $connection_server;
							
							if(!empty($online_ref) || !empty($manual_ref)){
								if(!empty($online_ref)){
									$fee_name .= $online_ref;
								}

								if(!empty($manual_ref)){
									$fee_name .= $manual_ref;
								}
							}else{
								$fee_name = "N/A";
							}
							
							return $fee_name;
						}
						
						/*function feeTypeAmount($fee_info, $class_info, $session_info, $school_id){
							global $connection_server;
							
							$get_fee_amount = mysqli_query($connection_server,"SELECT * FROM sm_fee_lists WHERE school_id_number='$school_id' && fee_type_id='$fee_info' && numeric_class_name='$class_info' && session='$session_info'");
							if(mysqli_num_rows($get_fee_amount) == 1){
								while($fee_amount_array = mysqli_fetch_array($get_fee_amount)){
									$fee_amount .= $fee_amount_array["amount"];
								}
							}else{
								$fee_amount = "N/A";
							}
							
							return $fee_amount;
						}*/

						if(mysqli_num_rows($select_all_fee_payment_list_table_lists) > 0){
							while(($fee_payment_list_details = mysqli_fetch_assoc($select_fee_payment_list_table_lists))){
								$fee_payment_list_view_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=view_payment_invoice',$_SERVER['REQUEST_URI'])."&view=".$fee_payment_list_details["fee_payment_id"];
								$fee_payment_list_edit_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=add_fees_payment',$_SERVER['REQUEST_URI'])."&edit=".$fee_payment_list_details["fee_payment_id"];
								
								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="fee_payment_id[]" value="'.$fee_payment_list_details["fee_payment_id"].'" class="feeListChecked" />
														<input hidden type="text" name="school_id[]" value="'.$fee_payment_list_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([`'.$fee_payment_list_view_link.'`,``,`'.$fee_payment_list_edit_link.'`,``],[`View Invoice`,``,`Edit Invoice`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}else{
									$action_button = '<td>
														<img onclick="return popUpAlert([`'.$fee_payment_list_view_link.'`,``,``,``],[`View Invoice`,``,``,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}

								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Payment.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.feeRefNumber($fee_payment_list_details["online_ref"], $fee_payment_list_details["manual_ref"]).'</td>
									<td>'.ucwords($fee_payment_list_details["status"]).'</td>
									<td>'.feeStudentName($fee_payment_list_details["admission_number"], $fee_payment_list_details["school_id_number"]).'</td>
           							<td>'.feeClassName($fee_payment_list_details["numeric_class_name"], $fee_payment_list_details["session"], $fee_payment_list_details["school_id_number"]).'</td>
           							<td>'.feeTypeName($fee_payment_list_details["fee_type_id"], $fee_payment_list_details["school_id_number"]).'</td>
           							<td>'.str_replace("-","/",$fee_payment_list_details["session"]).'</td>
									<td>'.$fee_payment_list_details["amount_paid"].'</td>
									<td>'.$fee_payment_list_details["starting_year"].'</td>
									<td>'.($fee_payment_list_details["starting_year"]+$fee_payment_list_details["ending_year"]).'</td>
           							<td>'.checkIfEmpty($fee_payment_list_details["description"]).'</td>
									'.$action_button.'
									</tr>';
							}
						}
					?>
           		</table>
				   
           		<div style="float: right;" class="container-box bg-3 mobile-width-100 system-width-22">
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$prev_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Previous
						</button>
					</a>
					<button type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-8 mobile-padding-right-5 system-padding-right-8 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
						<?php echo $current_page_no; ?>
					</button>
					<a style="text-decoration: none;" href="<?php echo $page_prevnext_link.'&prevnext='.$next_btn; ?>">
						<button type="button" class="button-box color-7 bg-6 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-5 mobile-padding-right-5 system-padding-right-5 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Next
						</button>
					</a>
				</div>
				<?php
					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
				?>
           		<button type="button" onclick="checkALL();" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			<input type="checkbox" onclick="checkALL();" class="checkALL" value="2" />
           			SELECT ALL
           		</button>
           		<a style="cursor: pointer;" onclick="deleteItems();">
           			<img src="imgfile/Delete.png" style="position: relative; height: 2.6rem; margin: 0 0 -14px 0; pointer-events: none;" class="mobile-width-12 system-width-5" />
           		</a>
				<button name="delete-fee-payment-list" type="submit" id="delfeePaymentList" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete fee List
           		</button><br>
				<?php } ?>
			</form>
		</div>
		</center>
		
		<script>
			function pageListNumber(){
				var pageListNo = document.getElementById("page_list_number");
				if((pageListNo.value > 0) && (pageListNo.value != "")){
					window.location.href = '<?php echo $page_list_number_link; ?>'+pageListNo.value;
				}
			}

			function checkALL(){
				var allBoxToChecked = document.getElementsByClassName("feeListChecked");
				if(document.getElementsByClassName("feeListChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("feeListChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("feeListChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("feeListChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this Record?")){
						document.getElementById("delfeePaymentList").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Record");
						if(confirm("Are you sure you want to delete this Record?")){
							document.getElementById("delfeePaymentList").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Record");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_fees_payment'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
		<?php
				$edit_fee_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && fee_payment_id='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_fee_list_checkmate) == 1)){
					if(mysqli_num_rows($edit_fee_list_checkmate) == 1){
						$edit_fee_list_detail = mysqli_fetch_array($edit_fee_list_checkmate);
						
						$edit_fee_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_fee_list_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findfeefeeClassSession(); feeClassSession();" id="find-fee-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
							
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_name"] == $edit_fee_list_detail['numeric_class_name']){
										$selected = "selected";
										echo '<option value="'.$classes_details["numeric_class_name"].'" '.$selected.'>'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}else{
										echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class-session" onchange="findClassSessionStudent(); feeClassSession();" id="add-fee-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							if((mysqli_num_rows($edit_fee_list_checkmate) == 1)){
								$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_fee_list_detail['numeric_class_name']."'");
								
								if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
									while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
										if($sessions_details["session"] == $edit_fee_list_detail['session']){
											$selected = "selected";
											echo '<option value="'.$sessions_details["session"].'" '.$selected.'>'.str_replace("-","/",$sessions_details["session"]).'</option>';
										}else{
											echo '<option value="'.$sessions_details["session"].'" >'.str_replace("-","/",$sessions_details["session"]).'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<?php
						if(isset($edit_fee_list_detail['admission_number']) && (!empty(trim($edit_fee_list_detail['admission_number'])))){
							$fee_list_admission_no_required = " required";
						}
					?>
					
					<select name="student-roll-number" id="student-roll-id" class="form-select" required>
						<option disabled hidden selected value="">Select Student</option>
						<?php
							if((mysqli_num_rows($edit_fee_list_checkmate) == 1)){
								$select_students_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_fee_list_detail['numeric_class_name']."' && session='".$edit_fee_list_detail['session']."'");
								
								if(mysqli_num_rows($select_students_detail_using_id) > 0){
									while($students_details = mysqli_fetch_assoc($select_students_detail_using_id)){
										$select_students_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && admission_number='".$students_details['admission_number']."' LIMIT 1"));

										if($students_details["admission_number"] == $edit_fee_list_detail['admission_number']){
											$selected = "selected";
											echo '<option value="'.$students_details["admission_number"].'" '.$selected.'>'.$select_students_details["firstname"].' '.$select_students_details["lastname"].' '.$select_students_details["othername"].'</option>';
										}else{
											echo '<option value="'.$students_details["admission_number"].'" >'.$select_students_details["firstname"].' '.$select_students_details["lastname"].' '.$select_students_details["othername"].'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Student*</span>
					<?php if(!isset($edit_fee_list_detail['admission_number']) && (empty(trim($edit_fee_list_detail['admission_number'])))){ ?>
					<div style="float: left; clear: left; text-align: left;" class="form-group mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-16 text-bold-lighter mobile-margin-top-1 system-margin-top-1 mobile-margin-bottom-0 system-margin-bottom-0 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						Note : Please select a student to generate invoice for the single student or it will create the invoice for all students for selected class and section. Click to switch <button type="button" id="toggle-single-multiple" onclick="toggleSingleMultipleStudent();" style="outline: none; border: 1px outset var(--color-5); color: var(--color-7); cursor: pointer;">Single Student</button>
					</div>
					<?php } ?>
				</div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="fee-type" id="select-fee-type-id" onchange="schoolFeeAmount();" class="form-select" required>
						<option disabled hidden selected value="">Select Fee Type</option>
						<?php

							function feeTypeName($fee_info,$school_id){
								global $connection_server;
								
								$get_fee_name = mysqli_query($connection_server,"SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$fee_info'");
								if(mysqli_num_rows($get_fee_name) == 1){
									while($fee_name_array = mysqli_fetch_array($get_fee_name)){
										$fee_name .= $fee_name_array["fee_name"];
									}
								}else{
									$fee_name = "N/A";
								}
								
								return $fee_name;
							}

							function feeClassName($class_info,$session_info,$school_id){
								global $connection_server;
								
								$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
								if(mysqli_num_rows($get_class_name) == 1){
									while($class_name_array = mysqli_fetch_array($get_class_name)){
										$class_name .= $class_name_array["class_name"];
									}
								}else{
									$class_name = "N/A";
								}
								
								return $class_name;
							}

							$select_fee_type_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth);
				
							if(mysqli_num_rows($select_fee_type_detail_using_id) > 0){
								while($fee_type_details = mysqli_fetch_assoc($select_fee_type_detail_using_id)){
									if($fee_type_details["fee_type_id"] == $edit_fee_list_detail['fee_type_id']){
										$selected = "selected";
										echo '<option hidden value="'.$fee_type_details["fee_type_id"].' '.$fee_type_details["amount"].' '.$fee_type_details["numeric_class_name"].' '.$fee_type_details["session"].'" '.$selected.'>'.feeTypeName($fee_type_details["fee_type_id"], $fee_type_details["school_id_number"]).' ('.feeClassName($fee_type_details["numeric_class_name"], $fee_type_details["session"], $fee_type_details["school_id_number"]).')</option>';
									}else{
										echo '<option hidden value="'.$fee_type_details["fee_type_id"].' '.$fee_type_details["amount"].' '.$fee_type_details["numeric_class_name"].' '.$fee_type_details["session"].'">'.feeTypeName($fee_type_details["fee_type_id"], $fee_type_details["school_id_number"]).' ('.feeClassName($fee_type_details["numeric_class_name"], $fee_type_details["session"], $fee_type_details["school_id_number"]).')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Fee Type*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="amount" id="select-fee-type-amount-id" type="text" pattern="[0-9]{1,}" placeholder="" class="form-input" readonly required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Fee Amount*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="amount-paid" id="select-fee-type-amount-paid-id" type="text" pattern="[0-9]{1,}" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Amount Paid*</span>
                </div>

				<script>

					function feeClassSession(){
						const find_fee_class_session = document.getElementById("find-fee-class-session");
						const add_fee_class_session = document.getElementById("add-fee-class-session");
						const select_fee_type_id = document.getElementById("select-fee-type-id");
						const select_fee_type_amount_id = document.getElementById("select-fee-type-amount-id");
						const select_fee_type_amount_paid_id = document.getElementById("select-fee-type-amount-paid-id");
						
						for(x=0; x<select_fee_type_id.options.length; x++){
							if(select_fee_type_id.options[x].value != ""){
								select_fee_type_id.options[x].hidden = true;
								if(find_fee_class_session.value === select_fee_type_id.options[x].value.split(" ")[2].trim()){
									if(add_fee_class_session.value === select_fee_type_id.options[x].value.split(" ")[3].trim()){
										select_fee_type_id.options[x].hidden = false;
									}else{
										select_fee_type_id.options[x].hidden = true;
									}
								}else{
									select_fee_type_id.options[x].hidden = true;
								}
							}
						}
						
					}

					function schoolFeeAmount(){
						const select_fee_type_id = document.getElementById("select-fee-type-id");
						const select_fee_type_amount_id = document.getElementById("select-fee-type-amount-id");
						const select_fee_type_amount_paid_id = document.getElementById("select-fee-type-amount-paid-id");
						
						select_fee_type_amount_id.value = select_fee_type_id.value.split(" ")[1].trim();
						select_fee_type_amount_paid_id.value = select_fee_type_id.value.split(" ")[1].trim();
						
						
					}

					feeClassSession();
					schoolFeeAmount();
					
					function toggleSingleMultipleStudent(){
						const toggleBtn = document.getElementById("toggle-single-multiple");
						const student_roll_id = document.getElementById("student-roll-id");
						if(student_roll_id.required == true){
							student_roll_id.required = false;
							toggleBtn.innerHTML = "Multiple Student";
						}else{
							student_roll_id.required = true;
							toggleBtn.innerHTML = "Single Student";
						}
						
					}
				</script>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="starting-year" class="form-select" required>
						<option disabled hidden selected value="">Select Starting Year</option>
						<?php
							foreach(range(date("Y"),(date("Y")-9)) as $year){
								if($year == $edit_fee_list_detail["starting_year"]){
									echo '<option selected value="'.$year.'">'.$year.'</option>';
								}else{
									echo '<option value="'.$year.'">'.$year.'</option>';
								}
							}
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Starting Year*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="ending-year" class="form-select" required>
						<option disabled hidden selected value="">Select Ending Year</option>
						<?php
							foreach(range(1,1) as $year){
								if($year == $edit_fee_list_detail["ending_year"]){
									echo '<option selected value="'.$year.'">'.$year.'</option>';
								}else{
									echo '<option value="'.$year.'">'.$year.'</option>';
								}
							}
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Ending Year*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="status" class="form-select" required>
						<option disabled hidden selected value="">Select Status</option>
						<?php
							foreach(array("full paid","part paid","unpaid") as $status){
								if($status == $edit_fee_list_detail["status"]){
									echo '<option selected value="'.$status.'">'.ucwords($status).'</option>';
								}else{
									echo '<option value="'.$status.'">'.ucwords($status).'</option>';
								}
							}
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Status*</span>
				</div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="desc" value="<?php echo $edit_fee_list_detail['description']; ?>" type="text" placeholder="" class="form-input"/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Description</span>
                </div>
				 
                <input hidden id="fee-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_fee_list_checkmate) < 1)){ ?>
                <button name="create-invoice" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    CREATE INVOICE
				</button>
				<?php }else{ ?>
				<button name="update-invoice" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE INVOICE
				</button>
				<?php } ?>
            </form>
            
			<script>
				function findfeefeeClassSession(){
					const find_fee_class_session = document.getElementById("find-fee-class-session");
					const add_fee_class_session = document.getElementById("add-fee-class-session");
					const fee_school_id_number = document.getElementById("fee-school-id");

					add_fee_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_fee_class_session.add(createSelectSessionOption);

					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: fee_school_id_number.value, class_id_no: find_fee_class_session.value});

					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_fee_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					findClassSessionStudent();
				}

				function findClassSessionStudent(){
					const find_fee_class_session = document.getElementById("find-fee-class-session");
					const add_fee_class_session = document.getElementById("add-fee-class-session");
					const student_roll_id = document.getElementById("student-roll-id");
					
					const fee_school_id_number = document.getElementById("fee-school-id");

					student_roll_id.innerHTML = "";
					const createSelectStudentOption = document.createElement("option");
					createSelectStudentOption.hidden = true;
					createSelectStudentOption.disabled = true;
					createSelectStudentOption.selected = true;
					createSelectStudentOption.text = "Select Student";
					createSelectStudentOption.value = "";
					student_roll_id.add(createSelectStudentOption);

					const classSessionStudentHttpRequest = new XMLHttpRequest();
					classSessionStudentHttpRequest.open("POST","./get-student.php");
					classSessionStudentHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionStudentHttpRequestBody = JSON.stringify({sch_no: fee_school_id_number.value, class_id_no: find_fee_class_session.value, session: add_fee_class_session.value});
					classSessionStudentHttpRequest.onload = function(){
						if((classSessionStudentHttpRequest.readyState == 4) && (classSessionStudentHttpRequest.status == 200)){
							
							const student_list_array = Object.entries(JSON.parse(classSessionStudentHttpRequest.responseText)["response"]);
							
							for(i=0; i < student_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = student_list_array[i][1];
								createSelectOption.value = student_list_array[i][0];
								student_roll_id.add(createSelectOption);
							}
						}else{
							alert(classSessionStudentHttpRequest.status);
						}
					}
					classSessionStudentHttpRequest.send(classSessionStudentHttpRequestBody);
				}

			</script>
            <?php } ?>
        </center>
    </div>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'view_payment_invoice'){
	$view_school_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	$view_student_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && fee_payment_id='".trim(strip_tags($_GET['view']))."' ".$user_admission_id_statement_auth);
	//$view_admin_staff_first_moderator = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE email='".trim(strip_tags($_GET['view']))."' LIMIT 1");
	
	if((mysqli_num_rows($view_school_checkmate) == 1) && (mysqli_num_rows($view_student_checkmate) == 1)){
		$view_school_detail = mysqli_fetch_array($view_school_checkmate);
		$view_student_detail = mysqli_fetch_array($view_student_checkmate);
		$view_student_parent_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".$view_student_detail["parent_id_number"]."'");
		$view_student_parent_detail = mysqli_fetch_array($view_student_parent_checkmate);

		$student_view_edit_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".$header_add_button.$additional_add_tag."&edit=".$view_student_detail["admission_number"];

		function receiptStudentName($student_info,$school_id){
			global $connection_server;
			
			$get_student_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_info'");
			if(mysqli_num_rows($get_student_name) == 1){
				while($student_name_array = mysqli_fetch_array($get_student_name)){
					$student_name .= $student_name_array["firstname"]." ".$student_name_array["lastname"]." ".$student_name_array["othername"];
				}
			}else{
				$student_name = "N/A";
			}
			
			return $student_name;
		}

		function receiptClassName($class_info,$session_info,$school_id){
			global $connection_server;
			
			$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
			if(mysqli_num_rows($get_class_name) == 1){
				while($class_name_array = mysqli_fetch_array($get_class_name)){
					$class_name .= $class_name_array["class_name"];
				}
			}else{
				$class_name = "N/A";
			}
			
			return $class_name;
		}

		function feeTypeName($fee_info,$school_id){
			global $connection_server;
			
			$get_fee_name = mysqli_query($connection_server,"SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$fee_info'");
			if(mysqli_num_rows($get_fee_name) == 1){
				while($fee_name_array = mysqli_fetch_array($get_fee_name)){
					$fee_name .= $fee_name_array["fee_name"];
				}
			}else{
				$fee_name = "N/A";
			}
			
			return $fee_name;
		}

		function feeRefNumber($online_ref, $manual_ref){
			global $connection_server;
			
			if(!empty($online_ref) || !empty($manual_ref)){
				if(!empty($online_ref)){
					$fee_name .= $online_ref;
				}

				if(!empty($manual_ref)){
					$fee_name .= $manual_ref;
				}
			}else{
				$fee_name = "N/A";
			}
			
			return $fee_name;
		}

		function feePaymentMode($online_ref, $manual_ref){
			global $connection_server;
			
			if(!empty($online_ref) || !empty($manual_ref)){
				if(!empty($online_ref)){
					$fee_name .= "Online Checkout";
				}

				if(!empty($manual_ref)){
					$fee_name .= "Manual";
				}
			}else{
				$fee_name = "N/A";
			}
			
			return $fee_name;
		}

?>
    <div id="printDiv" class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<div style="border:1px solid var(--color-4); " class="container-box bg-2 mobile-width-96 system-width-70 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
				<div style="border:1px solid var(--color-4v); text-align: left;" class="container-box bg-3 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="display: block; text-align: center;" class="container-box bg-3 mobile-width-100 system-width-100">
						<?php if(file_exists("dataimg/school_".$get_logged_user_details['school_id_number'].".png")){ ?>
							<img style="display: inline-block;" class="mobile-width-15 system-width-10" src="dataimg/school_<?php echo $get_logged_user_details['school_id_number']; ?>.png" /><br>
						<?php }else{ ?>
							<img style="display: inline-block;" class="" src="imgfile/logo.png" /><br>
						<?php } ?>
					
						<div style="display: inline-block;" class="container-box bg-3 mobile-width-80 system-width-80">
							<!-- Name -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-17 system-font-size-25"><?php echo $view_school_detail["school_name"]; ?></span><br>
							<span style="display: inline-block;" class="color-1 mobile-font-size-17 system-font-size-25"><?php echo $view_school_detail["school_address"].", ".$view_school_detail["city"]." ".$view_school_detail["state"]; ?></span><br>
							
							<!-- Title -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-15 system-font-size-18"><?php echo str_replace("-","/",$view_student_detail ["session"]); ?> Academic Session <?php echo feeTypeName($view_student_detail ["fee_type_id"], $view_student_detail ["school_id_number"]); ?> Receipt</span>
						
						</div>
					</div>
				</div>
				<div style="border:1px solid var(--color-4v);" class="container-box bg-3 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="border:1px solid var(--color-4); text-align: left; display: flex; flex-direction: row;" id="student-detail-container" class="container-box bg-3 mobile-width-100 system-width-90 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
						<div style="display: inline-block;" class="container-box bg-3 mobile-width-75 system-width-80 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Title Name -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Full-Name</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Full-Name -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo receiptStudentName($view_student_detail ["admission_number"], $view_student_detail ["school_id_number"]); ?></span>
							
							</div><br>

							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Title Name -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Student ID</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Matric No -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16">ST/<?php echo $view_student_detail ["school_id_number"]; ?>/<?php echo $view_student_detail ["admission_number"]; ?></span>
							
							</div><br>
							
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Class Name -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Class</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Class-Name -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo receiptClassName($view_student_detail ["numeric_class_name"], $view_student_detail ["session"], $view_student_detail ["school_id_number"]); ?></span>
							
							</div><br>
							
							<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Session -->
								<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Session</span>
							
							</div>
							<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: ;" class="container-box bg-3 mobile-width-72 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
								<!-- Session -->
								<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo str_replace("-","/",$view_student_detail ["session"]); ?></span>
							
							</div>
						</div>

						<div style="display: inline-block; text-align: center;" id="student-passport-container" class="container-box bg-3 mobile-width-24 system-width-19 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
															
							<?php if(file_exists("dataimg/student_".$get_logged_user_details['school_id_number']."_".$view_student_detail ["admission_number"].".png")){ ?>
							<img style="display: inline-block; object-fit: cover; height: 0px; margin: 0; padding: 0;" id="student-passport" class="mobile-margin-top-0 system-margin-top-0" src="dataimg/student_<?php echo $get_logged_user_details['school_id_number'].'_'.$view_student_detail ["admission_number"]; ?>.png" /><br>
							<?php }else{ ?>
							<img style="display: inline-block; object-fit: cover; height: 0px; margin: 0; padding: 0;" id="student-passport" class="mobile-margin-top-0 system-margin-top-0" src="imgfile/Student.png" /><br>
							<?php } ?>
							</fieldset>
						</div>
					</div>
				</div>
				<div style="border:1px solid var(--color-4);" class="container-box bg-3 mobile-width-95 system-width-85 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="border:1px solid var(--color-3); text-align: left;" class="container-box bg-3 mobile-width-95 system-width-95 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
						<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><span class="text-bold-600">Receipt Ref</span>: <?php echo feeRefNumber($view_student_detail ["online_ref"], $view_student_detail ["manual_ref"]); ?></span><br>
						<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><span class="text-bold-600">Payment Mode</span>: <?php echo feePaymentMode($view_student_detail ["online_ref"], $view_student_detail ["manual_ref"]); ?></span><br>
						
						<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><span class="text-bold-600">Payment Date</span>: <?php echo formDate($view_student_detail ["date"]); ?></span><br>
						
					</div>
				</div>
				<div style="border:1px solid var(--color-4v);" class="container-box bg-3 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
					<div style="display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-90 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-0 system-padding-top-0 mobile-padding-bottom-0 system-padding-bottom-0">
						<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Title Name -->
							<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Year: </span>
						
						</div>
						<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: left;" class="container-box bg-3 mobile-width-73 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Matric No -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo $view_student_detail ["starting_year"]; ?> till <?php echo ($view_student_detail ["starting_year"]+$view_student_detail ["ending_year"]); ?></span>
						
						</div><br>

						<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Title Name -->
							<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Initial Amount: </span>
						
						</div>
						<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: left;" class="container-box bg-3 mobile-width-73 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Matric No -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo $view_student_detail ["amount"]; ?></span>
						
						</div><br>

						<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Title Name -->
							<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Amount Paid: </span>
						
						</div>
						<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: left;" class="container-box bg-3 mobile-width-73 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Matric No -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo $view_student_detail ["amount_paid"]; ?></span>
						
						</div><br>

						<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Title Name -->
							<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Outstanding Payment: </span>
						
						</div>
						<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: left;" class="container-box bg-3 mobile-width-73 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Matric No -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo str_replace("-","",($view_student_detail ["amount"] - $view_student_detail ["amount_paid"])); ?></span>
						
						</div><br>

						<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Title Name -->
							<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Payment Status: </span>
						
						</div>
						<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: left;" class="container-box bg-3 mobile-width-73 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Matric No -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo ucwords($view_student_detail ["status"]); ?></span>
						
						</div><br>

						<div style="display: inline-block; border-width: 0 0 1px 0; border-style: none none solid none; border-color: transparent transparent var(--color-4) transparent; text-align: center;" class="container-box bg-4 mobile-width-25 system-width-25 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Title Name -->
							<span style="display: inline-block;" margin: 0; class="color-2 mobile-font-size-14 system-font-size-16 text-bold-600">Being Payment For: </span>
						
						</div>
						<div style="display: inline-block; border-width: 0 1px 1px 0; border-style: none solid solid none; border-color: transparent var(--color-4) var(--color-4) transparent; text-align: left;" class="container-box bg-3 mobile-width-73 system-width-73 mobile-margin-top-0 system-margin-top-0 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
							<!-- Matric No -->
							<span style="display: inline-block;" class="color-1 mobile-font-size-14 system-font-size-16"><?php echo str_replace("-","/",$view_student_detail ["session"]); ?> Academic Session <?php echo feeTypeName($view_student_detail ["fee_type_id"], $view_student_detail ["school_id_number"]); ?> Charges</span>
						
						</div><br>
					</div>

				</div>
				
			</div>
			
		</center>
	</div><br>
	<center>
		<span style="display: inline-block; text-decoration: underline; cursor: pointer;" class="color-4 mobile-font-size-14 system-font-size-16" onclick="printPage();">Print Receipt</span>
						
		<script>
		
			//Receipt & Result Image set
				setInterval(function(){
					const studentPassport = document.getElementById("student-passport");
					studentPassport.style.height = "0px";
					const studentDetailContainerHeight = document.getElementById("student-detail-container").clientHeight;
					if(studentDetailContainerHeight != studentPassport.clientHeight){
						studentPassport.style.width = "80%";
						studentPassport.style.height = (studentDetailContainerHeight*(100/100))+"px";
					}
				},1000);
				
			function printPage(){
	
				var receiptDiv = document.getElementById("printDiv").innerHTML;
				const html = [];
				html.push('<html><head>');
				html.push('<link rel="stylesheet" href="cssfile/portal.css">');
				html.push('</head><body onload="window.focus(); window.print()"><div>');
				html.push(receiptDiv);
				html.push('</div></body></html>');
				
				var mywindow = window.open('', '', 'width=640,height=480');
				mywindow.document.open("text/html");
				mywindow.document.write(html.join(""));
				mywindow.document.close();
				
			}

			window.addEventListener('keydown', function(e){
				if(e.ctrlKey && e.keyCode == 80){
					e.preventDefault();
					printPage();
				}
			});
		</script>
	</center>
<?php
		}
	}

?>
<?php } ?>