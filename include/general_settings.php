<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['page']) == 'smgt_general_settings'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    		<center>
    			<?php
    				$edit_school_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".$get_logged_user_details['school_id_number']."'");
    				if((isset($_GET['id'])) && (trim(strip_tags($_GET['id'])) !== "") && (mysqli_num_rows($edit_school_checkmate) == 1)){
    					if(mysqli_num_rows($edit_school_checkmate) == 1){
    						$edit_school_detail = mysqli_fetch_array($edit_school_checkmate);
    						$edit_school_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$get_logged_user_details['school_id_number']."' LIMIT 1"));
    					}
    				}
    			?>
    			<?php if((isset($_GET['id'])) && (trim(strip_tags($_GET['id'])) !== "") && (mysqli_num_rows($edit_school_checkmate) == 1)){ ?>
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
    				    <input readonly name="name" value="<?php echo $edit_school_detail['school_name']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Name*</span>
                </div>
    
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
    				    <input readonly name="motto" value="<?php echo $edit_school_detail['school_motto']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Motto*</span>
                </div>
    
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
    				    <input readonly name="address" value="<?php echo $edit_school_detail['school_address']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">School Address*</span>
                </div>
    	
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    SCHOOL ADMIN INFORMATION
                </div>
    
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
    				    <input readonly name="mod-first" value="<?php echo $edit_school_moderator_detail['firstname']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">First Name*</span>
                </div>
    
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
    				    <input readonly name="mod-last" value="<?php echo $edit_school_moderator_detail['lastname']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Last Name*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                	<input readonly name="mod-phone" value="<?php echo $edit_school_moderator_detail['phone_number']; ?>" type="text" pattern="[0-9]{13}" title="Phone number include Country Code without (+)" placeholder="" class="form-input" required/>
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
                    ACCOUNT PASSWORD [AUTHENTICATION]
                </div>

                <div style="float: left; clear: both;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
               	    <input name="mod-acc-pass" type="password" pattern="[a-zA-Z0-9]{8,}" title="Password must be Alphanumeric and not less than 8 character (No Special Character)" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Password*</span>
                </div>

                <?php if(file_exists("dataimg/school_".$edit_school_detail["school_id_number"].".png")){ ?>
                    <img style="float: left; clear: both;" src="dataimg/school_<?php echo $edit_school_detail["school_id_number"]; ?>.png" class="mobile-width-30 system-width-10 mobile-margin-left-5 system-margin-left-3"/><br>
                <?php }else{ ?>
                    <img style="float: left; clear: both;" src="imgfile/Student_Future.png" class="mobile-width-30 system-width-10 mobile-margin-left-5 system-margin-left-3"/><br>
                <?php } ?>
                <button style="float: left; clear: both;" name="update-school" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    UPDATE DETAIL
                </button>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?>
<?php } ?>