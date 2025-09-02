	<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
		<?php
			if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=true&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'true'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				EXAM LIST
			</button>
		</a>
		<?php } ?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=time_table&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'time_table'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				EXAM TIME TABLE
			</button>
		</a>
		<?php
        	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
    	?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_exam&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_exam'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				ADD EXAM
			</button>
		</a>
		<?php } ?>
	</div>

<?php
	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth)) > 0){
			$count_exam_listed = mysqli_num_rows($select_all_exam_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_exam_listed; ?> entries</span>
        	
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
           				<td class="mobile-width-10 system-width-10">Photo</td>
                        <td>Exam</td>
           				<td>Class</td>
						<td>Section</td>
						<td>Term</td>
						<td>Start Date</td>
						<td>End Date</td>
						<td>Exam Comment</td>
						<?php
							if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
						?>
           				<td style="width:10%;">Action</td>
           				<?php } ?>
           			</tr>
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
						
						if(mysqli_num_rows($select_all_exam_table_lists) > 0){
							while(($exam_details = mysqli_fetch_assoc($select_exam_table_lists))){
								//$exam_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$exam_details["subject_code"]."_".$exam_details["numeric_class_name"]."_".$exam_details["session"]."_".$exam_details["term_id_number"];
								$exam_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$exam_details["subject_code"]."_".$exam_details["numeric_class_name"]."_".$exam_details["session"]."_".$exam_details["term_id_number"];
								/*$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE email='".$_SESSION["mod_adm_session"]."'"));
								$registered_classes = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && section='".$section_details["section"]."')");
								if(mysqli_num_rows($registered_classes) > 0){
									$count_registered_classes = mysqli_num_rows($registered_classes);
								}else{
									$count_registered_classes = "N/A";
								}*/
								
								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="exam_id[]" value="'.$exam_details["subject_code"].'" class="classChecked" />
														<input hidden type="text" name="class_id[]" value="'.$exam_details["numeric_class_name"].'" />
														<input hidden type="text" name="session_id[]" value="'.$exam_details["session"].'" />
														<input hidden type="text" name="term_id[]" value="'.$exam_details["term_id_number"].'" />
														<input hidden type="text" name="school_id[]" value="'.$exam_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([`'.$exam_view_link.'`,``,`'.$exam_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}
								
								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Exam_hall.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.subjectName($exam_details["subject_code"],$exam_details["school_id_number"]).'</td>
                                    <td>'.className($exam_details["numeric_class_name"],$exam_details["session"],$exam_details["school_id_number"]).'</td>
									<td>'.str_replace("-","/",$exam_details["session"]).'</td>
									<td>'.termName($exam_details["term_id_number"],$exam_details["school_id_number"]).'</td>
									<td>'.str_replace("-","/",$exam_details["exam_start_date"]).'</td>
									<td>'.str_replace("-","/",$exam_details["exam_end_date"]).'</td>
									<td>'.checkIfEmpty($exam_details["exam_comment"]).'</td>
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
				<button name="delete-exam" type="submit" id="delExam" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Exam
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
					if(confirm("Are you sure you want to delete this Exam?")){
						document.getElementById("delExam").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Admin Staff");
						if(confirm("Are you sure you want to delete this Exam?")){
							document.getElementById("delExam").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Exam");
					}
				}
					
			}
		</script>
	</div>
    <?php }else{ include("include/no-data.php"); } ?>
<?php } ?>
<?php } ?>


