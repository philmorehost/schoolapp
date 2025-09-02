	<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
		<?php
			if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=student_attendance&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'student_attendance'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				STUDENTS ATTENDANCE
			</button>
		</a>
		<?php } ?>
		<?php
			if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
		?>
		<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=teacher_attendance&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
			<button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'teacher_attendance'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
				TEACHERS ATTENDANCE
			</button>
		</a>
		<?php } ?>
	</div>

<?php
	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'student_attendance'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				if((isset($user_class_id_name_auth) && in_array(array_filter(explode("_",trim(strip_tags($_GET['view']))))[1],$user_class_id_name_auth)) || (($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff"))){
					$view_session = array_filter(explode("_",trim(strip_tags($_GET['view']))))[0];
					$view_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['view']))))[1];
					$view_date_taken = array_filter(explode("_",trim(strip_tags($_GET['view']))))[2];
				}
			?>
			<?php if(((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mobile-width-90 system-width-20 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<input name="date" type="date" placeholder="" max="<?php echo date('Y-m-d'); ?>" value="<?php if(isset($view_date_taken)){ echo $view_date_taken; }else{ echo date('Y-m-d'); } ?>" class="form-input" required/>
                	<span class="form-span mobile-font-size-12 system-font-size-14">Date*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-20 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findClassSession();" id="find-attendance-class-session" class="form-select" required>
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
				
				<div class="form-group mobile-width-90 system-width-20 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="session" id="add-attendance-class-session" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<?php
							if((!empty($view_session))){
								$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." && numeric_class_name='$view_numeric_class_name'");
								
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
                
				<input hidden id="attendance-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
                <button name="student-manage-attendance" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-21 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
                	TAKE/VIEW ATTENDANCE
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
						if(($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff")){
							$get_attendance_manage_attendance = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='$view_numeric_class_name' && date_taken='$view_date_taken' && session='$view_session'");
						}

						if(($user_identifier_auth_id == "teacher")){
							$get_attendance_manage_attendance = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." && date_taken='$view_date_taken' && session='$view_session'");
						}
						
						if(($user_identifier_auth_id == "stu_par")){
							$get_attendance_manage_attendance = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." && date_taken='$view_date_taken' && session='$view_session'");
							$all_input_box_readonly = "readonly";
						}
						
						if(($user_identifier_auth_id == "stu")){
							$get_attendance_manage_attendance = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." && admission_number='".$get_logged_user_details["admission_number"]."' && date_taken='$view_date_taken' && session='$view_session'");
							$all_input_box_readonly = "readonly";
						}

						if(mysqli_num_rows($get_attendance_manage_attendance) >= 1){
							$show_attendance_table = true;

						}else{
							$show_attendance_table = false;
						}
					}else{
						$show_attendance_table = false;
					}
				?>

				<?php if($show_attendance_table === true){ ?>
                <div class="scroll-box bg-2 mobile-width-96 system-width-96">
                	<table class="table-tag mobile-font-size-12 system-font-size-14">
                		<tr>
                			<th>Roll No</th>
			                <th>Name</th>
            			    <th>Attendance</th>
							<th>Comment</th>
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
							
							if(mysqli_num_rows($get_attendance_manage_attendance) > 0){
								while(($attendance_manage_attendance_details = mysqli_fetch_assoc($get_attendance_manage_attendance))){
                                    if($attendance_manage_attendance_details["attendance_remark"] == "present"){
                                        $attendance_present_checked = "checked";
                                        $attendance_absent_checked = "";
                                        $attendance_late_checked = "";
                                    }else{
                                        if($attendance_manage_attendance_details["attendance_remark"] == "absent"){
                                            $attendance_present_checked = "";
                                            $attendance_absent_checked = "checked";
                                            $attendance_late_checked = "";
                                        }else{
                                            if($attendance_manage_attendance_details["attendance_remark"] == "late"){
                                                $attendance_present_checked = "";
                                                $attendance_absent_checked = "";
                                                $attendance_late_checked = "checked";
                                            }
                                        }
                                    }

									if(($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher")){
										echo 	'<tr>
													<td>
														'.$attendance_manage_attendance_details["admission_number"].'
														<input hidden name="admission-number[]" value="'.$attendance_manage_attendance_details["admission_number"].'" type="text" pattern="[0-9]{1,}" title="Attendance must contain numbers only" placeholder="" class="form-input" readonly required/>	
													</td>
													<td>'.studentName($attendance_manage_attendance_details["admission_number"],$attendance_manage_attendance_details["school_id_number"]).'</td>
													<td>
														<div class="form-group mobile-width-20 system-width-100">
															<input name="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark" id="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark_1" value="present" type="radio" class="" '.$attendance_present_checked.' required/>
															<label for="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark_1" class="mobile-font-size-14 system-font-size-16 mobile-margin-right-1 system-margin-right-1">Present</label>

															<input name="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark" id="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark_2" value="absent" type="radio" class="" '.$attendance_absent_checked.' required/>
															<label for="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark_2" class="mobile-font-size-14 system-font-size-16 mobile-margin-right-1 system-margin-right-1">Absent</label>
														
															<input name="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark" id="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark_3" value="late" type="radio" class="" '.$attendance_late_checked.' required/>
															<label for="'.$attendance_manage_attendance_details["admission_number"].'_attendance_remark_3" class="mobile-font-size-14 system-font-size-16">Late</label>
														
														</div>
													</td>
													<td>
														<div class="form-group mobile-width-20 system-width-80">
															<input name="comment[]" value="'.$attendance_manage_attendance_details["comment"].'" type="text" placeholder="Comment" class="form-input" />
														</div>
													</td>
												</tr>';
									}
									
									if(($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
										echo 	'<tr>
													<td>
														'.$attendance_manage_attendance_details["admission_number"].'
													</td>
													<td>'.studentName($attendance_manage_attendance_details["admission_number"],$attendance_manage_attendance_details["school_id_number"]).'</td>
													<td>
														<div class="form-group mobile-width-20 system-width-100">
															<span class="mobile-font-size-14 system-font-size-16">'.checkIfEmpty(ucwords($attendance_manage_attendance_details["attendance_remark"])).'</span>
														</div>
													</td>
													<td>
														<div class="form-group mobile-width-20 system-width-80">
															<span class="mobile-font-size-14 system-font-size-16">'.checkIfEmpty($attendance_manage_attendance_details["comment"]).'</span>
														</div>
													</td>
												</tr>';
									}
								}
							}
						?>
	                </table>
                </div>
				<?php
					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
				?>
				<button name="save-student-attendance" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                	SAVE
                </button>
				<?php } ?>
				<?php } ?>
            </form>
			<script>
				function findClassSession(){
					const find_attendance_class_session = document.getElementById("find-attendance-class-session");
					const add_attendance_class_session = document.getElementById("add-attendance-class-session");
					const attendance_school_id_number = document.getElementById("attendance-school-id");
			
					add_attendance_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = true;
					createSelectSessionOption.disabled = true;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "Select Class Session";
					createSelectSessionOption.value = "";
					add_attendance_class_session.add(createSelectSessionOption);
			
					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: attendance_school_id_number.value,class_id_no: find_attendance_class_session.value});
					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_attendance_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					
				}
				
			</script>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?>

