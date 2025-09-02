<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
			$count_class_listed = mysqli_num_rows($select_all_class_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_class_listed; ?> entries</span>
        	
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
           				<td class="mobile-width-10 system-width-10">Student</td>
           				<td>Class Name</td>
           				<td>Class Numeric Name</td>
           				<td>Student Capacity</td>
           				<td>Registered Student</td>
           				<td>Session</td>
           				<td style="width:10%;">Action</td>
           			</tr>
					<?php
						if(mysqli_num_rows($select_all_class_table_lists) > 0){
							while(($class_details = mysqli_fetch_assoc($select_class_table_lists))){
								$class_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$class_details["numeric_class_name"]."&session=".$class_details["session"];
								$class_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$class_details["numeric_class_name"]."&session=".$class_details["session"];
								$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
								$registered_students = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && numeric_class_name='".$class_details["numeric_class_name"]."' && session='".$class_details["session"]."')");
								if(mysqli_num_rows($registered_students) > 0){
									$count_registered_students = mysqli_num_rows($registered_students);
								}else{
									$count_registered_students = "N/A";
								}
								echo '<tr>
									<td>
										<input type="checkbox" name="class_id[]" value="'.$class_details["numeric_class_name"].'" class="classChecked" />
										<input hidden type="text" name="school_id[]" value="'.$class_details["school_id_number"].'" />
										<input hidden type="text" name="session_id[]" value="'.$class_details["session"].'" />
									</td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%;" src="imgfile/Student.png" class="mobile-width-100 system-width-50 avatar_icon_height" /></td>
									<td>'.$class_details["class_name"].'
           							<td>'.$class_details["numeric_class_name"].'</td>
									<td>'.$class_details["student_capacity"].'</td>
									<td>'.$count_registered_students.'</td>
									<td>'.str_replace("-","/",$class_details["session"]).'</td>
									<td>
										<img onclick="return popUpAlert([``,``,`'.$class_edit_link.'`,``],[`View Class Details`,``,`Edit Class`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
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
				<button name="delete-class" type="submit" id="delClass" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Class
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
					if(confirm("Are you sure you want to delete this Class?")){
						document.getElementById("delClass").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Class");
						if(confirm("Are you sure you want to delete this Class?")){
							document.getElementById("delClass").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Class");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data.php"); } ?>
<?php } ?>


<?php if(strip_tags($_GET['tab']) == 'add_class'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_class_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".trim(strip_tags($_GET['edit']))."' && session='".trim(strip_tags($_GET['session']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_class_checkmate) == 1) && (isset($_GET['session'])) && (trim(strip_tags($_GET['session'])) !== "")){
					if(mysqli_num_rows($edit_class_checkmate) == 1){
						$edit_class_detail = mysqli_fetch_array($edit_class_checkmate);
						$edit_class_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_class_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    CLASS INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="class-name" value="<?php echo $edit_class_detail['class_name']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="num-class-name" id="num-class-name" value="<?php echo $edit_class_detail['numeric_class_name']; ?>" type="text" pattern="[0-9]{1,}" title="Code must contain numbers only" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Numeric Class Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="stu-capacity" id="stu-capacity" value="<?php echo $edit_class_detail['student_capacity']; ?>" type="number" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Students Capacity*</span>
                </div>
                
				<select hidden name="school-id" required>
					<option disabled hidden selected value="">Select School</option>
					<?php
						$select_school_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
						
						if(mysqli_num_rows($select_school_detail_using_id) > 0){
							while($school_details = mysqli_fetch_assoc($select_school_detail_using_id)){
								if($school_details["school_id_number"] == trim(strip_tags($_GET['id']))){
									$selected = "selected";
								}
								echo '<option value="'.$school_details["school_id_number"].'" '.$selected.'>'.$school_details["school_name"].', ID: '.$school_details["school_id_number"].'</option>';
							}
						}
						
					?>
				</select>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="session" class="form-select" required>
						<option disabled hidden selected value="">Select Session</option>
						<?php
							$select_session_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_sessions WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_session_detail_using_id) > 0){
								while($session_details = mysqli_fetch_assoc($select_session_detail_using_id)){
									if($session_details["session"] == $edit_class_detail['session']){
										$selected = "selected";
										echo '<option value="'.$session_details["session"].'" '.$selected.'>'.str_replace("-","/",$session_details["session"]).'</option>';
									}else{
										echo '<option value="'.$session_details["session"].'" >'.str_replace("-","/",$session_details["session"]).'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session*</span>
				</div>
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_class_checkmate) < 1)){ ?>
                <button name="add-class" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD CLASS
				</button>
				<?php }else{ ?>
				<button name="update-class" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE CLASS
				</button>
				<?php } ?>
            </form>
            <script>
            	setInterval(function(){
            		let numericClassName = document.getElementById("num-class-name");
            		let stuCapacity = document.getElementById("stu-capacity");
            		numericClassName.value = numericClassName.value.replace(".","");
            		stuCapacity.value = stuCapacity.value.replace(".","");
            		if(!Number(numericClassName.value)){
            			numericClassName.value = "";
            		}else{
            			numericClassName.value = numericClassName.value.replace(".","");
            		}
            		
            		if(!Number(stuCapacity.value)){
            			stuCapacity.value = "";
            		}else{
            			stuCapacity.value = stuCapacity.value.replace(".","");
            		}
            	},100);
            </script>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 

<?php } ?>