<?php if(strip_tags($_GET['tab']) == 'time_table'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$view_session = array_filter(explode("_",trim(strip_tags($_GET['view']))))[0];
				$view_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['view']))))[1];
				$view_term_id_number = array_filter(explode("_",trim(strip_tags($_GET['view']))))[2];
				
			?>
			<?php if(((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
                
                <div class="form-group mobile-width-55 system-width-40 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-2">
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
							
							$select_exams_category_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." GROUP BY numeric_class_name, session");
				
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
                
				<div class="form-group mobile-width-30 system-width-22 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
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
					<span class="form-span mobile-font-size-12 system-font-size-14">Exam Term*</span>
				</div>

                <button name="view-exam-time-table" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-90 system-width-26 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
                	MANAGE EXAM TIME
                </button>
                
				<?php

					if(isset($_GET['view']) && !empty(trim(strip_tags($_GET['view'])))){
						$get_exam_time_table = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='$view_numeric_class_name' && term_id_number='$view_term_id_number' && session='$view_session'");
						if(mysqli_num_rows($get_exam_time_table) >= 1){
							$show_exam_table = true;

						}else{
							$show_exam_table = false;
						}
					}else{
						$show_exam_table = false;
					}
				?>

				<?php if($show_exam_table === true){ ?>
                <div class="scroll-box bg-2 mobile-width-96 system-width-96">
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
						
							if(mysqli_num_rows($get_exam_time_table) > 0){
								while(($exam_time_table_details = mysqli_fetch_assoc($get_exam_time_table))){
									echo 	'<tr>
												<td>'.subjectName($exam_time_table_details["subject_code"],$exam_time_table_details["school_id_number"]).'</td>
												<td>'.className($exam_time_table_details["numeric_class_name"],$exam_time_table_details["session"],$exam_time_table_details["school_id_number"]).'</td>
												<td>'.str_replace("-","/",$exam_time_table_details["session"]).'</td>
												<td>'.termName($exam_time_table_details["term_id_number"],$exam_time_table_details["school_id_number"]).'</td>
												<td>'.str_replace("-","/",$exam_time_table_details["exam_start_date"]).'</td>
												<td>'.str_replace("-","/",$exam_time_table_details["exam_end_date"]).'</td>
											</tr>';
								}
							}
						?>
	                </table>
                </div>
				<?php } ?>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_exam'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_subject_code = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[0];
				$edit_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[1];
				$edit_session = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[2];
				$edit_term_id_number = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[3];

				$edit_exam_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && session='".$edit_session."' && numeric_class_name='".$edit_numeric_class_name."' && subject_code='".$edit_subject_code."' && term_id_number='".$edit_term_id_number."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_exam_checkmate) == 1)){
					if(mysqli_num_rows($edit_exam_checkmate) == 1){
						$edit_exam_detail = mysqli_fetch_array($edit_exam_checkmate);
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_exam_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
			
			<form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
					<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
						<?php echo $err_msg; ?>
					</div>
				<?php } ?>
				
				<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					EXAM INFORMATION
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="exam-code" class="form-select" required>
						<option selected disabled hidden value="">Select Subject</option>
						<?php
							$select_exams_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_exams_detail_using_id) > 0){
								while($exams_details = mysqli_fetch_assoc($select_exams_detail_using_id)){
									if($exams_details["subject_code"] == $edit_exam_detail['subject_code']){
										$selected = "selected";
										echo '<option value="'.$exams_details["subject_code"].'" '.$selected.'>'.$exams_details["subject_name"].' ('.$exams_details["subject_code"].')</option>';
									}else{
										echo '<option value="'.$exams_details["subject_code"].'" >'.$exams_details["subject_name"].' ('.$exams_details["subject_code"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Exam Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findExamClassSession();" id="find-exam-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
				
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_name"] == $edit_exam_detail['numeric_class_name']){
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
					<select name="class-session" id="add-exam-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							if((mysqli_num_rows($edit_exam_checkmate) == 1)){
								$select_exams_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_exam_detail['numeric_class_name']."'");
					
								if(mysqli_num_rows($select_exams_detail_using_id) > 0){
									while($exams_details = mysqli_fetch_assoc($select_exams_detail_using_id)){
										if($exams_details["session"] == $edit_exam_detail['session']){
											$selected = "selected";
											echo '<option value="'.$exams_details["session"].'" '.$selected.'>'.str_replace("-","/",$exams_details["session"]).'</option>';
										}else{
											echo '<option value="'.$exams_details["session"].'" >'.str_replace("-","/",$exams_details["session"]).'</option>';
										}
										
									}
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-35 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="term-id-name" id="select-exam-term-id" class="form-select" required>
						<option disabled hidden selected value="">Select Term</option>
						<?php
							$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_terms_detail_using_id) > 0){
								while($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)){
									if($terms_details["id_number"] == $edit_exam_detail['term_id_number']){
										$selected = "selected";
										echo '<option value="'.$terms_details["id_number"].' '.$terms_details["term_name"].'" '.$selected.'>'.$terms_details["term_name"].'</option>';
									}else{
										echo '<option value="'.$terms_details["id_number"].' '.$terms_details["term_name"].'">'.$terms_details["term_name"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Exam Term*</span>
				</div>
				
				<?php $sch_id_numb = $get_logged_user_details["school_id_number"]; ?>
				<button onclick="largePopUp(`Add Term Category`,`Term Category Name*`,`ADD CATEGORY`,`select-exam-term-id`,`sm_terms`,`school_id_number='<?php echo $sch_id_numb; ?>' && id_number='null'`,`term_name`);" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-6 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD
				</button>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="pass-mark" type="text" value="<?php echo $edit_exam_detail['pass_mark']; ?>" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" required/>
					<span class="form-span mobile-font-size-12 system-font-size-14">Passing Marks*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="total-mark" type="text" value="<?php echo $edit_exam_detail['total_mark']; ?>" pattern="[0-9]{1,}" title="Mark must contain numbers only" placeholder="" class="form-input" required/>
					<span class="form-span mobile-font-size-12 system-font-size-14">Total Marks*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="start-date" type="date" value="<?php echo $edit_exam_detail['exam_start_date']; ?>" class="form-input" required/>
					<span class="form-span mobile-font-size-12 system-font-size-14">Exam Start Date*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="end-date" type="date" value="<?php echo $edit_exam_detail['exam_end_date']; ?>"  class="form-input" required/>
					<span class="form-span mobile-font-size-12 system-font-size-14">Exam End Date*</span>
				</div>
				
				<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<input name="exam-comment" type="text" value="<?php echo $edit_exam_detail['exam_comment']; ?>"  placeholder="" class="form-input" />
					<span class="form-span mobile-font-size-12 system-font-size-14">Exam Comment</span>
				</div><br/>
				<input hidden id="exam-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_exam_checkmate) < 1)){ ?>
				<button name="add-exam" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					ADD EXAM
				</button>
				<?php }else{ ?>
				<button name="update-exam" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					UPDATE EXAM
				</button>
				<?php } ?>
				
			</form>

			<script>
				function findExamClassSession(){
					const find_exam_class_session = document.getElementById("find-exam-class-session");
					const add_exam_class_session = document.getElementById("add-exam-class-session");
					const exam_school_id_number = document.getElementById("exam-school-id");

					add_exam_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_exam_class_session.add(createSelectSessionOption);

					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: exam_school_id_number.value,class_id_no: find_exam_class_session.value});
					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_exam_class_session.add(createSelectOption);
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