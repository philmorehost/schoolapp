<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_notification_statement_auth)) > 0){
			$count_notification_listed = mysqli_num_rows($select_all_notification_table_lists);
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
        		<span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_notification_listed; ?> entries</span>
        	
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
           				<td class="mobile-width-10 system-width-10">Notification</td>
						<td>Notification Title</td>
           				<td>Notification Message</td>
           				<?php
           					if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
           				?>
           				<td>Class</td>
           				<td>Session</td>
           				<td>Users</td>
           				<td style="width:10%;">Action</td>
           				<?php } ?>
           			</tr>
					<?php
						function notificationClassName($class_info,$school_id){
							global $connection_server;
							if($class_info == "all"){
								$class_name = $class_info;
							}else{
								$get_class_name = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class_info' GROUP BY numeric_class_name");
								if(mysqli_num_rows($get_class_name) == 1){
									while($class_name_array = mysqli_fetch_array($get_class_name)){
										$class_name .= $class_name_array["class_name"]." (".$class_name_array["numeric_class_name"].")";
									}
								}else{
									$class_name = "N/A";
								}
							}
							return $class_name;
						}
						
						function notificationUserName($user_info,$school_id){
							global $connection_server;
							if($user_info == "all"){
								$user_name = $user_info;
							}else{
								$get_user_name = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$user_info'");
								if(mysqli_num_rows($get_user_name) == 1){
									while($user_name_array = mysqli_fetch_array($get_user_name)){
										$user_name .= $user_name_array["firstname"]." ".$user_name_array["lastname"]." (".$user_name_array["admission_number"].")";
									}
								}else{
									$user_name = "N/A";
								}
							}
							return $user_name;
						}
						
						if(mysqli_num_rows($select_all_notification_table_lists) > 0){
							while(($notification_details = mysqli_fetch_assoc($select_notification_table_lists))){
								$notification_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$notification_details["notification_id"];
								$notification_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$notification_details["notification_id"];
								
								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="notification_id[]" value="'.$notification_details["notification_id"].'" class="notificationChecked" />
														<input hidden type="text" name="school_id[]" value="'.$notification_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>'.ucwords(notificationClassName($notification_details["numeric_class_name"], $notification_details["school_id_number"])).'</td>
													<td>'.ucwords(str_replace("-","/",$notification_details["session"])).'</td>
													<td>'.ucwords(notificationUserName($notification_details["user"], $notification_details["school_id_number"])).'</td>
													<td>
														<img onclick="return popUpAlert([``,``,`'.$notification_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}
								
								echo '<tr>
									'.$dcheck_button.'
									<td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/Notification.png" class="mobile-width-60 system-width-30" /></td>
									<td>'.$notification_details["title"].'
									<td>'.$notification_details["message"].'
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
				<button name="delete-notification" type="submit" id="delNotification" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
           			Delete Notification
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
				var allBoxToChecked = document.getElementsByClassName("notificationChecked");
				if(document.getElementsByClassName("notificationChecked")[0].checked != true){
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked != true){
							document.getElementsByClassName("checkALL")[0].checked = "checked";
						}
						document.getElementsByClassName("notificationChecked")[i].checked = "checked";
					}
				}else{
					for(i = 0; i < allBoxToChecked.length; i++){
						if(document.getElementsByClassName("checkALL")[0].checked == true){
							document.getElementsByClassName("checkALL")[0].checked = false;
						}
						document.getElementsByClassName("notificationChecked")[i].checked = false;
					}
				}
			}

			function deleteItems(){
				var allBoxToChecked = document.getElementsByClassName("notificationChecked");
				checkBoxCount = 0;
					for(i = 0; i < allBoxToChecked.length; i++){
						if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
							checkBoxCount++;
						}
					}
				if(checkBoxCount == 1){
					if(confirm("Are you sure you want to delete this notification?")){
						document.getElementById("delNotification").click();
					}else{
						alert("Operation Cancelled");
					}
				}else{
					if(checkBoxCount > 1){
						//alert("You cannot pick more than one notification");
						if(confirm("Are you sure you want to delete this notification?")){
							document.getElementById("delNotification").click();
						}else{
							alert("Operation Cancelled");
						}
					}else{
						alert("Pick atleast one notification");
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
<?php if(strip_tags($_GET['tab']) == 'add_notification'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
		<center>
			<?php
				$edit_notification_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && notification_id='".trim(strip_tags($_GET['edit']))."')");
				if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_notification_checkmate) == 1)){
					if(mysqli_num_rows($edit_notification_checkmate) == 1){
						$edit_notification_detail = mysqli_fetch_array($edit_notification_checkmate);
						$edit_notification_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
					}
				}
			?>
			<?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_notification_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    NOTIFICATION INFORMATION
                </div>
				
				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="numeric-class" onchange="findClassSession();" id="find-notification-class-session" class="form-select" required>
						<option selected disabled hidden value="">Select Class</option>
						<option value="all" <?php if($edit_notification_detail['numeric_class_name'] == 'all'){ echo 'selected'; } ?>>All</option>
						<?php
							$select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
							
							if(mysqli_num_rows($select_classes_detail_using_id) > 0){
								while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
									if($classes_details["numeric_class_name"] == $edit_notification_detail['numeric_class_name']){
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
					<select name="session" id="add-notification-class-session" onchange="findClassUsers();" class="form-select" required>
						<option disabled hidden selected value="">Select Class Session</option>
						<option value="all" <?php if($edit_notification_detail['session'] == 'all'){ echo 'selected'; } ?>>All</option>
						<?php
							$select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_notification_detail['numeric_class_name']."'");
							
							if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
								while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
									if($sessions_details["session"] == $edit_notification_detail['session']){
										$selected = "selected";
										echo '<option value="'.$sessions_details["session"].'" '.$selected.'>'.str_replace("-","/",$sessions_details["session"]).'</option>';
									}else{
										echo '<option value="'.$sessions_details["session"].'" >'.str_replace("-","/",$sessions_details["session"]).'</option>';
									}
									
								}
							}
				
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Class Session</span>
				</div>

				<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
					<select name="user" id="add-notification-user" class="form-select" required>
						<option disabled hidden selected value="">Select Users</option>
						<option value="all" <?php if($edit_notification_detail['user'] == 'all'){ echo 'selected'; } ?>>All</option>
						<?php
							if(($edit_notification_detail["numeric_class_name"] != "all") && ($edit_notification_detail["session"] != "all")){
								if((mysqli_num_rows($edit_notification_checkmate) == 1)){
									$select_users_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && current_class='".$edit_notification_detail['numeric_class_name']."' && session='".$edit_notification_detail['session']."'");
									
									if(mysqli_num_rows($select_users_detail_using_id) > 0){
										while($users_details = mysqli_fetch_assoc($select_users_detail_using_id)){
											if($users_details["admission_number"] == $edit_notification_detail['user']){
												$selected = "selected";
												echo '<option value="'.$users_details["admission_number"].'" '.$selected.'>'.$users_details["firstname"].' '.$users_details["lastname"].' ('.$users_details["admission_number"].')</option>';
											}else{
												echo '<option value="'.$users_details["admission_number"].'" >'.$users_details["firstname"].' '.$users_details["lastname"].' ('.$users_details["admission_number"].')</option>';
											}
											
										}
									}
								}
							}
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Select Users</span>
				</div>
				
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
				    <input name="title" value="<?php echo $edit_notification_detail['title']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Title*</span>
                </div>

                <div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
				    <textarea style="resize:none;" name="message" class="form-textarea" required><?php echo $edit_notification_detail['message']; ?></textarea>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Message*</span>
                </div>
				
				<input hidden id="notification-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
				
				<?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_notification_checkmate) < 1)){ ?>
                <button name="add-notification" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    ADD NOTIFICATION
				</button>
				<?php }else{ ?>
				<button name="update-notification" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
				    UPDATE NOTIFICATION
				</button>
				<?php } ?>
            </form>
			<script>
				function findClassSession(){
					const find_notification_class_session = document.getElementById("find-notification-class-session");
					const add_notification_class_session = document.getElementById("add-notification-class-session");
					const notification_school_id_number = document.getElementById("notification-school-id");
			
					add_notification_class_session.innerHTML = "";
					const createSelectSessionOption = document.createElement("option");
					createSelectSessionOption.hidden = false;
					createSelectSessionOption.disabled = false;
					createSelectSessionOption.selected = true;
					createSelectSessionOption.text = "All";
					createSelectSessionOption.value = "all";
					add_notification_class_session.add(createSelectSessionOption);
			
					const classSessionHttpRequest = new XMLHttpRequest();
					classSessionHttpRequest.open("POST","./get-class-session.php");
					classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
					const classSessionHttpRequestBody = JSON.stringify({sch_no: notification_school_id_number.value,class_id_no: find_notification_class_session.value});
					classSessionHttpRequest.onload = function(){
						if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
							
							const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
							
							for(i=0; i < session_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = session_list_array[i].replace("-","/");
								createSelectOption.value = session_list_array[i];
								add_notification_class_session.add(createSelectOption);
							}
						}else{
							alert(classSessionHttpRequest.status);
						}
					}
					classSessionHttpRequest.send(classSessionHttpRequestBody);
					
				}
				
				function findClassUsers(){
					const add_notification_user = document.getElementById("add-notification-user");
					const notification_school_id_number = document.getElementById("notification-school-id");
					const notification_class = document.getElementById("find-notification-class-session");
					const notification_session = document.getElementById("add-notification-class-session");
					if((notification_class.value.trim() != "") && (notification_session.value.trim() != "")){
					add_notification_user.innerHTML = "";
					const createSelectUsersOption = document.createElement("option");
					createSelectUsersOption.selected = true;
					createSelectUsersOption.text = "All";
					createSelectUsersOption.value = "all";
					add_notification_user.add(createSelectUsersOption);
					
					const classUsersHttpRequest = new XMLHttpRequest();
					classUsersHttpRequest.open("POST","./get-student.php");
					classUsersHttpRequest.setRequestHeader("Content-Type","application/json");
					const classUsersHttpRequestBody = JSON.stringify({sch_no: notification_school_id_number.value,class_id_no: notification_class.value, session: notification_session.value});
					classUsersHttpRequest.onload = function(){
						if((classUsersHttpRequest.readyState == 4) && (classUsersHttpRequest.status == 200)){
							const student_list_array = Object.entries(JSON.parse(classUsersHttpRequest.responseText)["response"]);
							
							for(i=0; i < student_list_array.length; i++){
								const createSelectOption = document.createElement("option");
								createSelectOption.text = student_list_array[i][1];
								createSelectOption.value = student_list_array[i][0];
								add_notification_user.add(createSelectOption);
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