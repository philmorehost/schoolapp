<?php
	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'view_result'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$view_session = array_filter(explode("_",trim(strip_tags($_GET['view']))))[0];
				$view_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['view']))))[1];
				$view_term_id_number = array_filter(explode("_",trim(strip_tags($_GET['view']))))[2];
				$view_admission_number = array_filter(explode("_",trim(strip_tags($_GET['view']))))[3];
				
			?>
			<?php if(((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findResultClassSession(); resultClassSession();" id="find-result-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							
							$select_class_list_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_admission_id_statement_auth." GROUP BY numeric_class_name");
							
							if(mysqli_num_rows($select_class_list_detail_using_id) > 0){
								while($class_list_details = mysqli_fetch_assoc($select_class_list_detail_using_id)){
									$class_numeric_names .= "numeric_class_name='".$class_list_details["numeric_class_name"]."'"."\n";
								}
							}
							
							$class_numeric_names_sqli_statements .= " && (".str_replace("\n"," OR ", trim($class_numeric_names)).")";
							
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$class_numeric_names_sqli_statements." GROUP BY numeric_class_name");
							
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
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
				</div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="session" onchange="findClassSessionStudent(); resultClassSession();" id="add-result-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							/*if(isset($view_numeric_class_name)){
								$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$view_numeric_class_name."'");
								
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
							}*/
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
				</div>
				
				<?php
					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id != "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") && ($user_identifier_auth_id != "stu")){
				?>
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="admission-number" id="student-roll-id" class="form-select" required>
						<option disabled hidden selected value="">Select Student</option>
						<?php
							/*if(isset($view_admission_number)){
								$select_students_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$view_numeric_class_name."' && session='".$view_session."'");
								
								if(mysqli_num_rows($select_students_detail_using_id) > 0){
									while($students_details = mysqli_fetch_assoc($select_students_detail_using_id)){
										$get_student_name = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && admission_number='".$students_details["admission_number"]."' LIMIT 1"));
										if($students_details["admission_number"] == $view_admission_number){
											$selected = "selected";
											echo '<option value="'.$students_details["admission_number"].'" '.$selected.'>'.$get_student_name["firstname"].' '.$get_student_name["lastname"].' '.$get_student_name["othername"].'</option>';
										}else{
											echo '<option value="'.$students_details["admission_number"].'" >'.$get_student_name["firstname"].' '.$get_student_name["lastname"].' '.$get_student_name["othername"].'</option>';
										}
										
									}
								}
							}*/
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Student*</span>
				</div>
				<?php } ?>
				
				<div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
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
					<span class="form-span mobile-font-size-12 system-font-size-14">Term</span>
				</div>
				
				<input hidden id="result-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<button name="view-result" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                	PROCEED
                </button>
			</form>
			
			<script>
				function findResultClassSession(){
					const find_result_class_session = document.getElementById("find-result-class-session");
					const add_result_class_session = document.getElementById("add-result-class-session");
					const result_school_id_number = document.getElementById("result-school-id");
				
					add_result_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_result_class_session.add(createSelectSessionOption);
				
					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value});
				
					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_result_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					findClassSessionStudent();
				}
				
				function findClassSessionStudent(){
					const find_result_class_session = document.getElementById("find-result-class-session");
					const add_result_class_session = document.getElementById("add-result-class-session");
					const student_roll_id = document.getElementById("student-roll-id");
					
					const result_school_id_number = document.getElementById("result-school-id");
				
					student_roll_id.innerHTML = "";
					const createSelectStudentOption = document.createElement("option");
					createSelectStudentOption.hidden = true;
					createSelectStudentOption.disabled = true;
					createSelectStudentOption.selected = true;
					createSelectStudentOption.text = "Select Student";
					createSelectStudentOption.value = "";
					student_roll_id.add(createSelectStudentOption);
				
					const classSessionStudentHttpRequest = new XMLHttpRequest();
					classSessionStudentHttpRequest.open("POST","./get-students-result-list.php");
					classSessionStudentHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionStudentHttpRequestBody = JSON.stringify({sch_no: result_school_id_number.value, class_id_no: find_result_class_session.value, session: add_result_class_session.value, student: `<?php echo $user_admission_id_statement_auth; ?>`});
					classSessionStudentHttpRequest.onload = function(){
						if((classSessionStudentHttpRequest.readyState == 4) && (classSessionStudentHttpRequest.status == 200)){
							
							const student_list_array = Object.entries(JSON.parse(classSessionStudentHttpRequest.responseText)["response"]);
							
							for(i=0; i < student_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = student_list_array[i][1];
								createSelectOption.value = student_list_array[i][0];
								student_roll_id.add(createSelectOption);
							}
						}else{
							alert(classSessionStudentHttpRequest.status);
						}
					}
					classSessionStudentHttpRequest.send(classSessionStudentHttpRequestBody);
				}
				
			</script>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?>