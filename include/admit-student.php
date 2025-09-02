<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if((strip_tags($_GET['page']) == 'smgt_student') && (strip_tags($_GET['tab']) == "true")){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
			$count_student_listed = mysqli_num_rows($select_all_student_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_student_listed; ?> entries</span>
        	
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
           				<td style="width:10%;">Student</td>
           				<td style="width:25%;"></td>
           				<td>Gender</td>
           				<td>City</td>
           				<td>Mobile</td>
           				<td style="width:10%;">Action</td>
           			</tr>
					<?php
						if(mysqli_num_rows($select_all_student_table_lists) > 0){
							while(($student_details = mysqli_fetch_assoc($select_student_table_lists))){
								$student_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$student_details["admission_number"];
								$student_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$student_details["admission_number"];
								if(file_exists("dataimg/student_".$student_details["school_id_number"]."_".$student_details["admission_number"].".png")){
									$student_img = "dataimg/student_".$student_details["school_id_number"]."_".$student_details["admission_number"].".png";
								}else{
									$student_img = 'imgfile/Student.png';
								}
								/*$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
								$registered_classes = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && session='".$session_details["session"]."')");
								if(mysqli_num_rows($registered_classes) > 0){
									$count_registered_classes = mysqli_num_rows($registered_classes);
								}else{
									$count_registered_classes = "N/A";
								}*/
								echo '<tr>
									<td>
										<input type="checkbox" name="student_id[]" value="'.$student_details["admission_number"].'" class="classChecked" />
										<input hidden type="text" name="school_id[]" value="'.$student_details["school_id_number"].'" />
									</td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%;" src="'.$student_img.'" class="mobile-width-100 system-width-50 avatar_icon_height" /></td>
									<td>'.$student_details["lastname"].' '.$student_details["firstname"].' '.$student_details["othername"].'<br><span class="color-5">'.$student_details["email"].'</span></td>
									<td>'.Ucwords($student_details["gender"]).'</td>
									<td>'.$student_details["city"].'</td>
                                    <td>'.$student_details["phone_number"].'</td>
									<td>
										<img onclick="return popUpAlert([`'.$student_view_link.'`,``,`'.$student_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
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
				<button name="delete-student" type="submit" id="delStudent" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Student
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
					if(confirm("Are you sure you want to delete this student?")){
						document.getElementById("delStudent").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one student");
						if(confirm("Are you sure you want to delete this student?")){
							document.getElementById("delStudent").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one student");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data.php"); } ?>
<?php } ?>
<?php } ?>


<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if((strip_tags($_GET['page']) == 'smgt_student') && (strip_tags($_GET['tab']) == 'add_student') || (strip_tags($_GET['page']) == 'smgt_parent_student') && (strip_tags($_GET['tab']) == 'student_reg')){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_student_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && admission_number='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_student_checkmate) == 1)){
					if(mysqli_num_rows($edit_student_checkmate) == 1){
						$edit_student_detail = mysqli_fetch_array($edit_student_checkmate);
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_student_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
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
				    <input name="last" type="text" placeholder="" value="<?php echo $edit_student_detail['lastname']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Surname*</span>
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="first" type="text" placeholder="" value="<?php echo $edit_student_detail['firstname']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">First Name*</span>
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="other" type="text" placeholder="" value="<?php echo $edit_student_detail['othername']; ?>" class="form-input" />
                    <span class="form-span mobile-font-size-12 system-font-size-14">Other Names</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <select name="gender" class="form-select" required>
                        <option disabled hidden selected value="">Select Gender</option>
                        <option value="male" <?php if($edit_student_detail['gender'] == "male"){ echo 'selected'; } ?>>Male</option>
                        <option value="female" <?php if($edit_student_detail['gender'] == "female"){ echo 'selected'; } ?>>Female</option>
                	</select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Gender*</span>
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="dob" type="text" value="<?php echo $edit_student_detail['dob']; ?>" placeholder="YYYY-MM-DD" pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" title="Date must be in YYYY-MM-DD format" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">DOB*</span>
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="blood-group" type="text" placeholder="E.g O+, A, etc" value="<?php echo $edit_student_detail['blood_group']; ?>" class="form-input" />
                    <span class="form-span mobile-font-size-12 system-font-size-14">Blood Group</span>
                </div><br>
                
               	<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
       			    CONTACT INFORMATION
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="res-address" type="text" placeholder="" value="<?php echo $edit_student_detail['home_address']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Residence Address*</span>
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="city" type="text" placeholder="" value="<?php echo $edit_student_detail['city']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">City*</span>
                </div>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="lga" type="text" placeholder="" value="<?php echo $edit_student_detail['lga']; ?>" class="form-input" />
                    <span class="form-span mobile-font-size-12 system-font-size-14">Local Council/LGA</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="res-state" type="text" placeholder="" value="<?php echo $edit_student_detail['resident_state']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">State of Residence*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="ori-state" type="text" placeholder="" value="<?php echo $edit_student_detail['origin_state']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">State of Origin*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <select name="res-country" class="form-select" required>
                        <option disabled hidden selected value="">Select Country</option>
                        <?php
							foreach (array_values($countries_with_currencies) as $country_name) {
								// Check if the country matches the resident_country in PHP itself
								$selected = (strtolower(trim($edit_student_detail['resident_country'])) == strtolower(trim($country_name))) ? 'selected' : '';
								echo '<option value="' . htmlspecialchars($country_name, ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($country_name, ENT_QUOTES) . '</option>';
							}
						?>
					</select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Country of Residence*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <select name="ori-country" class="form-select" required>
                        <option disabled hidden selected value="">Select Country</option>
                        <?php
							foreach (array_values($countries_with_currencies) as $country_name) {
								// Check if the country matches the resident_country in PHP itself
								$selected = (strtolower(trim($edit_student_detail['origin_country'])) == strtolower(trim($country_name))) ? 'selected' : '';
								echo '<option value="' . htmlspecialchars($country_name, ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($country_name, ENT_QUOTES) . '</option>';
							}
						?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Nationality*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="phone" type="text" pattern="[0-9]{13}" title="Phone number include Country Code without (+)" placeholder="Include country code" value="<?php echo $edit_student_detail['phone_number']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Phone Number*</span>
                </div><br>
                
               	<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    OTHER INFORMATION
                </div>
                	
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="email" type="email" placeholder="" value="<?php echo $edit_student_detail['email']; ?>" class="form-input" required/>
                	<span class="form-span mobile-font-size-12 system-font-size-14">Email*</span>
                </div>
                
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="admission-year" class="form-select" required>
                		<option value="<?php if(isset($edit_student_detail['admission_year'])){ echo $edit_student_detail['admission_year']; }else{ echo date('Y'); } ?>"><?php if(isset($edit_student_detail['admission_year'])){ echo $edit_student_detail['admission_year']; }else{ echo date('Y'); } ?></option>
               		</select>
                	<span class="form-span mobile-font-size-12 system-font-size-14">Admission Year*</span>
              	</div>
                				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="parent_id" class="form-select" required>
						<option selected disabled hidden value="">Select Parent</option>
						<?php
							$select_parent_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
							
							if(mysqli_num_rows($select_parent_detail_using_id) > 0){
								while($parent_details = mysqli_fetch_assoc($select_parent_detail_using_id)){
									if(($parent_details["id_number"] == trim($edit_student_detail['parent_id_number'])) || ($parent_details["id_number"] == trim(strip_tags($_GET['parent_id'])))){
										$selected = "selected";
										echo '<option value="'.$parent_details["id_number"].'" '.$selected.'>Mr/Mrs '.$parent_details["father_last_name"].' '.$parent_details["father_first_name"].' (email: '.$parent_details["email"].')</option>';
									}else{
										echo '<option value="'.$parent_details["id_number"].'" >Mr/Mrs '.$parent_details["father_last_name"].' '.$parent_details["father_first_name"].' (email: '.$parent_details["email"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Assign Parent*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
							
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if(($classes_details["numeric_class_name"] == $edit_student_detail['current_class']) && ($classes_details["session"] == $edit_student_detail['session'])){
										$selected = "selected";
										echo '<option value="'.$classes_details["numeric_class_name"].' '.$classes_details["session"].'" '.$selected.'>'.$classes_details["class_name"].' (class ID: '.$classes_details["numeric_class_name"].', session: '.str_replace("-","/",$classes_details["session"]).')</option>';
									}else{
										echo '<option value="'.$classes_details["numeric_class_name"].' '.$classes_details["session"].'" >'.$classes_details["class_name"].' (class ID: '.$classes_details["numeric_class_name"].', session: '.str_replace("-","/",$classes_details["session"]).')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Assign Class/Session*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="prev-sch" type="text" placeholder="" value="<?php echo $edit_student_detail['previous_school']; ?>" class="form-input" />
					<span class="form-span mobile-font-size-12 system-font-size-14">Previous School</span>
				</div>
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="prev-class" type="text" placeholder="" value="<?php echo $edit_student_detail['previous_class']; ?>" class="form-input" />
					<span class="form-span mobile-font-size-12 system-font-size-14">Previous Class</span>
				</div>
				
				<!--<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="bed" class="form-select" >
						<option selected disabled hidden value="">Select Bed</option>
						<?php
							/*$select_beds_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_beds_detail_using_id) > 0){
								while($beds_details = mysqli_fetch_assoc($select_beds_detail_using_id)){
									if($beds_details["id_number"] == $edit_student_detail['bed_id_number']){
										$selected = "selected";
										echo '<option value="'.$beds_details["id_number"].'" '.$selected.'>BD'.$beds_details["id_number"].' ('.$beds_details["bed_description"].')</option>';
									}else{
										echo '<option value="'.$beds_details["id_number"].'" >BD'.$beds_details["id_number"].' ('.$beds_details["bed_description"].')</option>';
									}
									
								}
							}*/
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Assign Bed</span>
				</div>-->
				
				<div style="text-align: left; float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<select name="bus" class="form-select" >
						<option selected disabled hidden value="">Select Bus</option>
						<?php
							$select_transports_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							function transportDetails($transports_info,$school_id){
								global $connection_server;
								
								$get_transport_name = mysqli_query($connection_server,"SELECT * FROM sm_transports WHERE school_id_number='$school_id' && id_number='$transports_info'");
								if(mysqli_num_rows($get_transport_name) == 1){
									while($transport_name_array = mysqli_fetch_array($get_transport_name)){
										$transport_name .= " (Route: ".$transport_name_array["route_name"].") (Driver: ".$transport_name_array["driver_name"].") (Reg No: ".$transport_name_array["reg_number"].")";
									}
								}else{
									$transport_name = "N/A";
								}
								
								return $transport_name;
							}

							if(mysqli_num_rows($select_transports_detail_using_id) > 0){
								while($transports_details = mysqli_fetch_assoc($select_transports_detail_using_id)){
									if($transports_details["id_number"] == $edit_student_detail['bus_id_number']){
										$selected = "selected";
										echo '<option value="'.$transports_details["id_number"].'" '.$selected.'>'.$transports_details["id_number"].' '.transportDetails($transports_details["id_number"], $transports_details["school_id_number"]).'</option>';
									}else{
										echo '<option value="'.$transports_details["id_number"].'" >'.$transports_details["id_number"].' '.transportDetails($transports_details["id_number"], $transports_details["school_id_number"]).'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Assign Bus</span>
				</div><br>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class-category" class="form-select">
						<option selected disabled hidden value="">Select Class Category</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
							
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_category_name"] == $edit_student_detail['numeric_class_category_name']){
										$selected = "selected";
										echo '<option value="'.$classes_details["numeric_class_category_name"].'" '.$selected.'>'.$classes_details["class_category_name"].'</option>';
									}else{
										echo '<option value="'.$classes_details["numeric_class_category_name"].'" >'.$classes_details["class_category_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Assign Class Category</span>
				</div>
				
                <div style="text-align: left; float: left; clear: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-82 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    LOGIN INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input type="number" placeholder="This will be automatically assigned by the system" class="form-input" readonly/>
                	<span class="form-span mobile-font-size-12 system-font-size-14">Admission Number*</span>
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

				<?php if(file_exists("dataimg/student_".$edit_student_detail['school_id_number']."_".$edit_student_detail['admission_number'].".png")){ ?>
				 <img style="float: left; clear: left;" src="<?php echo "dataimg/student_".$edit_student_detail['school_id_number'].'_'.$edit_student_detail['admission_number'].".png"; ?>" class="mobile-width-30 system-width-15 mobile-margin-left-5 system-margin-left-3" /><br>
				 <?php }else{ ?>
                <img style="float: left; clear: left;" src="imgfile/Student.png" class="mobile-width-30 system-width-15 mobile-margin-left-5 system-margin-left-3" /><br>
				<?php } ?>

				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_student_checkmate) < 1)){ ?>
				<button name="add-student" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD STUDENT
				</button>
				<?php }else{ ?>
				<button name="update-student" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					UPDATE STUDENT
				</button>
				<?php } ?>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'view_student'){
	$view_student_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && admission_number='".trim(strip_tags($_GET['view']))."'");
	//$view_admin_staff_first_moderator = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE email='".trim(strip_tags($_GET['view']))."' LIMIT 1");
	
	if((mysqli_num_rows($view_student_checkmate) == 1)){
		$view_student_detail = mysqli_fetch_array($view_student_checkmate);
		$view_student_parent_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".$view_student_detail["parent_id_number"]."'");
		$view_student_parent_detail = mysqli_fetch_array($view_student_parent_checkmate);

		$student_view_edit_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".$header_add_button.$additional_add_tag."&edit=".$view_student_detail["admission_number"];

		function transportViewDetails($transports_info,$school_id){
			global $connection_server;
			
			$get_transport_name = mysqli_query($connection_server,"SELECT * FROM sm_transports WHERE school_id_number='$school_id' && id_number='$transports_info'");
			if(mysqli_num_rows($get_transport_name) == 1){
				while($transport_name_array = mysqli_fetch_array($get_transport_name)){
					$transport_name .= "<b>Route</b>: ".$transport_name_array["route_name"].", <b>Driver</b>: ".$transport_name_array["driver_name"].", <b>Reg No</b>: ".$transport_name_array["reg_number"]."</b>";
				}
			}else{
				$transport_name = "N/A";
			}
			
			return $transport_name;
		}

?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<div style="height: 7.5rem;" class="container-box bg-4 mobile-width-96 system-width-96 mobile-margin-top-1 system-margin-top-1">
				
				<?php if(file_exists("dataimg/student_".$view_student_detail['school_id_number']."_".$view_student_detail['admission_number'].".png")){ ?>
					<img style="border-style: solid; float: left; clear: left;" src="dataimg/student_<?php echo $view_student_detail['school_id_number'].'_'.$view_student_detail['admission_number']; ?>.png" class="bg-2 box-shadow border-radius-30px border-color-2 border-width-6 mobile-width-12 system-width-12 mobile-margin-top-6 system-margin-top-3 mobile-margin-left-5 system-margin-left-3" />
				<?php }else{ ?>
					<img style="border-style: solid; float: left; clear: left;" src="imgfile/Student.png" class="bg-2 box-shadow border-radius-30px border-color-2 border-width-6 mobile-width-12 system-width-12 mobile-margin-top-6 system-margin-top-3 mobile-margin-left-5 system-margin-left-3" />
				<?php } ?>
				<img style="float: right; clear: right;" src="imgfile/Group.png" class="bg-3 mobile-width-0 system-width-12 mobile-margin-top-0 system-margin-top-4 mobile-margin-right-1 system-margin-right-1" />	
				<div style="text-align: left; display: inline-block; height: 7.5rem;" class="container-box bg-3 mobile-width-78 system-width-69 mobile-margin-top-4 system-margin-top-3 mobile-margin-left-1 system-margin-left-0">
					<!-- Name -->
					<span style="display: inline-block;" class="color-2 mobile-font-size-17 system-font-size-25"><?php echo $view_student_detail["lastname"]." ".$view_student_detail["firstname"]." ".$view_student_detail["othername"]; ?></span>
					<a href="<?php echo $student_view_edit_link; ?>" style="text-decoration: none;">
						<img style="margin-bottom: -1%;" src="imgfile/edit.png" class="mobile-width-8 system-width-4 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-1 system-margin-left-1" /><br/>
					</a>

					<!-- Phone -->
					<img style="margin-bottom: -0.5%;" src="imgfile/phone.png" class="mobile-width-6 system-width-3 mobile-margin-top-3 system-margin-top-3 mobile-margin-right-0 system-margin-right-0" />
					<span style="display: inline-block;" class="color-2 mobile-font-size-14 system-font-size-16 mobile-margin-left-0 system-margin-left-0"><?php echo $view_student_detail["phone_number"]; ?></span><br/>
				
					<!-- City -->
					<img style="margin-bottom: -0.5%;" src="imgfile/location.png" class="mobile-width-6 system-width-2 mobile-margin-top-3 system-margin-top-3 mobile-margin-right-1 system-margin-right-1" />
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-16 mobile-margin-left-0 system-margin-left-0"><?php echo $view_student_detail["city"]; ?></span>
				</div>
			</div>
			<div style="" class="container-box bg-3 mobile-width-90 system-width-96 mobile-margin-top-10 system-margin-top-8">
				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Email ID</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["email"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Admission Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo "ST/".$view_student_detail["school_id_number"]."/".$view_student_detail["admission_number"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Mobile Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["phone_number"]; ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Gender</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_student_detail["gender"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-0">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Date of Birth</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo str_replace("-","/",$view_student_detail["dob"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Blood Group</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["blood_group"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Local Council/LGA</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["lga"]; ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">State Of Origin</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["origin_state"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-31 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Country Of Origin</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_student_detail["origin_country"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Admission Year</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["admission_year"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Current Class</span><br>
					<?php
						$get_current_class_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".$view_student_detail["school_id_number"]."' && numeric_class_name='".$view_student_detail["current_class"]."'"));
						$get_current_class_category_details = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='".$view_student_detail["school_id_number"]."' && numeric_class_category_name='".$view_student_detail["numeric_class_category_name"]."'");
						if(mysqli_num_rows($get_current_class_category_details) == 1){
							$current_class_category_name = " '" . mysqli_fetch_array($get_current_class_category_details)["class_category_name"] . "' ";
						}else{
							$current_class_category_name = "";
						}
					?>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $get_current_class_details["class_name"] . $current_class_category_name; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-22 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Session</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo str_replace("-","/",$view_student_detail["session"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-98 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Bus Information</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo transportViewDetails($view_student_detail["bus_id_number"], $view_student_detail["school_id_number"]); ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-98 mobile-margin-top-3 system-margin-top-1">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Home Address</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_detail["home_address"]; ?></span>
				</div>

			</div>
			<div style="text-align: left; border-style: solid;" class="container-box border-color-5 border-width-1 bg-3 mobile-width-90 system-width-94 mobile-margin-top-3 system-margin-top-3 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-1 mobile-padding-right-2 system-padding-right-1 mobile-padding-bottom-3 system-padding-bottom-2">
				<span style="display: inline-block;" class="color-5 mobile-font-size-16 system-font-size-17">Parent Information</span><br>
				
				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Father Full Name</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["father_last_name"]." ".$view_student_parent_detail["father_first_name"]; ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Father Phone Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["father_phone_number"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Father Occupation</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["father_occupation"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Mother Full Name</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["mother_last_name"]." ".$view_student_parent_detail["father_first_name"]; ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Mother Phone Number</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["mother_phone_number"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Mother Occupation</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["mother_occupation"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Parent Email</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["email"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Parent ID</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["id_number"]; ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Home Address</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_student_parent_detail["home_address"]); ?></span>
				</div>

                <div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">City</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["city"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">State</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo $view_student_parent_detail["state"]; ?></span>
				</div>

				<div style="text-align: left; display: inline-block;" class="container-box bg-3 mobile-width-100 system-width-33 mobile-margin-top-3 system-margin-top-2">
					<span style="display: inline-block;" class="color-5 mobile-font-size-14 system-font-size-17">Country</span><br>
					<span style="display: inline-block;" class="color-7 mobile-font-size-16 system-font-size-18"><?php echo Ucwords($view_student_parent_detail["country"]); ?></span>
				</div>
			</div>
		</center>
	</div>
<?php
		}
	}

?>
<?php } ?>