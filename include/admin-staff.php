<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
			$count_admin_staff_listed = mysqli_num_rows($select_all_admin_staff_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_admin_staff_listed; ?> entries</span>
        	
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
           				<td class="mobile-width-10 system-width-10">Photo</td>
                        <td>Full Name</td>
           				<td>Phone Number</td>
						<td>Gender</td>
						<td>Date of Birth</td>
           				<td style="width:10%;">Action</td>
           			</tr>
					<?php
						if(mysqli_num_rows($select_all_admin_staff_table_lists) > 0){
							while(($admin_staff_details = mysqli_fetch_assoc($select_admin_staff_table_lists))){
								$admin_staff_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$admin_staff_details["id_number"];
								$admin_staff_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$admin_staff_details["id_number"];
								if(file_exists("dataimg/adminstaff_".$admin_staff_details["school_id_number"]."_".$admin_staff_details["id_number"].".png")){
									$admin_staff_img = "dataimg/adminstaff_".$admin_staff_details["school_id_number"]."_".$admin_staff_details["id_number"].".png";
								}else{
									$admin_staff_img = 'imgfile/admin-staff.png';
								}
								/*$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE email='".$_SESSION["mod_adm_session"]."'"));
								$registered_classes = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && section='".$section_details["section"]."')");
								if(mysqli_num_rows($registered_classes) > 0){
									$count_registered_classes = mysqli_num_rows($registered_classes);
								}else{
									$count_registered_classes = "N/A";
								}*/
								echo '<tr>
									<td>
										<input type="checkbox" name="admin_staff_id[]" value="'.$admin_staff_details["id_number"].'" class="classChecked" />
										<input hidden type="text" name="school_id[]" value="'.$admin_staff_details["school_id_number"].'" />
									</td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%;" src="'.$admin_staff_img.'" class="mobile-width-100 system-width-50 avatar_icon_height" /></td>
									<td>'.$admin_staff_details["lastname"].' '.$admin_staff_details["firstname"].'<br><span class="color-5">'.$admin_staff_details["email"].'</span></td>
                                    <td>'.$admin_staff_details["phone_number"].'</td>
									<td>'.Ucwords($admin_staff_details["gender"]).'</td>
									<td>'.str_replace("-","/",$admin_staff_details["dob"]).'</td>
           							<td>
										<img onclick="return popUpAlert([`'.$admin_staff_view_link.'`,``,`'.$admin_staff_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
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
				<button name="delete-admin-staff" type="submit" id="delAdminStaff" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Admin Staff
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
				var allBoxToChecked = document.getElementsByClassName("classChecked");
				if(document.getElementsByClassName("classChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("classChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("classChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("classChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this Admin Staff?")){
						document.getElementById("delAdminStaff").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Admin Staff");
						if(confirm("Are you sure you want to delete this Admin Staff?")){
							document.getElementById("delAdminStaff").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Admin Staff");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data.php"); } ?>
<?php } ?>


<?php if(strip_tags($_GET['tab']) == 'add_admin_staff'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_admin_staff_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_admin_staff_checkmate) == 1)){
					if(mysqli_num_rows($edit_admin_staff_checkmate) == 1){
						$edit_admin_staff_detail = mysqli_fetch_array($edit_admin_staff_checkmate);
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_admin_staff_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    PERSONAL INFORMATION
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="last" type="text" value="<?php echo $edit_admin_staff_detail['lastname']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Surname*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="first" type="text" value="<?php echo $edit_admin_staff_detail['firstname']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">First Name*</span>
                </div>

                

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="gender" class="form-select" required>
						<option disabled hidden selected value="">Select Gender</option>
						<option value="male" <?php if($edit_admin_staff_detail['gender'] == "male"){ echo 'selected'; } ?>>Male</option>
                        <option value="female" <?php if($edit_admin_staff_detail['gender'] == "female"){ echo 'selected'; } ?>>Female</option>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Gender*</span>
				</div>
				
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="dob" type="date" value="<?php echo $edit_admin_staff_detail['dob']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Date Of Birth*</span>
                </div>

                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    CONTACT INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="address" type="text" value="<?php echo $edit_admin_staff_detail['home_address']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Address*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="city" type="text" value="<?php echo $edit_admin_staff_detail['city']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">City*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="state" type="text" value="<?php echo $edit_admin_staff_detail['state']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">State*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="country" class="form-select" required>
						<option disabled hidden selected value="">Select Country</option>
						<?php
							foreach (array_values($countries_with_currencies) as $country_name) {
								// Check if the country matches the country in PHP itself
								$selected = (strtolower(trim($edit_admin_staff_detail['country'])) == strtolower(trim($country_name))) ? 'selected' : '';
								echo '<option value="' . htmlspecialchars($country_name, ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($country_name, ENT_QUOTES) . '</option>';
							}
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Country*</span>
				</div>
				
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="phone" type="text" pattern="[0-9]{13}" title="Phone number include Country Code without (+)" value="<?php echo $edit_admin_staff_detail['phone_number']; ?>"  placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Phone Number*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="marital" class="form-select" required>
						<option disabled hidden selected value="">Select Marital Status</option>
						<option value="single" <?php if($edit_admin_staff_detail['marital_status'] == "single"){ echo 'selected'; } ?>>Single</option>
                        <option value="married" <?php if($edit_admin_staff_detail['marital_status'] == "married"){ echo 'selected'; } ?>>Married</option>
                        <option value="divorced" <?php if($edit_admin_staff_detail['marital_status'] == "divorced"){ echo 'selected'; } ?>>Divorced</option>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Marital Status*</span>
				</div>

                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    LOGIN INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="email" type="email" value="<?php echo $edit_admin_staff_detail['email']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="password" type="password" pattern="[a-zA-Z0-9]{8,}" title="Password must be Alphanumeric and not less than 8 character (No Special Character)" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Password*</span>
                </div>

                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    PROFILE IMAGE
                </div>

                <div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
				    <input name="photo" type="file" class="form-file-chooser"/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Image</span>
                </div><br>

				<?php if(file_exists("dataimg/adminstaff_".$edit_admin_staff_detail['school_id_number']."_".$edit_admin_staff_detail['id_number'].".png")){ ?>
				 <img style="float: left; clear: left;" src="<?php echo 'dataimg/adminstaff_'.$edit_admin_staff_detail['school_id_number'].'_'.$edit_admin_staff_detail['id_number'].'.png'; ?>" class="mobile-width-30 system-width-15 mobile-margin-left-5 system-margin-left-3" /><br>
				 <?php }else{ ?>
                <img style="float: left; clear: left;" src="imgfile/admin-staff.png" class="mobile-width-30 system-width-15 mobile-margin-left-5 system-margin-left-3" /><br>
				<?php } ?>
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_admin_staff_checkmate) < 1)){ ?>
				<button name="add-admin-staff" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD ADMIN STAFF
				</button>
				<?php }else{ ?>
				<button name="update-admin-staff" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					UPDATE ADMIN STAFF
				</button>
				<?php } ?>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 

<?php if(strip_tags($_GET['tab']) == 'view_admin_staff'){
	$view_admin_staff_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".trim(strip_tags($_GET['view']))."'");
	$view_admin_staff_first_moderator = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".trim(strip_tags($_GET['view']))."' LIMIT 1");
	
	if((mysqli_num_rows($view_admin_staff_checkmate) == 1) && (((isset($_SESSION["mod_adm_session"]))))){
		$view_admin_staff_detail = mysqli_fetch_array($view_admin_staff_checkmate);
		$admin_staff_view_edit_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".$header_add_button.$additional_add_tag."&edit=".$view_admin_staff_detail["id_number"];

?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<div style="height: 7.5rem;" class="container-box bg-4 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1">
				
				<?php if(file_exists("dataimg/adminstaff_".$view_admin_staff_detail['school_id_number']."_".$view_admin_staff_detail['id_number'].".png")){ ?>
					<img style="border-style: solid; float: left; clear: left;" src="dataimg/adminstaff_<?php echo $view_admin_staff_detail['school_id_number'].'_'.$view_admin_staff_detail['id_number']; ?>.png" class="bg-2 box-shadow border-radius-30px border-color-2 border-width-6 mobile-width-12 system-width-12 mobile-margin-top-6 system-margin-top-3 mobile-margin-left-5 system-margin-left-3" />
				<?php }else{ ?>
					<img style="border-style: solid; float: left; clear: left;" src="imgfile/admin-staff.png" class="bg-2 box-shadow border-radius-30px border-color-2 border-width-6 mobile-width-12 system-width-12 mobile-margin-top-6 system-margin-top-3 mobile-margin-left-5 system-margin-left-3" />
				<?php } ?>

				<img style="float: right; clear: right;" src="imgfile/Group.png" class="bg-3 mobile-width-0 system-width-12 mobile-margin-top-0 system-margin-top-4 mobile-margin-right-1 system-margin-right-1" />	
				<div style="text-align: left; display: inline-block; height: 7.5rem;" class="container-box bg-3 mobile-width-78 system-width-69 mobile-margin-top-4 system-margin-top-3 mobile-margin-left-1 system-margin-left-0">
					<!-- Name -->
					<span style="display: inline-block;" class="color-2 mobile-font-size-17 system-font-size-25"><?php echo $view_admin_staff_detail["lastname"]." ".$view_admin_staff_detail["firstname"]; ?></span>
					<a href="<?php echo $admin_staff_view_edit_link; ?>" style="text-decoration: none;">
						<img style="margin-bottom: -1%;" src="imgfile/edit.png" class="mobile-width-8 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-1 system-margin-left-1" /><br/>
					</a>

					<!-- Phone -->
					<img style="margin-bottom: -0.5%;" src="imgfile/phone.png" class="mobile-width-6 system-width-3 mobile-margin-top-3 system-margin-top-3 mobile-margin-right-0 system-margin-right-0" />
					<span style="display: inline-block;" class="color-2 mobile-font-size-14 system-font-size-16 mobile-margin-left-0 system-margin-left-0"><?php echo $view_admin_staff_detail["phone_number"]; ?></span><br/>
				
					<!-- City -->
					<img style="margin-bottom: -0.5%;" src="imgfile/location.png" class="mobile-width-6 system-width-2 mobile-margin-top-3 system-margin-top-3 mobile-margin-right-1 system-margin-right-1" />
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-16 mobile-margin-left-0 system-margin-left-0"><?php echo $view_admin_staff_detail["city"]; ?></span>
				</div>
			</div>
			<div style="" class="container-box bg-3 mobile-width-90 system-width-96 mobile-margin-top-10 system-margin-top-8">
				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Email ID</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_admin_staff_detail["email"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Login Username</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo "AS/".$view_admin_staff_detail["school_id_number"]."/".$view_admin_staff_detail["id_number"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-17 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Mobile Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_admin_staff_detail["phone_number"]; ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Gender</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_admin_staff_detail["gender"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Date of Birth</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo str_replace("-","/",$view_admin_staff_detail["dob"]); ?></span>
				</div>
			</div>
			<div style="text-align: left; border-style: solid;" class="container-box border-color-5 border-width-1 bg-3 mobile-width-90 system-width-94 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-1 mobile-padding-right-2 system-padding-right-1 mobile-padding-bottom-3 system-padding-bottom-2">
				<span style="display: inline-block;" class="color-5 mobile-font-size-16 system-font-size-17">Contact Information</span><br>
				
                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Marital Status</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_admin_staff_detail["marital_status"]); ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">City</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_admin_staff_detail["city"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">State</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_admin_staff_detail["state"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Country</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_admin_staff_detail["country"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-100 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Home Address</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_admin_staff_detail["home_address"]; ?></span>
				</div>
			</div>
		</center>
	</div>
<?php
		}
	}
	
?>
<?php } ?>