<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") && ($user_identifier_auth_id != "stu_par") || ($user_identifier_auth_id == "stu")){
?>
<?php if(strip_tags($_GET['tab']) == "true"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) > 0){
            $count_holiday_listed = mysqli_num_rows($select_all_holiday_table_lists);
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
                <span class="color-7 mobile-font-size-16 system-font-size-18">Showing <?php echo ((($page_pnum*$current_page_no)-$page_pnum)+1); ?> to <?php echo ($page_pnum*$current_page_no); ?> of <?php echo $count_holiday_listed; ?> entries</span>
            
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
                        <td class="mobile-width-10 system-width-10">Holiday</td>
                        <td>Holiday Title</td>
                        <td>Description</td>
                        <td>Holiday Start Date</td>
                        <td>Holiday End Date</td>
                        <td>Status</td>
                        <?php
                        	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
                        ?>
                        <td style="width:10%;">Action</td>
                        <?php } ?>
                    </tr>
                    <?php
                        function holidayClassName($class_info,$school_id){
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
                        if(mysqli_num_rows($select_all_holiday_table_lists) > 0){
                            while(($holiday_details = mysqli_fetch_assoc($select_holiday_table_lists))){
                                $holiday_view_link = str_replace('tab=true','tab='.$header_view_button,$_SERVER['REQUEST_URI'])."&view=".$holiday_details["holiday_id"];
                                $holiday_edit_link = str_replace('tab=true','tab='.$header_add_button,$_SERVER['REQUEST_URI'])."&edit=".$holiday_details["holiday_id"];
                                
								if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
									$dcheck_button = '<td>
														<input type="checkbox" name="holiday_id[]" value="'.$holiday_details["holiday_id"].'" class="holidayChecked" />
														<input hidden type="text" name="school_id[]" value="'.$holiday_details["school_id_number"].'" />
													</td>';
									$action_button = '<td>
														<img onclick="return popUpAlert([``,``,`'.$holiday_edit_link.'`,``],[`View`,``,`Edit`,``]);" src="imgfile/More.png" style="cursor: pointer;" class="onhover-bg-color-6 mobile-width-40 system-width-30" />
													</td>';
								}
								
                                echo '<tr>
                                    '.$dcheck_button.'
                                    <td><img style="position: relative; margin: -1.5% 0 0 -2%; background-color: #50C878; padding: 15%; border-radius: 15px;" src="imgfile/holiday.png" class="mobile-width-60 system-width-30" /></td>
                                    <td>'.$holiday_details["holiday_title"].'
                                    <td>'.checkIfEmpty($holiday_details["desc"]).'
                                    <td>'.str_replace("-","/",$holiday_details["start_date"]).'</td>
                                    <td>'.str_replace("-","/",$holiday_details["end_date"]).'</td>
                                    <td>'.ucwords($holiday_details["status"]).'</td>
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
                <button name="delete-holiday" type="submit" id="delHoliday" style="display: none;" class="color-2 bg-3 mobile-font-size-14 system-font-size-16 mobile-padding-left-5 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-2 mobile-margin-right-1 system-margin-right-1">
                    Delete holiday
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
                var allBoxToChecked = document.getElementsByClassName("holidayChecked");
                if(document.getElementsByClassName("holidayChecked")[0].checked != true){
                    for(i = 0; i < allBoxToChecked.length; i++){
                        if(document.getElementsByClassName("checkALL")[0].checked != true){
                            document.getElementsByClassName("checkALL")[0].checked = "checked";
                        }
                        document.getElementsByClassName("holidayChecked")[i].checked = "checked";
                    }
                }else{
                    for(i = 0; i < allBoxToChecked.length; i++){
                        if(document.getElementsByClassName("checkALL")[0].checked == true){
                            document.getElementsByClassName("checkALL")[0].checked = false;
                        }
                        document.getElementsByClassName("holidayChecked")[i].checked = false;
                    }
                }
            }

            function deleteItems(){
                var allBoxToChecked = document.getElementsByClassName("holidayChecked");
                checkBoxCount = 0;
                    for(i = 0; i < allBoxToChecked.length; i++){
                        if((allBoxToChecked[i].type == "checkbox") && (allBoxToChecked[i].checked == true)){
                            checkBoxCount++;
                        }
                    }
                if(checkBoxCount == 1){
                    if(confirm("Are you sure you want to delete this holiday?")){
                        document.getElementById("delHoliday").click();
                    }else{
                        alert("Operation Cancelled");
                    }
                }else{
                    if(checkBoxCount > 1){
                        //alert("You cannot pick more than one holiday");
                        if(confirm("Are you sure you want to delete this holiday?")){
                            document.getElementById("delHoliday").click();
                        }else{
                            alert("Operation Cancelled");
                        }
                    }else{
                        alert("Pick atleast one holiday");
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
<?php if(strip_tags($_GET['tab']) == 'add_holiday'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
            <?php
                $edit_holiday_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && holiday_id='".trim(strip_tags($_GET['edit']))."')");
                if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_holiday_checkmate) == 1)){
                    if(mysqli_num_rows($edit_holiday_checkmate) == 1){
                        $edit_holiday_detail = mysqli_fetch_array($edit_holiday_checkmate);
                        $edit_holiday_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
                    }
                }
            ?>
            <?php if(((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_holiday_checkmate) == 1)) || ((!isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) == "") && (isset($_GET['tab'])))){ ?>
            <form method="post" enctype="multipart/form-data">
                <?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
                    <div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                        <?php echo $err_msg; ?>
                    </div>
                <?php } ?>
                
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    HOLIDAY INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="holiday-title" value="<?php echo $edit_holiday_detail['holiday_title']; ?>" type="text" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Holiday Title*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="desc" value="<?php echo $edit_holiday_detail['description']; ?>" type="text" placeholder="" class="form-input" />
                    <span class="form-span mobile-font-size-12 system-font-size-14">Holiday Description</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="start-date" type="date" value="<?php echo $edit_holiday_detail['start_date']; ?>" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Start Date*</span>
                </div>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="end-date" type="date" value="<?php echo $edit_holiday_detail['end_date']; ?>"  class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">End Date*</span>
                </div>

                <?php if((isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) != "") || (mysqli_num_rows($edit_holiday_checkmate) == 1)){ ?>
                <div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
					<select name="status" class="form-select" required>
						<option disabled hidden selected value="">Select Status</option>
						<?php
							foreach(array("approve","not approve") as $status){
								if($status == $edit_holiday_detail["status"]){
									echo '<option selected value="'.$status.'">'.ucwords($status).'</option>';
								}else{
									echo '<option value="'.$status.'">'.ucwords($status).'</option>';
								}
							}
						?>
					</select>
					<span class="form-span mobile-font-size-12 system-font-size-14">Status*</span>
				</div>
                <?php } ?>

                <?php if((!isset($_GET['edit'])) || (trim(strip_tags($_GET['edit'])) == "") || (mysqli_num_rows($edit_holiday_checkmate) < 1)){ ?>
                <button name="add-holiday" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    ADD HOLIDAY
                </button>
                <?php }else{ ?>
                <button name="update-holiday" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    UPDATE HOLIDAY
                </button>
                <?php } ?>
            </form>
            
            <?php } ?>
            
        </center>
    </div>
<?php } ?> 

<?php } ?>