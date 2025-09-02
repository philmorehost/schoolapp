<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_bed_statement_auth)) > 0){
			$count_bed_listed = mysqli_num_rows($select_all_bed_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_bed_listed; ?> entries</span>
        	
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
           				<td>Bed Unique ID</td>
           				<td>Room Unique ID</td>
						<?php
							if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
						?>
           				<td>Availability</td>
						<?php } ?>
           				<td>Description</td>
           				<?php
							if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
						?>
						<td style="width:10%;">Action</td>
						<?php } ?>
           			</tr>
					<?php
						function roomName($rooms_info,$school_id){
							global $connection_server;
							
							$get_room_name = mysqli_query($connection_server,"SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$rooms_info'");
							if(mysqli_num_rows($get_room_name) == 1){
								while($room_name_array = mysqli_fetch_array($get_room_name)){
									$room_name .= $room_name_array["room_name"]." (".$room_name_array["room_type"].") (".$room_name_array["id_number"].")";
								}
							}else{
								$room_name = "N/A";
							}
							
							return $room_name;
						}
						
						function bedName($beds_info,$school_id){
							global $connection_server;
							
							$get_bed_name = mysqli_query($connection_server,"SELECT * FROM sm_bed_list WHERE school_id_number='$school_id' && category_number='$beds_info'");
							if(mysqli_num_rows($get_bed_name) == 1){
								while($bed_name_array = mysqli_fetch_array($get_bed_name)){
									$bed_name .= $bed_name_array["bed_category"];
								}
							}else{
								$bed_name = "N/A";
							}
							
							return $bed_name;
						}
						
						function bedAvailability($room_id,$beds_info,$school_id){
							global $connection_server;
							
							$get_bed_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && bed_id_number='$beds_info'");
							if(mysqli_num_rows($get_bed_name) == 1){
								while($bed_name_array = mysqli_fetch_array($get_bed_name)){
									$view_student = str_replace('page='.trim(strip_tags($_GET["page"])),'page=smgt_student',str_replace('tab=true','tab=view_student',$_SERVER['REQUEST_URI']))."&view=".$bed_name_array["admission_number"];
									$bed_bed_capacity .= "<a style='text-decoration: underline; color: red;' title='View Bed Owner' href='".$view_student."'>Occupied (".$bed_name_array["firstname"]." ".$bed_name_array["lastname"].") </a><br><a style='text-decoration: underline; color: green;' title='' href='?page=smgt_bed&tab=assign_bed&id=".$school_id."&student_id=".$bed_name_array["admission_number"]."&room_id=".$room_id."&bed_id=".$beds_info."'>Reassign Bed</a>";
								}
							}else{
								$bed_bed_capacity = "<a style='text-decoration: underline; color: green;' title='' href='?page=smgt_bed&tab=assign_bed&id=".$school_id."&room_id=".$room_id."&bed_id=".$beds_info."'>Available</a>";
							}
							
							return $bed_bed_capacity;
						}
						
						if(mysqli_num_rows($select_all_bed_table_lists) > 0){
							while(($bed_details = mysqli_fetch_assoc($select_bed_table_lists))){
								$bed_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$bed_details["id_number"]."&room=".$bed_details["room_id_number"];
								$bed_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$bed_details["id_number"]."&room=".$bed_details["room_id_number"];
								/*$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
								$registered_students = mysqli_query($connection_server, "SELECT * FROM sm_bed_list WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && numeric_bed_name='".$bed_details["numeric_bed_name"]."' && session='".$bed_details["session"]."')");
								if(mysqli_num_rows($registered_students) > 0){
									$count_registered_students = mysqli_num_rows($registered_students);
								}else{
									$count_registered_students = "N/A";
								}*/

								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="bed_id[]" value="'.$bed_details["id_number"].'" class="bedChecked" />
														<input hidden type="text" name="room_id[]" value="'.$bed_details["room_id_number"].'" />
														<input hidden type="text" name="school_id[]" value="'.$bed_details["school_id_number"].'" />
													</td>';
									$avail_button = '<td>'.bedAvailability($bed_details["room_id_number"],$bed_details["id_number"],$bed_details["school_id_number"]).'</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$bed_edit_link.'`,``],[`View bed Details`,``,`Edit bed`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}

								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/hostel.png" class="mobile-width-60 system-width-30" /></td>
									<td>BD'.$bed_details["id_number"].'</td>
           							<td>RM'.$bed_details["room_id_number"].'</td>
           							'.$avail_button.'
									<td>'.checkIfEmpty($bed_details["bed_description"]).'</td>
									'.$action_button.'
									</tr>';
							}
						}
					?>
           		</table>
				
				<?php
					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
				?>
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
				<?php } ?>
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
				<button name="delete-bed" type="submit" id="delBed" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Bed
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
				var allBoxToChecked = document.getElementsByClassName("bedChecked");
				if(document.getElementsByClassName("bedChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("bedChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("bedChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("bedChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this bed?")){
						document.getElementById("delBed").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one bed");
						if(confirm("Are you sure you want to delete this bed?")){
							document.getElementById("delBed").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one bed");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{
			if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
				include("include/no-data.php");
			}else{
				include("include/no-data-img.php");
			}
		} ?>
<?php } ?>
<?php } ?>


<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_bed'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_bed_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && id_number='".trim(strip_tags($_GET['edit']))."' && room_id_number='".trim(strip_tags($_GET['room']))."')");
				//$edit_bed_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_bed_list WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && category_number='".trim(strip_tags($_GET['category']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_bed_checkmate) == 1)){
					if(mysqli_num_rows($edit_bed_checkmate) == 1){
						$edit_bed_detail = mysqli_fetch_array($edit_bed_checkmate);
						//$edit_bed_list_detail = mysqli_fetch_array($edit_bed_list_checkmate);
						
						$edit_bed_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_bed_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    BED INFORMATION
                </div>
				<?php
					$all_bed_num_count_inner = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."'"));
					$check_last_bed_inner = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT 1 OFFSET ".($all_bed_num_count_inner-1)));
					$bed_no_inner = sprintf("%03d",(($check_last_bed_inner["id_number"]) + 1));
				?>
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="" value="BD<?php if($edit_bed_detail['id_number']){ echo $edit_bed_detail['id_number']; }else{ echo $bed_no_inner; } ?>" type="text" placeholder="" class="form-input" readonly/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Bed Unique ID</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="room" class="form-select" required>
						<option selected disabled hidden value="">Select Room</option>
						<?php
							$select_rooms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");

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
				
							if(mysqli_num_rows($select_rooms_detail_using_id) > 0){
								while($rooms_details = mysqli_fetch_assoc($select_rooms_detail_using_id)){
									if($rooms_details["id_number"] == $edit_bed_detail['room_id_number']){
										$selected = "selected";
										echo '<option value="'.$rooms_details["id_number"].'" '.$selected.'>RM'.$rooms_details["id_number"].' ('.roomName($rooms_details["category_number"],$rooms_details["school_id_number"]).')</option>';
									}else{
										echo '<option value="'.$rooms_details["id_number"].'" >RM'.$rooms_details["id_number"].' ('.roomName($rooms_details["category_number"],$rooms_details["school_id_number"]).')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Room Unique ID*</span>
				</div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="bed-desc" value="<?php echo $edit_bed_detail['bed_description']; ?>" type="text" placeholder="" class="form-input"/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Description</span>
                </div>
                
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_bed_checkmate) < 1)){ ?>
                <button name="add-bed" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD BED
				</button>
				<?php }else{ ?>
				<button name="update-bed" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE BED
				</button>
				<?php } ?>
            </form>
            
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 

<?php if(strip_tags($_GET['tab']) == 'assign_bed'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    ASSIGN BED INFORMATION
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="admission-number" onchange="assignBedStudent();" id="assign-bed-student" class="form-select" required>
						<option selected disabled hidden value="">Select Student</option>
						<?php
							if(isset($_SESSION["sup_adm_session"])){
								$select_students_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_students");
							}else{
								if(isset($_SESSION["mod_adm_session"])){
									$select_students_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
								}
							}
													
							function className($class_info,$school_id){
								global $connection_server;
							
								$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info'");
								if(mysqli_num_rows($get_class_name) > 0){
									while($class_name_array = mysqli_fetch_array($get_class_name)){
										$class_name .= $class_name_array["class_name"];
									}
								}else{
									$class_name = "N/A";
								}
							
								return $class_name;
							}
							
							if(mysqli_num_rows($select_students_detail_using_id) > 0){
								while($students_details = mysqli_fetch_assoc($select_students_detail_using_id)){
									if((isset($_GET["student_id"])) && ($students_details["admission_number"] == trim(strip_tags($_GET["student_id"])))){
										echo '<option value="'.$students_details["admission_number"].'" selected>'.$students_details["firstname"].' '.$students_details["lastname"].' (ST/'.$students_details["school_id_number"].'/'.$students_details["admission_number"].') ('.className($students_details["current_class"],$students_details["school_id_number"]).') ('.str_replace("-","/",$students_details["session"]).')</option>';
									}else{
										echo '<option value="'.$students_details["admission_number"].'" >'.$students_details["firstname"].' '.$students_details["lastname"].' (ST/'.$students_details["school_id_number"].'/'.$students_details["admission_number"].') ('.className($students_details["current_class"],$students_details["school_id_number"]).') ('.str_replace("-","/",$students_details["session"]).')</option>';
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Student</span>
				</div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="bed-room" id="assign-room-bed" class="form-select" required>
						<option selected disabled hidden value="">Select Room Bed</option>
						<?php
							if(isset($_SESSION["sup_adm_session"])){
								$select_beds_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_beds");
							}else{
								if(isset($_SESSION["mod_adm_session"])){
									$select_beds_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
								}
							}
				
							function roomName($rooms_info,$school_id){
								global $connection_server;
								
								$get_room_name = mysqli_query($connection_server,"SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$rooms_info'");
								if(mysqli_num_rows($get_room_name) == 1){
									while($room_name_array = mysqli_fetch_array($get_room_name)){
										$get_room_list_name = mysqli_query($connection_server,"SELECT * FROM sm_room_list WHERE school_id_number='$school_id' && category_number='".$room_name_array["category_number"]."'");
										$room_name .= hostelName($room_name_array["hostel_id_number"],$school_id)." (".mysqli_fetch_array($get_room_list_name)["room_category"].")";
									}
								}else{
									$room_name = hostelName($room_name_array["hostel_id_number"],$school_id)." (N/A)";
								}
								
								return $room_name;
							}

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

							if(mysqli_num_rows($select_beds_detail_using_id) > 0){
								while($beds_details = mysqli_fetch_assoc($select_beds_detail_using_id)){
									if((isset($_GET["room_id"])) && (isset($_GET["bed_id"])) && ($beds_details["room_id_number"] == trim(strip_tags($_GET["room_id"]))) && ($beds_details["id_number"] == trim(strip_tags($_GET["bed_id"])))){
										echo '<option value="'.$beds_details["id_number"].' '.$beds_details["room_id_number"].'" selected>'.roomName($beds_details["room_id_number"],$beds_details["school_id_number"]).' (RM'.$beds_details["room_id_number"].') (BD'.$beds_details["id_number"].')</option>';
									}else{
										echo '<option value="'.$beds_details["id_number"].' '.$beds_details["room_id_number"].'" >'.roomName($beds_details["room_id_number"],$beds_details["school_id_number"]).' (RM'.$beds_details["room_id_number"].') (BD'.$beds_details["id_number"].')</option>';
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Room Bed Unique ID*</span>
				</div>
				<input hidden id="bed-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				<button type="button" onclick="assignNavigate('prev');" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-22 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
				    PREV
				</button>
				<button type="button" onclick="assignNavigate('next');" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-22 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
				    NEXT
				</button>
                <button name="assign-bed" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
				    ASSIGN BED
				</button>
            </form>
			<script>
				function assignBedStudent(){
					const assign_bed_student = document.getElementById("assign-bed-student");
					const assign_room_bed = document.getElementById("assign-room-bed");
					const assign_bed_school_id = document.getElementById("bed-school-id");
					

					const bedHttpRequest = new XMLHttpRequest();
					bedHttpRequest.open("POST","./get-student-bed.php");
					bedHttpRequest.setRequestHeader("Content-Type","application/json");
					const bedHttpRequestBody = JSON.stringify({sch_no: assign_bed_school_id.value,student_ad_no: assign_bed_student.value});
					bedHttpRequest.onload = function(){
						if((bedHttpRequest.readyState == 4) && (bedHttpRequest.status == 200)){
							for(i=0; i < assign_room_bed.options.length; i++){
								if(assign_room_bed.options[i].value.split(" ")[0] == JSON.parse(bedHttpRequest.responseText)["response"]){
									assign_room_bed.options[i].selected = true;
								}
							}
						}else{
							alert(bedHttpRequest.status);
						}
					}
					bedHttpRequest.send(bedHttpRequestBody);
				}


				function assignNavigate(instruction){
					const assign_bed_student = document.getElementById("assign-bed-student");
					
					if(instruction === "prev"){
						if((assign_bed_student.options.selectedIndex + 1) > 2){
							assign_bed_student.options[(assign_bed_student.options.selectedIndex - 1)].selected = true;
							assignBedStudent();
						}
					}

					if(instruction === "next"){
						if(assign_bed_student.options.length > (assign_bed_student.options.selectedIndex + 1)){
							assign_bed_student.options[(assign_bed_student.options.selectedIndex + 1)].selected = true;
							assignBedStudent();
						}
					}
				}
			</script>
            
        </center>
    </div>
<?php } ?> 

<?php } ?>