<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth)) > 0){
			$count_subject_listed = mysqli_num_rows($select_all_subject_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_subject_listed; ?> entries</span>
        	
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
                        <td>Teacher</td>
                        <td>Subject</td>
           				<td>Class</td>
						<td>Section</td>
						<?php
							if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
						?>
           				<td style="width:10%;">Action</td>
						<?php } ?>
           			</tr>
					<?php
						function subjectTeacherName($teachers_info,$school_id){
							global $connection_server;
							
							$teacher_id_explode = array_filter(explode("\n",trim($teachers_info)));
							$get_subject_teacher_name = mysqli_query($connection_server,"SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
							if(mysqli_num_rows($get_subject_teacher_name) > 0){
								while($teacher_name_array = mysqli_fetch_array($get_subject_teacher_name)){
									if(in_array($teacher_name_array["id_number"],$teacher_id_explode)){
										$view_teacher = str_replace('page='.trim(strip_tags($_GET["page"])),'page=smgt_teacher',str_replace('tab=true','tab=view_teacher',$_SERVER['REQUEST_URI']))."&view=".$teacher_name_array["id_number"];
										$teacher_name .= "<a style='text-decoration: none; color: inherit;' title='View Profile' href='".$view_teacher."'>".$teacher_name_array["firstname"]." ".$teacher_name_array["lastname"]."</a><br>";
									}
								}
							}else{
								$teacher_name = "N/A";
							}
							
							return $teacher_name;
						}

						if(mysqli_num_rows($select_all_subject_table_lists) > 0){
							while(($subject_details = mysqli_fetch_assoc($select_subject_table_lists))){
								//$subject_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$subject_details["session"]."_".$subject_details["numeric_class_name"]."_".$subject_details["subject_code"];
								$subject_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$subject_details["session"]."_".$subject_details["numeric_class_name"]."_".$subject_details["subject_code"];
								
								
								$get_subject_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE (school_id_number='".$subject_details["school_id_number"]."' && numeric_class_name='".$subject_details["numeric_class_name"]."' && session='".$subject_details["session"]."')");
								if(mysqli_num_rows($get_subject_class_name) == 1){
									
									$subject_class_detail = mysqli_fetch_array($get_subject_class_name);
									$subject_class = $subject_class_detail["class_name"]." (id: ".$subject_class_detail["numeric_class_name"].")";
								}else{
									$subject_class = "N/A";
								}

								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="subject_id[]" value="'.$subject_details["subject_code"].'" class="classChecked" />
														<input hidden type="text" name="session_id[]" value="'.$subject_details["session"].'" />
														<input hidden type="text" name="class_id[]" value="'.$subject_details["numeric_class_name"].'" />
														<input hidden type="text" name="school_id[]" value="'.$subject_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$subject_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}
								/*$mod_school_id = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
								$registered_classes = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE (school_id_number='".$mod_school_id["school_id_number"]."' && section='".$section_details["section"]."')");
								if(mysqli_num_rows($registered_classes) > 0){
									$count_registered_classes = mysqli_num_rows($registered_classes);
								}else{
									$count_registered_classes = "N/A";
								}*/
								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/Subject.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.subjectTeacherName($subject_details["teacher_id_number"],$subject_details["school_id_number"]).'</td>
                                    <td>'.$subject_details["subject_name"].' (code: '.$subject_details["subject_code"].')</td>
									<td>'.$subject_class.'</td>
									<td>'.str_replace("-","/",$subject_details["session"]).'</td>
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
				<button name="delete-subject" type="submit" id="delSubject" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Subject
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
					if(confirm("Are you sure you want to delete this Subject?")){
						document.getElementById("delSubject").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one Subject");
						if(confirm("Are you sure you want to delete this Subject?")){
							document.getElementById("delSubject").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one Subject");
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
<?php if(strip_tags($_GET['tab']) == 'add_subject'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_session = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[0];
				$edit_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[1];
				$edit_subject_code = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[2];

				$edit_subject_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && session='".$edit_session."' && numeric_class_name='".$edit_numeric_class_name."' && subject_code='".$edit_subject_code."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_subject_checkmate) == 1)){
					if(mysqli_num_rows($edit_subject_checkmate) == 1){
						$edit_subject_detail = mysqli_fetch_array($edit_subject_checkmate);
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_subject_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    SUBJECT INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="code" type="text" pattern="[0-9]{1,}" title="Code must contain numbers only" value="<?php echo $edit_subject_detail['subject_code']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject Code*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="name" type="text" value="<?php echo $edit_subject_detail['subject_name']; ?>" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
                </div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="class" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
				
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if(($classes_details["numeric_class_name"] == $edit_subject_detail['numeric_class_name']) && ($classes_details["session"] == $edit_subject_detail['session'])){
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
				
				<div class="form-group mobile-width-90 system-width-44 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<select name="teacher[]" class="sel-teacher" hidden multiple required>
						<option disabled hidden value="">Select Teacher</option>
						<?php
							if(isset($_SESSION["sup_adm_session"])){
								$select_teachers_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_teachers");
							}else{
								if(isset($_SESSION["mod_adm_session"])){
									$select_teachers_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
								}
							}
				
							if(mysqli_num_rows($select_teachers_detail_using_id) > 0){
								while($teachers_details = mysqli_fetch_assoc($select_teachers_detail_using_id)){
									if(in_array($teachers_details["id_number"],array_filter(explode("\n",trim($edit_subject_detail['teacher_id_number']))))){
										$selected = "selected";
										echo '<option value="'.$teachers_details["id_number"].'" '.$selected.'>'.$teachers_details["firstname"].' '.$teachers_details["lastname"].', (email: '.$teachers_details["email"].')</option>';
									}else{
										echo '<option value="'.$teachers_details["id_number"].'" >'.$teachers_details["firstname"].' '.$teachers_details["lastname"].', (email: '.$teachers_details["email"].')</option>';
									}
									
								}
							}
				
						?>
					</select>
					<!-- <span class="form-span mobile-font-size-12 system-font-size-14">Teacher*</span> -->
					<div class="form-div-container custom_form_div_select_sel-teacher">
						<div class="form-div custom_select_sel-teacher">
						</div>
						<script type="text/javascript">
							multipleOptionSelectTag("sel-teacher");
						</script>
					</div>
				</div><br/>
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_subject_checkmate) < 1)){ ?>
				<button name="add-subject" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD SUBJECT
				</button>
				<?php }else{ ?>
				<button name="update-subject" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
					UPDATE SUBJECT
				</button>
				<?php } ?>
            </form>
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 
<?php } ?> 