<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
	<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=homework_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'homework_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
			HOMEWORK LIST
		</button>
	</a>
	<?php
    	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") || ($user_identifier_auth_id == "stu")){
	?>
	<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=view_submission&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'view_submission'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
			VIEW SUBMISSION
		</button>
	</a>
	<?php } ?>

	<?php
   		if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
	?>
	<?php if(in_array(strip_tags($_GET['tab']),array("homework_list","add_homework"))){ ?>
	<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_homework&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_homework'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
			ADD HOMEWORK
		</button>
	</a>
	<?php } ?>
	<?php } ?>
	
	<?php
	    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id == "stu")){
	?>
	<?php if(in_array(strip_tags($_GET['tab']),array("sub_homework"))){ ?>
	<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=sub_homework&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
		<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'sub_homework'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
			SUBMIT HOMEWORK
		</button>
	</a>
	<?php } ?>
	
	<?php } ?>
</div>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'homework_list'){ ?>
<?php
    if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth)) > 0){
			$count_homework_list_listed = mysqli_num_rows($select_all_homework_table_lists);
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
    		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_homework_list_listed; ?> entries</span>
    	
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
						if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
					?>
					<td>Tick</td>
					<?php } ?>
       				<td class="mobile-width-10 system-width-10">Homework</td>
					<td>Title</td>
					<td>Class</td>
       				<td>Session</td>
       				<td>Subject</td>
					<td>Download</td>
       				<td>Content</td>
       				<?php
       					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") || ($user_identifier_auth_id == "stu")){
       				?>
					<td style="width:10%;">Action</td>
					<?php } ?>
       			</tr>
					<?php
					
						function homeworkClassName($class_info,$session_info,$school_id){
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
						
						function homeworkSubjectName($subject_info,$school_id){
							global $connection_server;
							
							$get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subject_info'");
							if(mysqli_num_rows($get_subject_name) == 1){
								while($subject_name_array = mysqli_fetch_array($get_subject_name)){
									$subject_name .= $subject_name_array["subject_name"];
								}
							}else{
								$subject_name = "N/A";
							}
							
							return $subject_name;
						}
						
						
						/*function homeworkTypeAmount($homework_info, $class_info, $session_info, $school_id){
							global $connection_server;
							
							$get_homework_amount = mysqli_query($connection_server,"SELECT * FROM sm_homework_lists WHERE school_id_number='$school_id' && homework_type_id='$homework_info' && numeric_class_name='$class_info' && session='$session_info'");
							if(mysqli_num_rows($get_homework_amount) == 1){
								while($homework_amount_array = mysqli_fetch_array($get_homework_amount)){
									$homework_amount .= $homework_amount_array["amount"];
								}
							}else{
								$homework_amount = "N/A";
							}
							
							return $homework_amount;
						}*/

						function createDownloadLink($download_link){
							if(!empty($download_link)){
								return '<a href="'.$download_link.'" style="cursor: pointer; text-decoration: underline; font-size: inherit; color: var(--color-4);" download>[Download File]</a>';
							}else{
								return "N/A";
							}
						}

						function createPopUpButton($title, $content){
							if(!empty($content)){
								return '<span onclick="return popUpSectionAlert(`txt`,`'.$title.'`,`'.$content.'`);" style="cursor: pointer; text-decoration: underline; font-size: inherit;" >View Content</span>';
							}else{
								return "N/A";
							}
						}
						if(mysqli_num_rows($select_all_homework_table_lists) > 0){
							while(($homework_list_details = mysqli_fetch_assoc($select_homework_table_lists))){
								$homework_list_view_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=view_homework',$_SERVER['REQUEST_URI'])."&view=".$homework_list_details["homework_id"];
								$homework_list_edit_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=add_homework',$_SERVER['REQUEST_URI'])."&edit=".$homework_list_details["homework_id"];
								$homework_list_submit_link = str_replace('tab='.trim(strip_tags($_GET['tab'])),'tab=sub_homework',$_SERVER['REQUEST_URI'])."&homework_id=".$homework_list_details["homework_id"];
								
								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="homework_id[]" value="'.$homework_list_details["homework_id"].'" class="homeworkListChecked" />
														<input hidden type="text" name="school_id[]" value="'.$homework_list_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$homework_list_edit_link.'`,``],[`View Homework`,``,`Edit Homework`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}

								if($user_identifier_auth_id == "stu"){
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$homework_list_submit_link.'`,``],[`View Homework`,``,`Submit Homework`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}
								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/white/Payment.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.$homework_list_details["title"].'</td>
									<td>'.homeworkClassName($homework_list_details["numeric_class_name"], $homework_list_details["session"], $homework_list_details["school_id_number"]).'</td>
									<td>'.str_replace("-","/",$homework_list_details["session"]).'</td>
       								<td>'.homeworkSubjectName($homework_list_details["subject_code"], $homework_list_details["school_id_number"]).'</td>
       								<td>'.createDownloadLink($homework_list_details["document_link"]).'</td>
       								<td>'.createPopUpButton($homework_list_details["document_title"], $homework_list_details["content"]).'</td>
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
					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
				?>
       		<button type="button" onclick="checkALL();" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
       			<input type="checkbox" onclick="checkALL();" class="checkALL" value="2" />
       			SELECT ALL
       		</button>
       		<a style="cursor: pointer;" onclick="deleteItems();">
       			<img src="imgfile/Delete.png" style="position: relative; height: 2.6rem; margin: 0 0 -14px 0; pointer-events: none;" class="mobile-width-12 system-width-5" />
       		</a>
				<button name="delete-homework" type="submit" id="delhomeworkPaymentList" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
       			Delete homework List
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
				var allBoxToChecked = document.getElementsByClassName("homeworkListChecked");
				if(document.getElementsByClassName("homeworkListChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("homeworkListChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("homeworkListChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("homeworkListChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this Record?")){
						document.getElementById("delhomeworkPaymentList").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Record");
						if(confirm("Are you sure you want to delete this Record?")){
							document.getElementById("delhomeworkPaymentList").click();
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
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'view_submission'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				//$view_session = array_filter(explode("_",trim(strip_tags($_GET['view']))))[0];
				//$view_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['view']))))[1];
				$view_homework = trim(strip_tags($_GET['view']));
				//$view_subject_code = array_filter(explode("_",trim(strip_tags($_GET['view']))))[3];
				
			?>
			<?php if(((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="homework-id" class="form-select" required>
						<option selected disabled hidden value="">Select Homework</option>
						<?php
							$select_homeworks_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." GROUP BY numeric_class_name");
											
							if(mysqli_num_rows($select_homeworks_detail_using_id) > 0){
								while($homeworks_details = mysqli_fetch_assoc($select_homeworks_detail_using_id)){
									if($homeworks_details["homework_id"] == $view_homework){
										$selected = "selected";
										echo '<option value="'.$homeworks_details["homework_id"].'" '.$selected.'>'.$homeworks_details["title"].'</option>';
									}else{
										echo '<option value="'.$homeworks_details["homework_id"].'" >'.$homeworks_details["title"].'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Homework</span>
				</div>
				
				<!--<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findClassSession();" id="find-homework-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." GROUP BY numeric_class_name");
				
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_name"] == $view_numeric_class_name){
										$selected = "selected";
										echo '<option value="'.$classes_details["numeric_class_name"].'" '.$selected.'>'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}else{
										echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Class</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="session" id="add-homework-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							if((!empty($view_session))){
								$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='$view_numeric_class_name'");
								
								if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
									while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
										if($sessions_details["session"] == $view_session){
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
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Session</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="subject-code" class="form-select" required>
						<option selected disabled hidden value="">Select Subject</option>
						<?php
							$select_homeworks_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth);
							
							if(mysqli_num_rows($select_homeworks_detail_using_id) > 0){
								while($homeworks_details = mysqli_fetch_assoc($select_homeworks_detail_using_id)){
									if($homeworks_details["subject_code"] == $view_subject_code){
										$selected = "selected";
										echo '<option value="'.$homeworks_details["subject_code"].'" '.$selected.'>'.$homeworks_details["subject_name"].' ('.$homeworks_details["subject_code"].')</option>';
									}else{
										echo '<option value="'.$homeworks_details["subject_code"].'" >'.$homeworks_details["subject_name"].' ('.$homeworks_details["subject_code"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
				</div>-->
				<input hidden id="homework-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
                <button name="view-submission" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                	VIEW SUBMISSION
                </button>
			</form>
			
			<form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
                
				<?php

					if(isset($_GET['view']) && !empty(trim(strip_tags($_GET['view'])))){
						$get_homework_manage_marks = mysqli_query($connection_server, "SELECT * FROM sm_submitted_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && homework_id_number='$view_homework' ".$user_admission_id_statement_auth);
						
						if(mysqli_num_rows($get_homework_manage_marks) >= 1){
							$show_homework_table = true;
						}else{
							$show_homework_table = false;
						}
					}else{
						$show_homework_table = false;
					}
				?>

				<?php if($show_homework_table === true){ ?>
                <div class="scroll-box bg-2 mobile-width-96 system-width-96">
                	<table class="table-tag mobile-font-size-12 system-font-size-14">
                		<tr>
                			<th>Roll No</th>
			                <th>Name</th>
            			    <th>File</th>
		                </tr>
						<?php

							function studentName($student_info,$school_id){
								global $connection_server;
								
								$get_student_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_info'");
								if(mysqli_num_rows($get_student_name) == 1){
									while($student_name_array = mysqli_fetch_array($get_student_name)){
										$student_name .= $student_name_array["firstname"]." ".$student_name_array["lastname"];
									}
								}else{
									$student_name = "N/A";
								}
								
								return $student_name;
							}
							
							function createDownloadLink($download_link){
								if(!empty($download_link)){
									return '<a href="'.$download_link.'" style="cursor: pointer; text-decoration: underline; font-size: inherit; color: var(--color-4);" download>[Download File]</a>';
								}else{
									return "N/A";
								}
							}
							
							if(mysqli_num_rows($get_homework_manage_marks) > 0){
								while(($homework_manage_marks_details = mysqli_fetch_assoc($get_homework_manage_marks))){
									echo 	'<tr>
												<td>
													'.$homework_manage_marks_details["admission_number"].'
												</td>
												<td>'.studentName($homework_manage_marks_details["admission_number"],$homework_manage_marks_details["school_id_number"]).'</td>
												<td>'.createDownloadLink($homework_manage_marks_details["document_link"]).'</td>
											</tr>';
								}
							}
						?>
	                </table>
                </div>
				<?php } ?>
            </form>
			<script>
				function findClassSession(){
					const find_homework_class_session = document.getElementById("find-homework-class-session");
					const add_homework_class_session = document.getElementById("add-homework-class-session");
					const homework_school_id_number = document.getElementById("homework-school-id");
			
					add_homework_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_homework_class_session.add(createSelectSessionOption);
			
					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: homework_school_id_number.value,class_id_no: find_homework_class_session.value});
					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_homework_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					
				}
				
				function findClassUsers(){
					const add_homework_user = document.getElementById("add-homework-user");
					const homework_school_id_number = document.getElementById("homework-school-id");
					const homework_class = document.getElementById("find-homework-class-session");
					const homework_session = document.getElementById("add-homework-class-session");
					if((homework_class.value.trim() != "") && (homework_session.value.trim() != "")){
					add_homework_user.innerHTML = "";
					const createSelectUsersOption = document.createElement("option");
					createSelectUsersOption.selected = true;
					createSelectUsersOption.text = "All";
					createSelectUsersOption.value = "all";
					add_homework_user.add(createSelectUsersOption);
					
					const classUsersHttpRequest = new XMLHttpRequest();
					classUsersHttpRequest.open("POST","./get-student.php");
					classUsersHttpRequest.setRequestHeader("Content-Type","application/json");
					const classUsersHttpRequestBody = JSON.stringify({sch_no: homework_school_id_number.value,class_id_no: homework_class.value, session: homework_session.value});
					classUsersHttpRequest.onload = function(){
						if((classUsersHttpRequest.readyState == 4) && (classUsersHttpRequest.status == 200)){
							const student_list_array = Object.entries(JSON.parse(classUsersHttpRequest.responseText)["response"]);
							
							for(i=0; i < student_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = student_list_array[i][1];
								createSelectOption.value = student_list_array[i][0];
								add_homework_user.add(createSelectOption);
							}
						}else{
							alert(classUsersHttpRequest.status);
						}
					}
					classUsersHttpRequest.send(classUsersHttpRequestBody);
					}
				}
			</script>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'sub_homework'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$checkmate_homework_list = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && homework_id='".trim(strip_tags($_GET['homework_id']))."'");;
				$checkmate_submitted_homework_list = mysqli_query($connection_server, "SELECT * FROM sm_submitted_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && homework_id_number='".trim(strip_tags($_GET['homework_id']))."' && admission_number='".$get_logged_user_details['admission_number']."'");;
				
			?>
			<?php if(isset($_GET['homework_id']) && (trim(strip_tags($_GET['homework_id'])) !== "") && (mysqli_num_rows($checkmate_homework_list) == 1)){ ?>
			<form method="post" enctype="multipart/form-data">
			<?php if(mysqli_num_rows($checkmate_submitted_homework_list) == 0){ ?>
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="file" type="file" accept=".jpg, .jpeg, .png" class="form-file-chooser"/>
					<span class="form-span mobile-font-size-12 system-font-size-14">Document File [Accepts Image]</span>
				</div>
				
				<input name="date-sub" type="date" placeholder="" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" hidden readonly required/>
				
                <button name="submit-homework" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
                	SUBMIT HOMEWORK
                </button>
			
			<?php }else{ ?>
				<span style="cursor: pointer;" class="color-7 mobile-font-size-12 system-font-size-14">Ooops, Homework already submitted.</span><br>
				
				<button onclick="delSubmittedHomework();" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
					DELETE SUBMITTED HOMEWORK
				</button>
				
				<button hidden name="rem-submitted-homework" id="rem-submitted-homework" type="submit">
					DELETE SUBMITTED HOMEWORK
				</button>
				
			<?php } ?>
            <?php } ?>
            </form>
        </center>
        <script>
        	function delSubmittedHomework(){
        		if(confirm("Do you want to delete this record?")){
        			document.getElementById("rem-submitted-homework").click();
        		}else{
        			alert("Operation cancelled");
        		}
        	}
        </script>
    </div>
<?php } ?> 
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_homework'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
	<center>
		<?php
			$edit_homework_id = trim(strip_tags($_GET['edit']));

			$edit_homework_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && homework_id='".$edit_homework_id."')");
			if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_homework_checkmate) == 1)){
				if(mysqli_num_rows($edit_homework_checkmate) == 1){
					$edit_homework_detail = mysqli_fetch_array($edit_homework_checkmate);
				}
			}
		?>
		<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_homework_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
		
		<form method="post" enctype="multipart/form-data">
			<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
				<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
					<?php echo $err_msg; ?>
				</div>
			<?php } ?>
			
			<div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
				HOMEWORK INFORMATION
			</div>
			
			<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				<input name="title" type="text" value="<?php echo $edit_homework_detail['title']; ?>"  placeholder="" class="form-input" required/>
				<span class="form-span mobile-font-size-12 system-font-size-14">Title*</span>
			</div>
			
			<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				<select name="numeric-class" onchange="findClassSession();" id="find-homework-class-session" class="form-select" required>
					<option selected disabled hidden value="">Select Class</option>
					<?php
						$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." GROUP BY numeric_class_name");
						
						if(mysqli_num_rows($select_classes_detail_using_id) > 0){
							while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
								if($classes_details["numeric_class_name"] == $edit_homework_detail["numeric_class_name"]){
									$selected = "selected";
									echo '<option value="'.$classes_details["numeric_class_name"].'" '.$selected.'>'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
								}else{
									echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
								}
								
							}
						}
			
					?>
				</select>
				<span class="form-span mobile-font-size-12 system-font-size-14">Select Class*</span>
			</div>
			
			<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				<select name="class-session" id="add-homework-class-session" class="form-select" required>
					<option disabled hidden selected value="">Select Class Session</option>
					<?php
						if(mysqli_num_rows($edit_homework_checkmate) == 1){
							$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_homework_detail["numeric_class_name"]."'");
							
							if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
								while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
									if($sessions_details["session"] == $edit_homework_detail["session"]){
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
				<span class="form-span mobile-font-size-12 system-font-size-14">Class Session*</span>
			</div>
			
			<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				<select name="subject-code" class="form-select" required>
					<option selected disabled hidden value="">Select Subject</option>
					<?php
						$select_homeworks_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth);
						
						if(mysqli_num_rows($select_homeworks_detail_using_id) > 0){
							while($homeworks_details = mysqli_fetch_assoc($select_homeworks_detail_using_id)){
								if($homeworks_details["subject_code"] == $edit_homework_detail["subject_code"]){
									$selected = "selected";
									echo '<option value="'.$homeworks_details["subject_code"].'" '.$selected.'>'.$homeworks_details["subject_name"].' ('.$homeworks_details["subject_code"].')</option>';
								}else{
									echo '<option value="'.$homeworks_details["subject_code"].'" >'.$homeworks_details["subject_name"].' ('.$homeworks_details["subject_code"].')</option>';
								}
								
							}
						}
			
					?>
				</select>
				<span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
			</div>
			<input hidden id="homework-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" /><br>
                
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                	HOMEWORK DOCUMENT
                </div>

			
			<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				<input name="document-title" type="text" value="<?php echo $edit_homework_detail['document_title']; ?>"  placeholder="" class="form-input" />
				<span class="form-span mobile-font-size-12 system-font-size-14">Document Title</span>
			</div>
			
			<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				<input name="file" type="file" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .pptx, .xlsx" class="form-file-chooser"/>
				<span class="form-span mobile-font-size-12 system-font-size-14">Document File [Accepts Image, Doc Files, PDF]</span>
				<?php
					if(mysqli_num_rows($edit_homework_checkmate) == 1){
						if(!empty($edit_homework_detail['document_link']) && file_exists($edit_homework_detail['document_link'])){
							echo '<a href="'.$edit_homework_detail['document_link'].'">'.$edit_homework_detail['document_title'].'</a>';
						}
					}
				?>
			</div>
			
			<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
				<input name="sub-date" type="date" value="<?php echo $edit_homework_detail['submission_date']; ?>" class="form-input" required/>
				<span class="form-span mobile-font-size-12 system-font-size-14">Submission Date*</span>
			</div><br>
			
			<div style="float: left; clear: left; text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
				HOMEWORK CONTENT
			</div>
			
			<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
				<textarea style="height: 12rem; resize: none;" name="content" class="form-textarea" ><?php echo $edit_homework_detail['content']; ?></textarea>
				<span class="form-span mobile-font-size-12 system-font-size-14">Content</span>
			</div>
			
                

			<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_homework_checkmate) < 1)){ ?>
			<button name="add-homework" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				ADD HOMEWORK
			</button>
			<?php }else{ ?>
			<button name="update-homework" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				UPDATE HOMEWORK
			</button>
			<?php } ?>
			
		</form>

		<script>
			function findClassSession(){
				const find_homework_class_session = document.getElementById("find-homework-class-session");
				const add_homework_class_session = document.getElementById("add-homework-class-session");
				const homework_school_id_number = document.getElementById("homework-school-id");
		
				add_homework_class_session.innerHTML = "";
				const createSelectSessionOption = document.createElement("option");
				createSelectSessionOption.hidden = true;
				createSelectSessionOption.disabled = true;
				createSelectSessionOption.selected = true;
				createSelectSessionOption.text = "Select Class Session";
				createSelectSessionOption.value = "";
				add_homework_class_session.add(createSelectSessionOption);
				
				const classSessionHttpRequest = new XMLHttpRequest();
				classSessionHttpRequest.open("POST","./get-class-session.php");
				classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
				const classSessionHttpRequestBody = JSON.stringify({sch_no: homework_school_id_number.value,class_id_no: find_homework_class_session.value});
				classSessionHttpRequest.onload = function(){
					if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
						
						const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
						
						for(i=0; i < session_list_array.length; i++){
							const createSelectOption = document.createElement("option");
							createSelectOption.text = session_list_array[i].replace("-","/");
							createSelectOption.value = session_list_array[i];
							add_homework_class_session.add(createSelectOption);
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