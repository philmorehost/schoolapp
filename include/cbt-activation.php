<?php if(isset($_SESSION["sup_adm_session"])){ ?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_school_details")) > 0){
			$count_school_listed = mysqli_num_rows($select_all_school_table_lists);
    ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
		<div style="text-align: left;" class="scroll-box bg-2 mobile-width-96 system-width-96">
		
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_school_listed; ?> entries</span>
        	
        		<div class="form-group-borderless mobile-width-85 system-width-50 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-14 mobile-margin-right-2 system-margin-right-1">
        			<input name="search-item" value="<?php echo $search_text; ?>" type="text" placeholder="Search... " class="form-input" />
        			<span class="form-span mobile-font-size-12 system-font-size-14"></span>
        		</div>
           	</form>
           	<form method="post" enctype="multipart/form-data">
           		<input type="number" id="school-id" name="school-id" hidden readonly required/>
           		<input type="number" id="activation-id" name="activation-id" hidden readonly required/>
           		<button type="submit" id="activation-btn" name="activation-btn" hidden> CBT Activation</button>
           		
           		<table style="width: 100%;" class="table-tag-borderless mobile-font-size-12 system-font-size-14 mobile-margin-left-3 system-margin-left-2">
           			<tr>
           				<td>Tick</td>
           				<td class="mobile-width-10 system-width-10">School</td>
           				<td class="mobile-width-20 system-width-auto"></td>
           				<td>Status</td>
           				<td>Action</td>
           			</tr>
					<?php
						if(mysqli_num_rows($select_all_school_table_lists) > 0){
							while($school_details = mysqli_fetch_assoc($select_school_table_lists)){
								$school_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$school_details["school_id_number"];
								$school_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$school_details["school_id_number"];
								if(file_exists("dataimg/school_".$school_details["school_id_number"].".png")){
									$school_img = "dataimg/school_".$school_details["school_id_number"].".png";
								}else{
									$school_img = 'imgfile/Student_Future.png';
								}
								
								$checkmate_activated_cbt_schools = mysqli_query($connection_server, "SELECT * FROM sm_cbt_activated_schools WHERE school_id_number='".$school_details["school_id_number"]."'");
								if(mysqli_num_rows($checkmate_activated_cbt_schools) == 1){
									$school_cbt_status = "Activated";
									$cbt_activation_button = '<span style="cursor: pointer; text-decoration: underline;" onclick="cbtActivation(`'.$school_details["school_name"].'`, `'.$school_details["school_id_number"].'`, `2`);">Disable</span>';
								}else{
									$school_cbt_status = "Not Activated";
									$cbt_activation_button = '<span style="cursor: pointer; text-decoration: underline;" onclick="cbtActivation(`'.$school_details["school_name"].'`, `'.$school_details["school_id_number"].'`, `1`);">Enable</span>';
								}
								
								echo '<tr>
									<td><input type="checkbox" name="school_id[]" value="'.$school_img.'" class="classChecked" /></td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%;" src="'.$school_img.'" class="mobile-width-100 system-width-50 avatar_icon_height" /></td>
									<td>'.$school_details["school_name"].'<br><span class="color-5">'.$school_details["email"].'</span></td>
									<td>'.$school_cbt_status.'</td>
									<td>'.$cbt_activation_button.'</td>
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
				<button name="delete-school" type="submit" id="delSchool" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete School
           		</button><br>
			</form>
		</div>
		</center>
		
		<script>
			function cbtActivation(schoolName, schoolId, activationType) {
				const schoolIdInput = document.getElementById("school-id");
				const activationIdInput = document.getElementById("activation-id");
				const activationBtn = document.getElementById("activation-btn");
				
				const activationArr = {1:"Enable", 2:"Disable"};
				if(confirm("Are You Sure You Want To " + activationArr[activationType] + " " + schoolName + " CBT Portal?")){
					schoolIdInput.value = schoolId;
					activationIdInput.value = activationType;
					activationBtn.click();
				}else{
					alert("Operation cancelled");
				}
			}
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
					if(confirm("Are you sure you want to delete this school?")){
						document.getElementById("delSchool").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one School");
						if(confirm("Are you sure you want to delete this school?")){
							document.getElementById("delSchool").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one School");
					}
				}
					
			}
			
		</script>
	</div>
    <?php }else{ include("include/no-data.php"); } ?>
<?php } ?>
<?php if(strip_tags($_GET['tab']) == 'add_school'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_school_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".trim(strip_tags($_GET['edit']))."'");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_school_checkmate) == 1)){
					if(mysqli_num_rows($edit_school_checkmate) == 1){
						$edit_school_detail = mysqli_fetch_array($edit_school_checkmate);
						$edit_school_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_school_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>

                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    SCHOOL INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<?php if(file_exists("dataimg/school_".$edit_school_detail['school_phone_number'].".png")){ ?>
						<input name="photo" type="file" class="form-file-chooser" />
					<?php }else{ ?>
						<input name="photo" type="file" class="form-file-chooser" required/>
					<?php } ?>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Logo</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="name" value="<?php echo $edit_school_detail['school_name']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="motto" value="<?php echo $edit_school_detail['school_motto']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Motto*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="address" value="<?php echo $edit_school_detail['school_address']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Address*</span>
                </div>
	
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    SCHOOL ADMIN INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="mod-first" value="<?php echo $edit_school_moderator_detail['firstname']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">First Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="mod-last" value="<?php echo $edit_school_moderator_detail['lastname']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Last Name*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                	<input name="mod-phone" value="<?php echo $edit_school_moderator_detail['phone_number']; ?>" type="text" pattern="[0-9]{13}" title="Phone number include Country Code without (+)" placeholder="" class="form-input" required/>
                	<span class="form-span mobile-font-size-12 system-font-size-14">Phone Number*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <select name="mod-gender" class="form-select" required>
                        <option disabled hidden selected value="">Select Gender</option>
                        <option value="male" <?php if($edit_school_moderator_detail['gender'] == "male"){ echo 'selected'; } ?>>Male</option>
                        <option value="female" <?php if($edit_school_moderator_detail['gender'] == "female"){ echo 'selected'; } ?>>Female</option>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Gender*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <select name="mod-marital" class="form-select" required>
                        <option disabled hidden selected value="">Select Status</option>
                        <option value="single" <?php if($edit_school_moderator_detail['marital_status'] == "single"){ echo 'selected'; } ?>>Single</option>
                        <option value="married" <?php if($edit_school_moderator_detail['marital_status'] == "married"){ echo 'selected'; } ?>>Married</option>
                        <option value="divorced" <?php if($edit_school_moderator_detail['marital_status'] == "single"){ echo 'divorced'; } ?>>Divorced</option>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Marital Status*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="mod-city" value="<?php echo $edit_school_moderator_detail['city']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">City*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="mod-state" value="<?php echo $edit_school_moderator_detail['state']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">State*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <select name="mod-country" class="form-select" required>
                        <option disabled hidden selected value="">Select Country</option>
                        <?php
							foreach (array_values($countries_with_currencies) as $country_name) {
								// Check if the country matches the country in PHP itself
								$selected = (strtolower(trim($edit_school_moderator_detail['country'])) == strtolower(trim($country_name))) ? 'selected' : '';
								echo '<option value="' . htmlspecialchars($country_name, ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($country_name, ENT_QUOTES) . '</option>';
							}
						?>
					</select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Country Located*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                	<input name="mod-home-address" value="<?php echo $edit_school_moderator_detail['home_address']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Home Address*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                	<input name="mod-office-address" value="<?php echo $edit_school_moderator_detail['office_address']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Office Address*</span>
                </div>
                
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    LOGIN INFORMATION
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="mod-email" value="<?php echo $edit_school_moderator_detail['email']; ?>" type="email" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Email Address*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
               	    <input name="mod-pass" type="password" pattern="[a-zA-Z0-9]{8,}" title="Password must be Alphanumeric and not less than 8 character (No Special Character)" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Password*</span>
                </div>
                
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_school_checkmate) < 1)){ ?>
                <button style="float: left; clear: both;" name="create-school" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    CREATE SCHOOL
				</button>
				<?php }else{ ?>
					<?php if(file_exists("dataimg/school_".$edit_school_detail["school_id_number"].".png")){ ?>
						<img style="float: left; clear: both;" src="dataimg/school_<?php echo $edit_school_detail["school_id_number"]; ?>.png" class="mobile-width-30 system-width-10 mobile-margin-left-5 system-margin-left-3"/><br>
					<?php }else{ ?>
						<img style="float: left; clear: both;" src="imgfile/Student_Future.png" class="mobile-width-30 system-width-10 mobile-margin-left-5 system-margin-left-3"/><br>
					<?php } ?>
				<button style="float: left; clear: both;" name="update-school" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE SCHOOL
				</button>
				<?php } ?>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php if(strip_tags($_GET['tab']) == 'view_school'){
	$view_school_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".trim(strip_tags($_GET['view']))."'");
	$view_school_first_moderator = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['view']))."' LIMIT 1");
	
	if((mysqli_num_rows($view_school_checkmate) == 1) && (((isset($_SESSION["mod_adm_session"]) && ($_SESSION["mod_adm_session"] == $view_school_detail["email"]))) || (isset($_SESSION["sup_adm_session"])))){
		$view_school_detail = mysqli_fetch_array($view_school_checkmate);
		$view_school_first_detail = mysqli_fetch_array($view_school_first_moderator);
		$school_view_edit_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".$header_add_button."&edit=".$view_school_detail["school_id_number"];
								
?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<div style="height: 7.5rem;" class="container-box bg-4 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1">
				
				<?php if(file_exists("dataimg/school_".$view_school_detail['school_id_number'].".png")){ ?>
					<img style="border-style: solid; float: left; clear: left;" src="dataimg/school_<?php echo $view_school_detail['school_id_number']; ?>.png" class="bg-2 box-shadow border-radius-30px border-color-2 border-width-6 mobile-width-12 system-width-12 mobile-margin-top-6 system-margin-top-3 mobile-margin-left-5 system-margin-left-3" />
				<?php }else{ ?>
					<img style="border-style: solid; float: left; clear: left;" src="imgfile/Student_Future.png" class="bg-2 box-shadow border-radius-30px border-color-2 border-width-6 mobile-width-12 system-width-12 mobile-margin-top-6 system-margin-top-3 mobile-margin-left-5 system-margin-left-3" />
				<?php } ?>
				<img style="float: right; clear: right;" src="imgfile/Group.png" class="bg-3 mobile-width-0 system-width-12 mobile-margin-top-0 system-margin-top-4 mobile-margin-right-1 system-margin-right-1" />	
				<div style="text-align: left; display: inline-block; height: 7.5rem;" class="container-box bg-3 mobile-width-78 system-width-69 mobile-margin-top-4 system-margin-top-3 mobile-margin-left-1 system-margin-left-0">
					<!-- Name -->
					<span style="display: inline-block;" class="color-2 mobile-font-size-17 system-font-size-25"><?php echo $view_school_detail["school_name"]; ?></span>
					<a href="<?php echo $school_view_edit_link; ?>" style="text-decoration: none;">
						<img style="margin-bottom: -1%;" src="imgfile/edit.png" class="mobile-width-8 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-1 system-margin-left-1" /><br/>
					</a>

					<!-- Phone -->
					<img style="margin-bottom: -0.5%;" src="imgfile/phone.png" class="mobile-width-6 system-width-3 mobile-margin-top-3 system-margin-top-3 mobile-margin-right-0 system-margin-right-0" />
					<span style="display: inline-block;" class="color-2 mobile-font-size-14 system-font-size-16 mobile-margin-left-0 system-margin-left-0"><?php echo $view_school_detail["school_phone_number"]; ?></span><br/>
				
					<!-- City -->
					<img style="margin-bottom: -0.5%;" src="imgfile/location.png" class="mobile-width-6 system-width-2 mobile-margin-top-3 system-margin-top-3 mobile-margin-right-1 system-margin-right-1" />
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-16 mobile-margin-left-0 system-margin-left-0"><?php echo $view_school_detail["city"]; ?></span>
				</div>
			</div>
			<div style="" class="container-box bg-3 mobile-width-90 system-width-96 mobile-margin-top-10 system-margin-top-5">
				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Email ID</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_detail["email"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-23 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">School ID Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo "SC/AD/".$view_school_detail["school_id_number"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-45 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">School Motto</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_detail["school_motto"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">School Address</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_detail["school_address"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-23 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">City</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_detail["city"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">State</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_detail["state"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Country Located</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_school_detail["country"]); ?></span>
				</div>

			</div>
			<div style="text-align: left; border-style: solid;" class="container-box border-color-5 border-width-1 bg-3 mobile-width-90 system-width-94 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-1 mobile-padding-right-2 system-padding-right-1 mobile-padding-bottom-3 system-padding-bottom-2">
				<span style="display: inline-block;" class="color-5 mobile-font-size-16 system-font-size-17">School Administrator Information</span><br>
				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-50 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Full Name</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_first_detail["firstname"]." ".$view_school_first_detail["lastname"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Phone Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_first_detail["phone_number"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Gender</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_school_first_detail["gender"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Marital Status</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_school_first_detail["marital_status"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-25 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Home Address</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_first_detail["home_address"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-25 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Office Address</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_first_detail["office_address"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">City</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_first_detail["city"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">State</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_school_first_detail["state"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-16 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Country</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_school_first_detail["country"]); ?></span>
				</div>

			</div>
		</center>
	</div>
<?php
		}
	}

?>
<?php } ?> 