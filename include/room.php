<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
			$count_room_listed = mysqli_num_rows($select_all_room_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_room_listed; ?> entries</span>
        	
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
           				<td class="mobile-width-10 system-width-10">Student</td>
           				<td>Unique ID</td>
           				<td>Hostel Name</td>
           				<td>Room Category</td>
           				<td>Availability</td>
           				<td>Description</td>
           				<?php
							if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
						?>
						<td style="width:10%;">Action</td>
						<?php } ?>
           			</tr>
					<?php
						function hostelName($hostels_info,$school_id){
							global $connection_server;
							
							$get_hostel_name = mysqli_query($connection_server,"SELECT * FROM sm_hostels WHERE school_id_number='$school_id' && id_number='$hostels_info'");
							if(mysqli_num_rows($get_hostel_name) == 1){
								while($hostel_name_array = mysqli_fetch_array($get_hostel_name)){
									$hostel_name .= $hostel_name_array["hostel_name"]." (".$hostel_name_array["hostel_type"].") (".$hostel_name_array["id_number"].")";
								}
							}else{
								$hostel_name = "N/A";
							}
							
							return $hostel_name;
						}
						
						function roomName($rooms_info,$school_id){
							global $connection_server;
							
							$get_room_name = mysqli_query($connection_server,"SELECT * FROM sm_room_list WHERE school_id_number='$school_id' && category_number='$rooms_info'");
							if(mysqli_num_rows($get_room_name) == 1){
								while($room_name_array = mysqli_fetch_array($get_room_name)){
									$room_name .= $room_name_array["room_category"];
								}
							}else{
								$room_name = "N/A";
							}
							
							return $room_name;
						}
						
						/*function bedAvailability($beds_info,$school_id){
							global $connection_server;
							
							$get_bed_name = mysqli_query($connection_server,"SELECT * FROM sm_s WHERE school_id_number='$school_id' && bed_id_number='$beds_info'");
							if(mysqli_num_rows($get_bed_name) > 0){
								while($bed_name_array = mysqli_fetch_array($get_bed_name)){
									$view_student = str_replace('page='.trim(strip_tags($_GET["page"])),'page=smgt_student',str_replace('tab=true','tab=view_student',$_SERVER['REQUEST_URI']))."&view=".$bed_name_array["admission_number"];
									$bed_bed_capacity .= "<a style='text-decoration: underline; color: red;' title='View Bed Owner' href='".$view_student."'>Occupied (".$bed_name_array["firstname"]." ".$bed_name_array["lastname"].")</a><br>";
								}
							}else{
								$bed_bed_capacity = "<span style='color: green;'>Available</span>";
							}
							
							return $bed_bed_capacity;
						}*/
						
						
						function roomAvailability($bed_capacity,$rooms_info,$school_id){
							global $connection_server;
							global $room_edit_link;

							$get_room_name = mysqli_query($connection_server,"SELECT * FROM sm_beds WHERE school_id_number='$school_id' && room_id_number='$rooms_info'");
							$get_room_name_limit_1 = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_beds WHERE school_id_number='$school_id' && room_id_number='$rooms_info' LIMIT 1"));
							
							$get_all_student_bed = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && bed_id_number='".$get_room_name_limit_1["bed_id_number"]."'");
							
							if(mysqli_num_rows($get_room_name) >= 1){
								if((mysqli_num_rows($get_room_name) > mysqli_num_rows($get_all_student_bed)) && (mysqli_num_rows($get_room_name) == $bed_capacity)){
									$room_bed_availability .= "<a style='text-decoration: underline; color: red;' title='' href='?page=smgt_bed&tab=true&id=".$school_id."&search=RM".$rooms_info."'>Limit Reached (Bedspace Available)</a><br>";
								}else{
									if((mysqli_num_rows($get_room_name) == mysqli_num_rows($get_all_student_bed)) && (mysqli_num_rows($get_room_name) == $bed_capacity)){
										$room_bed_availability .= "<a style='text-decoration: underline; color: red;' title='' href='?page=smgt_bed&tab=true&id=".$school_id."&search=RM".$rooms_info."'>Occupied</a><br>";
									}else{
										if((mysqli_num_rows($get_room_name) > mysqli_num_rows($get_all_student_bed)) && (mysqli_num_rows($get_room_name) < $bed_capacity)){
											$room_bed_availability .= "<a style='text-decoration: underline; color: green;' title='' href='?page=smgt_bed&tab=add_bed&id=".$school_id."'>Available</a>";
										}else{
											if(mysqli_num_rows($get_room_name) > $bed_capacity){
												$room_bed_availability .= "<a style='text-decoration: underline; color: red;' title='' href='".$room_edit_link."'>Alert! Bed Space Overload (Increase Limit)</a><br>";
											}
										}
									}
								}
							}else{
								$room_bed_availability = "<a style='text-decoration: underline; color: green;' title='' href='?page=smgt_bed&tab=add_bed&id=".$school_id."'>Available</a>";
							}
							
							return $room_bed_availability;
						}
						
						if(mysqli_num_rows($select_all_room_table_lists) > 0){
							while(($room_details = mysqli_fetch_assoc($select_room_table_lists))){
								$room_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$room_details["id_number"]."&category=".$room_details["category_number"]."&hostel=".$room_details["hostel_id_number"];
								$room_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$room_details["id_number"]."&category=".$room_details["category_number"]."&hostel=".$room_details["hostel_id_number"];
								/*$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
								$registered_students = mysqli_query($connection_server, "SELECT * FROM sm_room_list WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && numeric_room_name='".$room_details["numeric_room_name"]."' && session='".$room_details["session"]."')");
								if(mysqli_num_rows($registered_students) > 0){
									$count_registered_students = mysqli_num_rows($registered_students);
								}else{
									$count_registered_students = "N/A";
								}*/

								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="room_id[]" value="'.$room_details["id_number"].'" class="roomChecked" />
														<input hidden type="text" name="category_no[]" value="'.$room_details["category_number"].'" />
														<input hidden type="text" name="school_id[]" value="'.$room_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$room_edit_link.'`,``],[`View room Details`,``,`Edit room`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}

								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/hostel.png" class="mobile-width-60 system-width-30" /></td>
									<td>RM'.$room_details["id_number"].'</td>
           							<td>'.hostelName($room_details["hostel_id_number"],$room_details["school_id_number"]).'</td>
           							<td>'.roomName($room_details["category_number"],$room_details["school_id_number"]).'</td>
           							<td>'.roomAvailability($room_details["bed_capacity"],$room_details["id_number"],$room_details["school_id_number"]).'</td>
									<td>'.checkIfEmpty($room_details["room_description"]).'</td>
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
				<button name="delete-room" type="submit" id="delroom" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete room
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
				var allBoxToChecked = document.getElementsByClassName("roomChecked");
				if(document.getElementsByClassName("roomChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("roomChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("roomChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("roomChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this room?")){
						document.getElementById("delroom").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one room");
						if(confirm("Are you sure you want to delete this room?")){
							document.getElementById("delroom").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one room");
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
<?php if(strip_tags($_GET['tab']) == 'add_room'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_room_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".trim(strip_tags($_GET['edit']))."' && category_number='".trim(strip_tags($_GET['category']))."' && hostel_id_number='".trim(strip_tags($_GET['hostel']))."')");
				//$edit_room_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_room_list WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && category_number='".trim(strip_tags($_GET['category']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_room_checkmate) == 1)){
					if(mysqli_num_rows($edit_room_checkmate) == 1){
						$edit_room_detail = mysqli_fetch_array($edit_room_checkmate);
						//$edit_room_list_detail = mysqli_fetch_array($edit_room_list_checkmate);
						
						$edit_room_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_room_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    ROOM INFORMATION
                </div>
				<?php
					$all_room_num_count_inner = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'"));
					$check_last_room_inner = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT 1 OFFSET ".($all_room_num_count_inner-1)));
					$room_no_inner = sprintf("%03d",(($check_last_room_inner["id_number"]) + 1));
				?>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="" value="RM<?php if($edit_room_detail['id_number']){ echo $edit_room_detail['id_number']; }else{ echo $room_no_inner; } ?>" type="text" placeholder="" class="form-input" readonly/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Room Unique ID</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="hostel" class="form-select" required>
						<option selected disabled hidden value="">Select Hostel</option>
						<?php
							$select_hostels_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_hostels_detail_using_id) > 0){
								while($hostels_details = mysqli_fetch_assoc($select_hostels_detail_using_id)){
									if($hostels_details["id_number"] == $edit_room_detail['hostel_id_number']){
										$selected = "selected";
										echo '<option value="'.$hostels_details["id_number"].'" '.$selected.'>'.$hostels_details["hostel_name"].' ('.$hostels_details["hostel_type"].')</option>';
									}else{
										echo '<option value="'.$hostels_details["id_number"].'" >'.$hostels_details["hostel_name"].' ('.$hostels_details["hostel_type"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Hostel*</span>
				</div>

				<div class="form-group mobile-width-90 system-width-35 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="room-category" id="select-room-id" class="form-select" required>
						<option selected disabled hidden value="">Select Category</option>
						<?php
							$select_rooms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_room_list WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_rooms_detail_using_id) > 0){
								while($rooms_details = mysqli_fetch_assoc($select_rooms_detail_using_id)){
									if($rooms_details["category_number"] == $edit_room_detail['category_number']){
										$selected = "selected";
										echo '<option value="'.$rooms_details["category_number"].' '.$rooms_details["room_category"].'" '.$selected.'>'.$rooms_details["room_category"].'</option>';
									}else{
										echo '<option value="'.$rooms_details["category_number"].' '.$rooms_details["room_category"].'" >'.$rooms_details["room_category"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Room Category*</span>
				</div>
				
				<?php $sch_id_numb = $get_logged_user_details["school_id_number"]; ?>
				<button onclick="largePopUp(`Add Room Category`,`Add Category`,`ADD CATEGORY`,`select-room-id`,`sm_room_list`,`school_id_number='<?php echo $sch_id_numb; ?>' && category_number='null'`,`room_category`);" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-6 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD
				</button>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="bed-capacity" value="<?php echo $edit_room_detail['bed_capacity']; ?>" type="text" pattern="[0-9]{1,}" title="Bed Capacity must contain numbers only" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Bed Capacity*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="room-desc" value="<?php echo $edit_room_detail['room_description']; ?>" type="text" placeholder="" class="form-input"/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Description</span>
                </div>
                
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_room_checkmate) < 1)){ ?>
                <button name="add-room" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD ROOM
				</button>
				<?php }else{ ?>
				<button name="update-room" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE ROOM
				</button>
				<?php } ?>
            </form>
            
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 

<?php } ?>