<?php
	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'teacher_attendance'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
            <?php
                $view_date_taken = array_filter(explode("_",trim(strip_tags($_GET['view']))))[0];
                
            ?>
            <?php if(((isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) !== "")) || ((!isset($_GET['view'])) && (trim(strip_tags($_GET['view'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="date" type="date" placeholder="" max="<?php echo date('Y-m-d'); ?>" value="<?php if(isset($view_date_taken)){ echo $view_date_taken; }else{ echo date('Y-m-d'); } ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Date*</span>
                </div>

                <button name="teacher-manage-attendance" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-3 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
                    TAKE/VIEW ATTENDANCE
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
                        $get_attendance_manage_attendance = mysqli_query($connection_server, "SELECT * FROM sm_teacher_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && date_taken='$view_date_taken'");
                        if(mysqli_num_rows($get_attendance_manage_attendance) >= 1){
                            $show_attendance_table = true;

                        }else{
                            $show_attendance_table = false;
                        }
                    }else{
                        $show_attendance_table = false;
                    }
                ?>

                <?php if($show_attendance_table === true){ ?>
                <div class="scroll-box bg-2 mobile-width-96 system-width-96">
                    <table class="table-tag mobile-font-size-12 system-font-size-14">
                        <tr>
                            <th>Roll No</th>
                            <th>Name</th>
                            <th>Attendance</th>
                            <th>Comment</th>
                        </tr>
                        <?php

                            function teacherName($teacher_info,$school_id){
                                global $connection_server;
                                
                                $get_teacher_name = mysqli_query($connection_server,"SELECT * FROM sm_teachers WHERE school_id_number='$school_id' && id_number='$teacher_info'");
                                if(mysqli_num_rows($get_teacher_name) == 1){
                                    while($teacher_name_array = mysqli_fetch_array($get_teacher_name)){
                                        $teacher_name .= $teacher_name_array["firstname"]." ".$teacher_name_array["lastname"];
                                    }
                                }else{
                                    $teacher_name = "N/A";
                                }
                                
                                return $teacher_name;
                            }
                            
                            if(mysqli_num_rows($get_attendance_manage_attendance) > 0){
                                while(($attendance_manage_attendance_details = mysqli_fetch_assoc($get_attendance_manage_attendance))){
                                    if($attendance_manage_attendance_details["attendance_remark"] == "present"){
                                        $attendance_present_checked = "checked";
                                        $attendance_absent_checked = "";
                                        $attendance_late_checked = "";
                                    }else{
                                        if($attendance_manage_attendance_details["attendance_remark"] == "absent"){
                                            $attendance_present_checked = "";
                                            $attendance_absent_checked = "checked";
                                            $attendance_late_checked = "";
                                        }else{
                                            if($attendance_manage_attendance_details["attendance_remark"] == "late"){
                                                $attendance_present_checked = "";
                                                $attendance_absent_checked = "";
                                                $attendance_late_checked = "checked";
                                            }
                                        }
                                    }
                                    echo    '<tr>
                                                <td>
                                                    '.$attendance_manage_attendance_details["teacher_id_number"].'
                                                    <input hidden name="id-number[]" value="'.$attendance_manage_attendance_details["teacher_id_number"].'" type="text" pattern="[0-9]{1,}" title="Attendance must contain numbers only" placeholder="" class="form-input" readonly required/>    
                                                </td>
                                                <td>'.teacherName($attendance_manage_attendance_details["teacher_id_number"],$attendance_manage_attendance_details["school_id_number"]).'</td>
                                                <td>
                                                    <div class="form-group mobile-width-20 system-width-100">
                                                        <input name="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark" id="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark_1" value="present" type="radio" class="" '.$attendance_present_checked.' required/>
                                                        <label for="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark_1" class="mobile-font-size-14 system-font-size-16 mobile-margin-right-1 system-margin-right-1">Present</label>

                                                        <input name="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark" id="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark_2" value="absent" type="radio" class="" '.$attendance_absent_checked.' required/>
                                                        <label for="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark_2" class="mobile-font-size-14 system-font-size-16 mobile-margin-right-1 system-margin-right-1">Absent</label>
                                                    
                                                        <input name="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark" id="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark_3" value="late" type="radio" class="" '.$attendance_late_checked.' required/>
                                                        <label for="'.$attendance_manage_attendance_details["teacher_id_number"].'_attendance_remark_3" class="mobile-font-size-14 system-font-size-16">Late</label>
                                                    
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mobile-width-20 system-width-80">
                                                        <input name="comment[]" value="'.$attendance_manage_attendance_details["comment"].'" type="text" placeholder="Comment" class="form-input" />
                                                    </div>
                                                </td>
                                            </tr>';
                                }
                            }
                        ?>
                    </table>
                </div>
                <button name="save-teacher-attendance" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    SAVE
                </button>
                <?php } ?>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?>
<?php } ?>
 