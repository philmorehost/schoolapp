<?php
	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
	<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'true'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				EXAM HALL LIST
			</button>
		</a>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_hall&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_hall'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD HALL
			</button>
		</a>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=exam_hall_receipt&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'exam_hall_receipt'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				EXAM HALL RECEIPT
			</button>
		</a>
	</div>
	
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
			$count_hall_listed = mysqli_num_rows($select_all_hall_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_hall_listed; ?> entries</span>
        	
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
						<td>Hall Name</td>
           				<td>Hall Numeric Value</td>
           				<td>Hall Capacity</td>
           				<td>Description</td>
           				<td style="width:10%;">Action</td>
           			</tr>
					<?php
						
						if(mysqli_num_rows($select_all_hall_table_lists) > 0){
							while(($hall_details = mysqli_fetch_assoc($select_hall_table_lists))){
								//$hall_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$hall_details["hall_numeric_name"];
								$hall_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$hall_details["hall_numeric_name"];
								echo '<tr>
									<td>
										<input type="checkbox" name="hall_id[]" value="'.$hall_details["hall_numeric_name"].'" class="classChecked" />
										<input hidden type="text" name="school_id[]" value="'.$hall_details["school_id_number"].'" />
									</td>
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Exam_hall.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.$hall_details["hall_name"].'</td>
                                    <td>'.$hall_details["hall_numeric_name"].'</td>
									<td>'.$hall_details["hall_capacity"].'</td>
									<td>'.checkIfEmpty($hall_details["description"]).'</td>
           							<td>
										<img onclick="return popUpAlert([`'.$hall_view_link.'`,``,`'.$hall_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
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
				<button name="delete-hall" type="submit" id="delHall" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Hall
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
					if(confirm("Are you sure you want to delete this Hall?")){
						document.getElementById("delHall").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Admin Staff");
						if(confirm("Are you sure you want to delete this hall?")){
							document.getElementById("delHall").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one hall");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data.php"); } ?>
<?php } ?>
<?php if(strip_tags($_GET['tab']) == 'exam_hall_receipt'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$view_session = array_filter(explode("_",trim(strip_tags($_GET['view']))))[0];
				$view_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['view']))))[1];
				$view_term_id_number = array_filter(explode("_",trim(strip_tags($_GET['view']))))[2];
				$view_subject_code = array_filter(explode("_",trim(strip_tags($_GET['view']))))[3];
			?>
			<?php if(((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
                
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-2">
                	<select name="session-class" class="form-select" required>
                		<option disabled hidden selected value="">Select Exam</option>
						<?php
							function classNameExamTable($class_info,$session_info,$school_id){
								global $connection_server;
							
								$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_info'");
								if(mysqli_num_rows($get_class_name) > 0){
									while($class_name_array = mysqli_fetch_array($get_class_name)){
										$class_name .= $class_name_array["class_name"]."";
									}
								}else{
									$class_name = "N/A";
								}
							
								return $class_name;
							}
							
							$select_exams_category_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name, session");
				
							if(mysqli_num_rows($select_exams_category_detail_using_id) > 0){
								while($exams_category_details = mysqli_fetch_assoc($select_exams_category_detail_using_id)){
									$select_exams_class_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$exams_category_details["numeric_class_name"]."' && session='".$exams_category_details["session"]."'");
									if(mysqli_num_rows($select_exams_class_detail_using_id) == 1){
										if(($exams_category_details["numeric_class_name"] == $view_numeric_class_name) && ($exams_category_details["session"] == $view_session)){
											$selected = "selected";
											echo '<option value="'.$exams_category_details["session"].'_'.$exams_category_details["numeric_class_name"].'" '.$selected.'>('.classNameExamTable($exams_category_details["numeric_class_name"], $exams_category_details["session"], $exams_category_details["school_id_number"]).') ('.str_replace("-","/",$exams_category_details["session"]).')</option>';
										}else{
											echo '<option value="'.$exams_category_details["session"].'_'.$exams_category_details["numeric_class_name"].'" >('.classNameExamTable($exams_category_details["numeric_class_name"], $exams_category_details["session"], $exams_category_details["school_id_number"]).') ('.str_replace("-","/",$exams_category_details["session"]).')</option>';
										}
									}
								}
							}
				
						?>
                	</select>
                	<span class="form-span mobile-font-size-12 system-font-size-14">Select Exam*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="term" class="form-select" required>
						<option disabled hidden selected value="">Select Term</option>
						<?php
							$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_terms_detail_using_id) > 0){
								while($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)){
									if($terms_details["id_number"] == $view_term_id_number){
										$selected = "selected";
										echo '<option value="'.$terms_details["id_number"].'" '.$selected.'>'.$terms_details["term_name"].'</option>';
									}else{
										echo '<option value="'.$terms_details["id_number"].'">'.$terms_details["term_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Term*</span>
				</div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="subject" class="form-select" required>
						<option disabled hidden selected value="">Select Subject</option>
						<?php

							function subjectName($subjects_info,$school_id){
								global $connection_server;
								
								$get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subjects_info'");
								if(mysqli_num_rows($get_subject_name) == 1){
									while($subject_name_array = mysqli_fetch_array($get_subject_name)){
										$subject_name .= $subject_name_array["subject_name"]." (".$subject_name_array["subject_code"].")";
									}
								}else{
									$subject_name = "N/A";
								}
								
								return $subject_name;
							}
							
							$select_exams_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY subject_code");
				
							if(mysqli_num_rows($select_exams_detail_using_id) > 0){
								while($exams_details = mysqli_fetch_assoc($select_exams_detail_using_id)){
									if($exams_details["subject_code"] == $view_subject_code){
										$selected = "selected";
										echo '<option value="'.$exams_details["subject_code"].'" '.$selected.'>'.subjectName($exams_details["subject_code"],$exams_details["school_id_number"]).'</option>';
									}else{
										echo '<option value="'.$exams_details["subject_code"].'">'.subjectName($exams_details["subject_code"],$exams_details["school_id_number"]).'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Subject*</span>
				</div>

                <button name="view-hall-info" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-2 mobile-margin-right-1 system-margin-right-2">
					SEARCH EXAM
                </button>
                
				<?php

					if(isset($_GET['view']) && !empty(trim(strip_tags($_GET['view'])))){
						$get_hall_time_table = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && subject_code='$view_subject_code' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session'");
						if(mysqli_num_rows($get_hall_time_table) >= 1){
							$show_hall_table = true;

						}else{
							$show_hall_table = false;
						}
					}else{
						$show_hall_table = false;
					}
				?>

				<?php if($show_hall_table === true){ ?>
                <div class="scroll-box bg-2 mobile-width-93 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                	<table class="table-tag mobile-font-size-12 system-font-size-14">
                		<tr>
                			<th>Exam</th>
			                <th>Class</th>
            			    <th>Section</th>
			                <th>Term</th>
			                <th>Start Date</th>
			                <th>End Date</th>
		                </tr>
						<?php
							function examSubjectName($subjects_info,$school_id){
								global $connection_server;
								
								$get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subjects_info'");
								if(mysqli_num_rows($get_subject_name) == 1){
									while($subject_name_array = mysqli_fetch_array($get_subject_name)){
										$subject_name .= $subject_name_array["subject_name"]." (".$subject_name_array["subject_code"].")";
									}
								}else{
									$subject_name = "N/A";
								}
								
								return $subject_name;
							}
							
							function className($class_info,$session_id,$school_id){
								global $connection_server;
								
								$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' && session='$session_id'");
								if(mysqli_num_rows($get_class_name) == 1){
									while($class_name_array = mysqli_fetch_array($get_class_name)){
										$class_name .= $class_name_array["class_name"]." (".$class_name_array["numeric_class_name"].")";
									}
								}else{
									$class_name = "N/A";
								}
								
								return $class_name;
							}
							
							function termName($terms_info,$school_id){
								global $connection_server;
								
								$get_term_name = mysqli_query($connection_server,"SELECT * FROM sm_terms WHERE school_id_number='$school_id' && id_number='$terms_info'");
								if(mysqli_num_rows($get_term_name) == 1){
									while($term_name_array = mysqli_fetch_array($get_term_name)){
										$term_name .= $term_name_array["term_name"]." (".$term_name_array["id_number"].")";
									}
								}else{
									$term_name = "N/A";
								}
								
								return $term_name;
							}
						
							if(mysqli_num_rows($get_hall_time_table) > 0){
								while(($hall_time_table_details = mysqli_fetch_assoc($get_hall_time_table))){
									echo 	'<tr>
												<td>'.examSubjectName($hall_time_table_details["subject_code"],$hall_time_table_details["school_id_number"]).'</td>
												<td>'.className($hall_time_table_details["numeric_class_name"],$hall_time_table_details["session"],$hall_time_table_details["school_id_number"]).'</td>
												<td>'.str_replace("-","/",$hall_time_table_details["session"]).'</td>
												<td>'.termName($hall_time_table_details["term_id_number"],$hall_time_table_details["school_id_number"]).'</td>
												<td>'.str_replace("-","/",$hall_time_table_details["exam_start_date"]).'</td>
												<td>'.str_replace("-","/",$hall_time_table_details["exam_end_date"]).'</td>
											</tr>';
								}
							}
						?>
	                </table>

                </div>
				<?php } ?>
            </form>
			
			<?php if($show_hall_table === true){ ?>
				<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select id="school-hall" name="hall" class="form-select" required>
						<option disabled hidden selected value="">Select Exam Hall</option>
						<?php
							$select_halls_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_halls_detail_using_id) > 0){
								while($halls_details = mysqli_fetch_assoc($select_halls_detail_using_id)){
									echo '<option value="'.$halls_details["hall_numeric_name"].'">'.$halls_details["hall_name"].'</option>';
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14"></span>
				</div><br>
				<div style="float: left; clear: left;" class="mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2">
					<div style="display: inline-block;" class="mobile-width-100 system-width-47 mobile-margin-left-5 system-margin-left-0 mobile-margin-right-1 system-margin-right-1">
						<span class="color-5 bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Not Assign Exam Hall Student List
						</span>
						<div style="float: left; clear: left;" class="mobile-width-93 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-right-2 system-margin-right-2">
							<div style="text-align: left;" class="scroll-box bg-2 mobile-width-100 system-width-100">
								<table id="all-student-not-assign-table" class="table-tag mobile-font-size-12 system-font-size-14">
									<tr>
										<th><input type="checkbox" onclick="checkAllStudents();" class="checkAllStudents" /></th>
										<th>Student Name</th>
										<th>Student Roll No</th>
									</tr>
								</table>
							</div>
							<button id="" onclick="assignExamHall();" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-2">
								ASSIGN EXAM HALL
                			</button>
						</div>
					</div>

					<div style="display: inline-block;" class="mobile-width-100 system-width-47 mobile-margin-left-5 system-margin-left-1 mobile-margin-right-1 system-margin-right-0">
						<span class="color-5 bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
							Assign Exam Hall Student List
						</span>
						<div style="float: left; clear: left;" class="mobile-width-93 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-right-2 system-margin-right-2">
							<div style="text-align: left;" class="scroll-box bg-2 mobile-width-100 system-width-100">
								<table id="all-student-assign-table" class="table-tag mobile-font-size-12 system-font-size-14">
									<tr>
										<th></th>
										<th>Student Name</th>
										<th>Student Roll No</th>
									</tr>
								</table>
							</div>
							<!--<button id="" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-0 system-margin-left-0 mobile-margin-right-1 system-margin-right-2">
								SEND MAIL
                			</button>-->
							
						</div>
					</div>
					<input hidden id="hall-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
					<input hidden id="hall-school-class" value="<?php echo $view_numeric_class_name; ?>" />
					<input hidden id="hall-school-class-session" value="<?php echo $view_session; ?>" />
					<input hidden id="hall-school-subject" value="<?php echo $view_subject_code; ?>" />
					<input hidden id="hall-school-term" value="<?php echo $view_term_id_number; ?>" />
		
					<script>
						function getAllStudentNotAssigned() {
							setInterval(() => {
								var all_student_not_assign_table = document.getElementById("all-student-not-assign-table");
								var school_hall = document.getElementById("school-hall");
								var hall_school_id_number = document.getElementById("hall-school-id");
								var hall_class_id = document.getElementById("hall-school-class");
								var hall_session_id = document.getElementById("hall-school-class-session");
								var hall_subject_id = document.getElementById("hall-school-subject");
								var hall_term_id = document.getElementById("hall-school-term");
								
								const subHallStudentHttpRequest = new XMLHttpRequest();
								subHallStudentHttpRequest.open("POST","./sql_get_student_subject_hall.php");
								subHallStudentHttpRequest.setRequestHeader("Content-Type","application/json");
								const subHallStudentHttpRequestBody = JSON.stringify({type: "not_assigned", school_id: hall_school_id_number.value, class: hall_class_id.value, session: hall_session_id.value, subject: hall_subject_id.value, term: hall_term_id.value});
								subHallStudentHttpRequest.onload = function(){
									if((subHallStudentHttpRequest.readyState == 4) && (subHallStudentHttpRequest.status == 200)){
										const subject_student_list_array = Object.entries(JSON.parse(subHallStudentHttpRequest.responseText)["response"]);
										var tableRowsLength = ((all_student_not_assign_table.getElementsByTagName("tr").length)-1);
										
										if(subject_student_list_array.length > tableRowsLength){
											all_student_not_assign_table.innerHTML = "";
											const createHallTableHead = document.createElement("tr");
											const createCheckBoxHead = document.createElement("input");
											createCheckBoxHead.type = "checkbox";
											createCheckBoxHead.className = "checkAllStudents";
											createCheckBoxHead.setAttribute("onclick","checkAllStudents()");
											const tableHeadTh_1 = createHallTableHead.appendChild(document.createElement("th"));
											const tableHeadTh_2 = createHallTableHead.appendChild(document.createElement("th"));
											const tableHeadTh_3 = createHallTableHead.appendChild(document.createElement("th"));
											tableHeadTh_1.appendChild(createCheckBoxHead);
											tableHeadTh_2.innerHTML = "Student Name";
											tableHeadTh_3.innerHTML = "Student Roll No";
											all_student_not_assign_table.appendChild(createHallTableHead);

											for(i=0; i < subject_student_list_array.length; i++){
												const createHallTableTr = document.createElement("tr");
												const createCheckBox = document.createElement("input");
												createCheckBox.type = "checkbox";
												createCheckBox.name = "student_id[]";
												createCheckBox.className = "studentChecked";
												createCheckBox.value = subject_student_list_array[i][1];
												const tableTd_1 = createHallTableTr.appendChild(document.createElement("td"));
												const tableTd_2 = createHallTableTr.appendChild(document.createElement("td"));
												const tableTd_3 = createHallTableTr.appendChild(document.createElement("td"));
												tableTd_1.appendChild(createCheckBox);
												tableTd_2.innerHTML = subject_student_list_array[i][0];
												tableTd_3.innerHTML = subject_student_list_array[i][1];
												all_student_not_assign_table.appendChild(createHallTableTr);
											}
										}

										if((subject_student_list_array.length === 0) && (tableRowsLength === 0)){
											const createHallTableTr = document.createElement("tr");
											const tableTd_1 = createHallTableTr.appendChild(document.createElement("td"));
											const tableTd_2 = createHallTableTr.appendChild(document.createElement("td"));
											const tableTd_3 = createHallTableTr.appendChild(document.createElement("td"));
											tableTd_1.innerHTML = "";
											tableTd_2.innerHTML = "No Student";
											tableTd_3.innerHTML = "";
											all_student_not_assign_table.appendChild(createHallTableTr);
										}
									}else{
										alert(subHallStudentHttpRequest.status);
									}
								}
								subHallStudentHttpRequest.send(subHallStudentHttpRequestBody);
							}, 1000);
						}

						function getAllStudentAssigned() {
							setInterval(() => {
								var all_student_assign_table = document.getElementById("all-student-assign-table");
								var school_hall = document.getElementById("school-hall");
								var hall_school_id_number = document.getElementById("hall-school-id");
								var hall_class_id = document.getElementById("hall-school-class");
								var hall_session_id = document.getElementById("hall-school-class-session");
								var hall_subject_id = document.getElementById("hall-school-subject");
								var hall_term_id = document.getElementById("hall-school-term");
								
								const subHallStudentHttpRequest = new XMLHttpRequest();
								subHallStudentHttpRequest.open("POST","./sql_get_student_subject_hall.php");
								subHallStudentHttpRequest.setRequestHeader("Content-Type","application/json");
								const subHallStudentHttpRequestBody = JSON.stringify({type: "assigned", school_id: hall_school_id_number.value, class: hall_class_id.value, session: hall_session_id.value, subject: hall_subject_id.value, term: hall_term_id.value});
								subHallStudentHttpRequest.onload = function(){
									if((subHallStudentHttpRequest.readyState == 4) && (subHallStudentHttpRequest.status == 200)){
										const subject_student_list_array = Object.entries(JSON.parse(subHallStudentHttpRequest.responseText)["response"]);
										var tableRowsLength = ((all_student_assign_table.getElementsByTagName("tr").length)-1);
										
										if(subject_student_list_array.length > tableRowsLength){
											all_student_assign_table.innerHTML = "";
											const createHallTableHead = document.createElement("tr");
											const tableHeadTh_1 = createHallTableHead.appendChild(document.createElement("th"));
											const tableHeadTh_2 = createHallTableHead.appendChild(document.createElement("th"));
											const tableHeadTh_3 = createHallTableHead.appendChild(document.createElement("th"));
											tableHeadTh_1.innerHTML = "";
											tableHeadTh_2.innerHTML = "Student Name";
											tableHeadTh_3.innerHTML = "Student Roll No";
											all_student_assign_table.appendChild(createHallTableHead);

											for(i=0; i < subject_student_list_array.length; i++){
												const createHallTableTr = document.createElement("tr");
												const createInputBox = document.createElement("input");
												createInputBox.type = "image";
												createInputBox.src = "imgfile/white/Delete.png";
												createInputBox.style.margin = "0 0 0 5px";
												createInputBox.setAttribute("onclick","removeStudentFromExamHall('"+subject_student_list_array[i][1]+"')");
												const tableTd_1 = createHallTableTr.appendChild(document.createElement("td"));
												const tableTd_2 = createHallTableTr.appendChild(document.createElement("td"));
												const tableTd_3 = createHallTableTr.appendChild(document.createElement("td"));
												tableTd_1.appendChild(createInputBox);
												tableTd_2.innerHTML = subject_student_list_array[i][0];
												tableTd_3.innerHTML = subject_student_list_array[i][1];
												all_student_assign_table.appendChild(createHallTableTr);
											}
										}

										if((subject_student_list_array.length === 0) && (tableRowsLength === 0)){
											const createHallTableTr = document.createElement("tr");
											const tableTd_1 = createHallTableTr.appendChild(document.createElement("td"));
											const tableTd_2 = createHallTableTr.appendChild(document.createElement("td"));
											const tableTd_3 = createHallTableTr.appendChild(document.createElement("td"));
											tableTd_1.innerHTML = "";
											tableTd_2.innerHTML = "No Student";
											tableTd_3.innerHTML = "";
											all_student_assign_table.appendChild(createHallTableTr);
										}
									}else{
										alert(subHallStudentHttpRequest.status);
									}
								}
								subHallStudentHttpRequest.send(subHallStudentHttpRequestBody);
							}, 1000);
						}
						
						getAllStudentNotAssigned();
						getAllStudentAssigned();

						function assignExamHall() {
							var all_student_not_assign_table = document.getElementById("all-student-not-assign-table");
							var all_student_assign_table = document.getElementById("all-student-assign-table");
							var school_hall = document.getElementById("school-hall");
							var hall_school_id_number = document.getElementById("hall-school-id");
							var hall_class_id = document.getElementById("hall-school-class");
							var hall_session_id = document.getElementById("hall-school-class-session");
							var hall_subject_id = document.getElementById("hall-school-subject");
							var hall_term_id = document.getElementById("hall-school-term");
							var allBoxToChecked = document.getElementsByClassName("studentChecked");

							checkBoxCount = 0;
							for(i = 0; i < allBoxToChecked.length; i++){
								if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
									checkBoxCount++;
								}
							}
							if(school_hall.value != "" && Number(school_hall.value)){
								if(checkBoxCount > 0){
									for(i = 0; i < allBoxToChecked.length; i++){
										if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
											const subHallStudentHttpRequest = new XMLHttpRequest();
											subHallStudentHttpRequest.open("POST","./sql_set_student_subject_hall.php");
											subHallStudentHttpRequest.setRequestHeader("Content-Type","application/json");
											const subHallStudentHttpRequestBody = JSON.stringify({type: "not_assigned", school_id: hall_school_id_number.value, hall_no: school_hall.value, class: hall_class_id.value, admission_number: allBoxToChecked[i].value, session: hall_session_id.value, subject: hall_subject_id.value, term: hall_term_id.value});
											
											subHallStudentHttpRequest.onload = function(){
												if((subHallStudentHttpRequest.readyState == 4) && (subHallStudentHttpRequest.status == 200)){
													const APIResponse = JSON.parse(subHallStudentHttpRequest.responseText)["response"];
													if(APIResponse != true){
														alert(APIResponse);
													}else{
														all_student_not_assign_table.innerHTML = "";
														getAllStudentNotAssigned();

														all_student_assign_table.innerHTML = "";
														getAllStudentAssigned();
													}
												}else{
													alert("Status: "+subHallStudentHttpRequest.status);
												}
											}
											subHallStudentHttpRequest.send(subHallStudentHttpRequestBody);
										}
									}	
								}else{
									alert("Please Select Atleast One Student");
								}
							}else{
								alert("Please Select Exam Hall");
							}
						}

						function removeStudentFromExamHall(customValue) {
							var all_student_not_assign_table = document.getElementById("all-student-not-assign-table");
							var all_student_assign_table = document.getElementById("all-student-assign-table");
							var school_hall = document.getElementById("school-hall");
							var hall_school_id_number = document.getElementById("hall-school-id");
							var hall_class_id = document.getElementById("hall-school-class");
							var hall_session_id = document.getElementById("hall-school-class-session");
							var hall_subject_id = document.getElementById("hall-school-subject");
							var hall_term_id = document.getElementById("hall-school-term");
							
							if(confirm("Are you sure your want to remove this student from Exam Hall")){
								const subHallStudentHttpRequest = new XMLHttpRequest();
								subHallStudentHttpRequest.open("POST","./sql_set_student_subject_hall.php");
								subHallStudentHttpRequest.setRequestHeader("Content-Type","application/json");
								const subHallStudentHttpRequestBody = JSON.stringify({type: "assigned", school_id: hall_school_id_number.value, hall_no: school_hall.value, class: hall_class_id.value, admission_number: customValue, session: hall_session_id.value, subject: hall_subject_id.value, term: hall_term_id.value});
								
								subHallStudentHttpRequest.onload = function(){
									if((subHallStudentHttpRequest.readyState == 4) && (subHallStudentHttpRequest.status == 200)){
										const APIResponse = JSON.parse(subHallStudentHttpRequest.responseText)["response"];
										if(APIResponse != true){
											alert(APIResponse);
										}else{
											all_student_not_assign_table.innerHTML = "";
											getAllStudentNotAssigned();

											all_student_assign_table.innerHTML = "";
											getAllStudentAssigned();
										}
									}else{
										alert("Status: "+subHallStudentHttpRequest.status);
									}
								}
								subHallStudentHttpRequest.send(subHallStudentHttpRequestBody);
							}
							
						}
					</script>
				</div>


				<script>
					function checkAllStudents(){
						var allBoxToChecked = document.getElementsByClassName("studentChecked");
						if(document.getElementsByClassName("studentChecked")[0].checked != true){
							for(i = 0; i < allBoxToChecked.length; i++){
								if(document.getElementsByClassName("checkAllStudents")[0].checked != true){
									document.getElementsByClassName("checkAllStudents")[0].checked = "checked";
								}
								document.getElementsByClassName("studentChecked")[i].checked = "checked";
							}
						}else{
							for(i = 0; i < allBoxToChecked.length; i++){
								if(document.getElementsByClassName("checkAllStudents")[0].checked == true){
									document.getElementsByClassName("checkAllStudents")[0].checked = false;
								}
								document.getElementsByClassName("studentChecked")[i].checked = false;
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
							if(confirm("Are you sure you want to delete this Hall?")){
								document.getElementById("delHall").click();
							}else{
								alert("Operation Cancelled");
							}
						}else{
							if(checkBoxCount > 1){
								//alert("You cannot pick more than one Admin Staff");
								if(confirm("Are you sure you want to delete this hall?")){
									document.getElementById("delHall").click();
								}else{
									alert("Operation Cancelled");
								}
							}else{
								alert("Pick atleast one hall");
							}
						}
							
					}
				</script>
			<?php } ?>
			
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php if(strip_tags($_GET['tab']) == 'add_hall'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_hall_numeric_name = trim(strip_tags($_GET['edit']));

				$edit_hall_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && hall_numeric_name='".$edit_hall_numeric_name."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_hall_checkmate) == 1)){
					if(mysqli_num_rows($edit_hall_checkmate) == 1){
						$edit_hall_detail = mysqli_fetch_array($edit_hall_checkmate);
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_hall_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
			
			<form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
					<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
						<?php echo $err_msg; ?>
					</div>
				<?php } ?>
				
				<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					HALL INFORMATION
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="hall-name" value="<?php echo $edit_hall_detail['hall_name']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Hall Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="hall-num-name" id="num-class-name" value="<?php echo $edit_hall_detail['hall_numeric_name']; ?>" type="text" pattern="[0-9]{1,}" title="Code must contain numbers only" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Hall Numeric Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="hall-capacity" id="stu-capacity" value="<?php echo $edit_hall_detail['hall_capacity']; ?>" type="number" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Hall Capacity*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="description" type="text" value="<?php echo $edit_hall_detail['description']; ?>"  placeholder="" class="form-input" />
					<span class="form-span mobile-font-size-12 system-font-size-14">Description</span>
				</div><br>
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_hall_checkmate) < 1)){ ?>
				<button name="add-hall" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					ADD HALL
				</button>
				<?php }else{ ?>
				<button name="update-hall" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					UPDATE HALL
				</button>
				<?php } ?>
				
			</form>

			<script>
				function findhallClassSession(){
					const find_hall_class_session = document.getElementById("find-hall-class-session");
					const add_hall_class_session = document.getElementById("add-hall-class-session");
					const hall_school_id_number = document.getElementById("hall-school-id");

					add_hall_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_hall_class_session.add(createSelectSessionOption);

					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: hall_school_id_number.value,class_id_no: find_hall_class_session.value});
					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_hall_class_session.add(createSelectOption);
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
<?php
		}
	}
	
?>
<?php } ?>