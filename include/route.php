<div style="" class="container-box bg-2  border-style-bottom-1 border-color-5 border-width-1 mobile-width-92 system-width-96 mobile-margin-top-1 system-margin-top-1 mobile-margin-left-5 system-margin-left-2">
    
    <a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=route_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'route_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2'; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
            CLASS TIME TABLE
        </button>
    </a>
    <!--<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=exam_list&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'exam_list'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            EXAM TIME TABLE
        </button>
    </a>-->
    <?php
        if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
    ?>
    <a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_class_time_table&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_class_time_table'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            ADD CLASS TIME TABLE
        </button>
    </a>
    <?php
        }
    ?>
    <!--<a style="text-decoration: none;" href="/bc-admin.php?page=<?php echo strip_tags($_GET['page']); ?>&tab=add_exam_time_table&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
        <button style="margin-bottom: -0.1px;" type="submit" class="button-box-2 <?php if(strip_tags($_GET['tab']) == 'add_exam_time_table'){ echo 'color-4 border-style-bottom-1 border-color-4 border-width-6 '; }else{ echo 'color-5 border-style-bottom-1 border-color-3 border-width-2 '; } ?> bg-3 text-bold-600 mobile-font-size-10 system-font-size-16 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-4 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">
            ADD EXAM TIME TABLE
        </button>
    </a>-->
</div>
<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") || ($user_identifier_auth_id == "teacher") || ($user_identifier_auth_id == "stu_par") || ($user_identifier_auth_id == "stu")){
?>
    <?php if(strip_tags($_GET['tab']) == "route_list"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) >= 0){
    ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
        <div style="text-align: left;" class="container-box bg-2 mobile-width-96 system-width-96">
            <?php

                function subjectName($subject_code,$school_id){
                    global $connection_server;
                    
                    
                    $get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subject_code'");
                    if(mysqli_num_rows($get_subject_name) > 0){
                        $subject_details = mysqli_fetch_array($get_subject_name);
                        $subject_name = $subject_details["subject_name"]." ";
                    }else{
                        $subject_name = "N/A";
                    }
                    
                    if($subject_name == true){
                        return $subject_name;
                    }else{
                        return "N/A";
                    }
                }

                function getClassRouteSubjectTime($day_info, $class_info, $school_id){
                    global $connection_server;  
                    global $user_identifier_auth_id;
                    $get_class_route_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_route_lists WHERE school_id_number='$school_id' && day_code='$day_info' && numeric_class_name='$class_info'");
                    if(mysqli_num_rows($get_class_route_subject_name) > 0){
                        while($class_route_id_array = mysqli_fetch_array($get_class_route_subject_name)){
                            $class_route_id_explode = array_filter(explode("\n",trim($class_route_id_array["subject_code"])));
                            if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
                                $subject_name .= "<br>".'<span class="mobile-font-size-14 system-font-size-16">'.subjectName($class_route_id_array["subject_code"], $school_id)." (".timeFrame($class_route_id_array["start_time"])." - ".timeFrame($class_route_id_array["end_time"]).")".'</span> <sup><a onclick="removeRouteSubject(`'.$class_route_id_array["subject_code"].'`,`'.$day_info.'`,`'.$class_info.'`,`'.$school_id.'`);" class="mobile-font-size-8 system-font-size-10" style="color: var(--color-4); text-decoration: underline; cursor: pointer;">[Remove]</a></sup>';
                            }else{
                                $subject_name .= "<br>".'<span class="mobile-font-size-14 system-font-size-16">'.subjectName($class_route_id_array["subject_code"], $school_id)." (".timeFrame($class_route_id_array["start_time"])." - ".timeFrame($class_route_id_array["end_time"]).")".'</span>';
                            }
                        }
                    }else{
                        $subject_name = "";
                    }
                    
                    if($subject_name == true){
                        return str_replace("","",trim(str_replace([""],"",$subject_name)));
                    }else{
                        return "";
                    }
                }
		
                $select_all_classes = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth."  GROUP BY numeric_class_name");
                if(mysqli_num_rows($select_all_classes) > 0){
                    while(($classes_details = mysqli_fetch_assoc($select_all_classes))){
                        echo 
                            '<div onclick="displayRouteTable(`class-'.$classes_details['numeric_class_name'].'`);" style="cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].'-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                                <span class="mobile-font-size-18 system-font-size-20"><strong>Class</strong>: '.$classes_details['class_name'].'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Monday</strong>: '.getClassRouteSubjectTime('1',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Tuesday</strong>: '.getClassRouteSubjectTime('2',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Wednesday</strong>: '.getClassRouteSubjectTime('3',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Thursday</strong>: '.getClassRouteSubjectTime('4',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Friday</strong>: '.getClassRouteSubjectTime('5',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Saturday</strong>: '.getClassRouteSubjectTime('6',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Sunday</strong>: '.getClassRouteSubjectTime('7',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>';
                    }
                }
            ?>
        </div>

        </center>
        <script>
            function displayRouteTable(class_id){
                const allClass_slider = document.getElementsByClassName(class_id+"-slide-btn")[0];
                const allClass = document.getElementsByClassName(class_id);
                    
                if(allClass[0].style.display == "none"){
                    allClass_slider.setAttribute("class", class_id+"-slide-btn container-box color-2 bg-5 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1");
                    for(i = 0; i < allClass.length; i++){
                        allClass[i].style.display = "inline-block";
                    }
                }else{
                    allClass_slider.setAttribute("class", class_id+"-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1");
                    for(i = 0; i < allClass.length; i++){
                        allClass[i].style.display = "none";
                    }
                }
            }

            function removeRouteSubject(subject_id,day_id,class_id,school_id){
                if(confirm("Do you want to delete this record?")){
                    const classRouteHttpRequest = new XMLHttpRequest();
                    classRouteHttpRequest.open("POST","./del-route.php");
                    classRouteHttpRequest.setRequestHeader("Content-Type","application/json");
                    const classRouteHttpRequestBody = JSON.stringify({sch_no: school_id, class_id_no: class_id, day: day_id, subject: subject_id});
                    classRouteHttpRequest.onload = function(){
                        if((classRouteHttpRequest.readyState == 4) && (classRouteHttpRequest.status == 200)){
                            const classRouteResponse = JSON.parse(classRouteHttpRequest.responseText)["response"];
                            if(classRouteResponse == 1){
                                alert("Success");
                                window.location.replace(window.location.href);
                            }else{
                                if(classRouteResponse == 2){
                                    alert("Error");
                                }
                            }
                        }else{
                            alert(classRouteHttpRequest.status);
                        }
                    }
                    classRouteHttpRequest.send(classRouteHttpRequestBody);
                }else{
                    alert("Operation cancelled");
                }
            }
        </script>
    </div>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>
<?php } ?>

<?php
    if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") || ($user_identifier_auth_id == "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['tab']) == 'add_class_time_table'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
            <?php
                $edit_route_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && route_id='".trim(strip_tags($_GET['edit']))."')");
                if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_route_list_checkmate) == 1)){
                    if(mysqli_num_rows($edit_route_list_checkmate) == 1){
                        $edit_route_list_detail = mysqli_fetch_array($edit_route_list_checkmate);
                        
                        $edit_route_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
                    }
                }
            ?>
            <form method="post" enctype="multipart/form-data">
            <?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
                    <div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                        <?php echo $err_msg; ?>
                    </div>
                <?php } ?>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="numeric-class" onchange="findRouteTypeClassSession();" id="find-route-type-class-session" class="form-select" required>
                        <option selected disabled hidden value="">Select Class</option>
                        <?php
                            $select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
                            
                            if(mysqli_num_rows($select_classes_detail_using_id) > 0){
                                while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
                                    echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ( '.$classes_details["numeric_class_name"].' )</option>';
                                }
                            }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
                </div>
                
                <!--<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="class-session" id="add-route-type-class-session" class="form-select" required>
                        <option disabled hidden selected value="">Select Class Session</option>
                        <?php
                            // if((mysqli_num_rows($edit_route_list_checkmate) == 1)){
                            //  if(isset($_SESSION["sup_adm_session"])){
                            //      $select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE numeric_class_name='".$edit_route_list_detail['numeric_class_name']."'");
                            //  }else{
                            //      if(isset($_SESSION["mod_adm_session"])){
                            //          $select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_route_list_detail['numeric_class_name']."'");
                            //      }
                            //  }
                    
                            //  if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
                            //      while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
                            //          if($sessions_details["session"] == $edit_route_list_detail['session']){
                            //              $selected = "selected";
                            //              echo '<option value="'.$sessions_details["session"].'" '.$selected.'>'.str_replace("-","/",$sessions_details["session"]).'</option>';
                            //          }else{
                            //              echo '<option value="'.$sessions_details["session"].'" >'.str_replace("-","/",$sessions_details["session"]).'</option>';
                            //          }
                                        
                            //      }
                            //  }
                            // }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
                </div>-->
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="subject-code" class="form-select" required>
                        <option selected disabled hidden value="">Select Subject</option>
                        <?php
                            $select_routes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
                           	
                            if(mysqli_num_rows($select_routes_detail_using_id) > 0){
                                while($routes_details = mysqli_fetch_assoc($select_routes_detail_using_id)){
                                    echo '<option value="'.$routes_details["subject_code"].'" >'.$routes_details["subject_name"].' ('.$routes_details["subject_code"].')</option>';
                                }
                            }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="day-code" class="form-select" required>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Day*</span>
                </div>
                
                <!--<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="term" class="form-select" required>
                        <option disabled hidden selected value="">Select Term</option>
                        <?php
                            //$select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
                
                            // if(mysqli_num_rows($select_terms_detail_using_id) > 0){
                            //  while($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)){
                            //      echo '<option value="'.$terms_details["id_number"].'">'.$terms_details["term_name"].'</option>';
                            //  }
                            // }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Term*</span>
                </div>-->

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="start-time" value="" type="time" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Start Time*</span>
                </div>

                <div style="float: left; clear: left;" class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    <input name="end-time" value="" type="time" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">End Time*</span>
                </div>
                
                <input hidden id="route-type-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
                
                <button name="add-route" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    ADD ROUTE
                </button>
                
            </form>
            <script>
                function findRouteTypeClassSession(){
                    const find_route_type_class_session = document.getElementById("find-route-type-class-session");
                    const add_route_type_class_session = document.getElementById("add-route-type-class-session");
                    const route_type_school_id_number = document.getElementById("route-type-school-id");

                    add_route_type_class_session.innerHTML = "";
                    const createSelectSessionOption = document.createElement("option");
                    createSelectSessionOption.hidden = true;
                    createSelectSessionOption.disabled = true;
                    createSelectSessionOption.selected = true;
                    createSelectSessionOption.text = "Select Class Session";
                    createSelectSessionOption.value = "";
                    add_route_type_class_session.add(createSelectSessionOption);

                    const classSessionHttpRequest = new XMLHttpRequest();
                    classSessionHttpRequest.open("POST","./get-class-session.php");
                    classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
                    const classSessionHttpRequestBody = JSON.stringify({sch_no: route_type_school_id_number.value, class_id_no: find_route_type_class_session.value});

                    classSessionHttpRequest.onload = function(){
                        if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
                            
                            const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
                            
                            for(i=0; i < session_list_array.length; i++){
                                const createSelectOption = document.createElement("option");
                                createSelectOption.text = session_list_array[i].replace("-","/");
                                createSelectOption.value = session_list_array[i];
                                add_route_type_class_session.add(createSelectOption);
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
<?php } ?>
<?php } ?>
<!--<?php if(strip_tags($_GET['tab']) == "exam_list"){ ?>
    <?php
        if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_exam_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."'")) >= 0){
    ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
        <div style="text-align: left;" class="container-box bg-2 mobile-width-96 system-width-96">
            <?php

                function subjectName($subject_code,$school_id){
                    global $connection_server;
                    
                    
                    $get_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_subjects WHERE school_id_number='$school_id' && subject_code='$subject_code'");
                    if(mysqli_num_rows($get_subject_name) > 0){
                        $subject_details = mysqli_fetch_array($get_subject_name);
                        $subject_name = $subject_details["subject_name"]." ";
                    }else{
                        $subject_name = "N/A";
                    }
                    
                    if($subject_name == true){
                        return $subject_name;
                    }else{
                        return "N/A";
                    }
                }

                function getClassExamSubjectTime($day_info, $class_info, $school_id){
                    global $connection_server;  
                    $get_class_exam_subject_name = mysqli_query($connection_server,"SELECT * FROM sm_exam_lists WHERE school_id_number='$school_id' && day_code='$day_info' && numeric_class_name='$class_info'");
                    if(mysqli_num_rows($get_class_exam_subject_name) > 0){
                        while($class_exam_id_array = mysqli_fetch_array($get_class_exam_subject_name)){
                            $class_exam_id_explode = array_filter(explode("\n",trim($class_exam_id_array["subject_code"])));
                            $subject_name .= "<br>".'<span class="mobile-font-size-14 system-font-size-16">'.subjectName($class_exam_id_array["subject_code"], $school_id)." ( ".formDateWithoutTime($class_exam_id_array["exam_date"])." ) ( ".timeFrame($class_exam_id_array["start_time"])." - ".timeFrame($class_exam_id_array["end_time"])." )".'</span> <sup><a onclick="removeExamSubject(`'.$class_exam_id_array["subject_code"].'`,`'.$day_info.'`,`'.$class_info.'`,`'.$school_id.'`);" class="mobile-font-size-8 system-font-size-10" style="color: var(--color-4); text-decoration: underline; cursor: pointer;">[Remove]</a></sup>';
                        }
                    }else{
                        $subject_name = "";
                    }
                    
                    if($subject_name == true){
                        return str_replace("","",trim(str_replace([""],"",$subject_name)));
                    }else{
                        return "";
                    }
                }

                $select_all_classes = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
                if(mysqli_num_rows($select_all_classes) > 0){
                    while(($classes_details = mysqli_fetch_assoc($select_all_classes))){
                        echo 
                            '<div onclick="displayExamTable(`class-'.$classes_details['numeric_class_name'].'`);" style="cursor: pointer; border-width: 0.5px 0.5px 0.5px 4px; border-style: solid solid solid solid; border-color: var(--color-5) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].'-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1">
                                <span class="mobile-font-size-18 system-font-size-20"><strong>Class</strong>: '.$classes_details['class_name'].' (Exam Time Table)</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Monday</strong>: '.getClassExamSubjectTime('1',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Tuesday</strong>: '.getClassExamSubjectTime('2',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Wednesday</strong>: '.getClassExamSubjectTime('3',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Thursday</strong>: '.getClassExamSubjectTime('4',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Friday</strong>: '.getClassExamSubjectTime('5',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Saturday</strong>: '.getClassExamSubjectTime('6',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>
                            <div style="display: none; border-width: 0px 0.5px 0.5px 4px; border-style: none solid solid solid; border-color: var(--color-3) var(--color-5) var(--color-5) var(--color-4);" class="class-'.$classes_details['numeric_class_name'].' container-box color-1 bg-2 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1">
                                <span class="mobile-font-size-16 system-font-size-18"><strong>Sunday</strong>: '.getClassExamSubjectTime('7',$classes_details['numeric_class_name'],$classes_details['school_id_number']).'</span>
                            </div>';
                    }
                }
            ?>
        </div>

        </center>
        <script>
            function displayExamTable(class_id){
                const allClass_slider = document.getElementsByClassName(class_id+"-slide-btn")[0];
                const allClass = document.getElementsByClassName(class_id);
                    
                if(allClass[0].style.display == "none"){
                    allClass_slider.setAttribute("class", class_id+"-slide-btn container-box color-2 bg-5 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1");
                    for(i = 0; i < allClass.length; i++){
                        allClass[i].style.display = "inline-block";
                    }
                }else{
                    allClass_slider.setAttribute("class", class_id+"-slide-btn container-box color-1 bg-2 onhover-bg-color-5 mobile-width-95 system-width-95 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-top-1 system-padding-top-1 mobile-padding-bottom-1 system-padding-bottom-1 mobile-margin-top-1 system-margin-top-1");
                    for(i = 0; i < allClass.length; i++){
                        allClass[i].style.display = "none";
                    }
                }
            }

            function removeExamSubject(subject_id,day_id,class_id,school_id){
                if(confirm("Do you want to delete this record?")){
                    const classExamHttpRequest = new XMLHttpRequest();
                    classExamHttpRequest.open("POST","./del-exam.php");
                    classExamHttpRequest.setRequestHeader("Content-Type","application/json");
                    const classExamHttpRequestBody = JSON.stringify({sch_no: school_id, class_id_no: class_id, day: day_id, subject: subject_id});
                    classExamHttpRequest.onload = function(){
                        if((classExamHttpRequest.readyState == 4) && (classExamHttpRequest.status == 200)){
                            const classExamResponse = JSON.parse(classExamHttpRequest.responseText)["response"];
                            if(classExamResponse == 1){
                                alert("Success");
                                window.location.replace(window.location.href);
                            }else{
                                if(classExamResponse == 2){
                                    alert("Error");
                                }
                            }
                        }else{
                            alert(classExamHttpRequest.status);
                        }
                    }
                    classExamHttpRequest.send(classExamHttpRequestBody);
                }else{
                    alert("Operation cancelled");
                }
            }
        </script>
    </div>
    <?php }else{ include("include/no-data-img.php"); } ?>
<?php } ?>

<?php if(strip_tags($_GET['tab']) == 'add_exam_time_table'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
            <?php
                $edit_exam_list_checkmate = mysqli_query($connection_server, "SELECT * FROM sm_exam_lists WHERE (school_id_number='".trim(strip_tags($_GET['id']))."' && exam_id='".trim(strip_tags($_GET['edit']))."')");
                if((isset($_GET['edit'])) && (trim(strip_tags($_GET['edit'])) !== "") && (mysqli_num_rows($edit_exam_list_checkmate) == 1)){
                    if(mysqli_num_rows($edit_exam_list_checkmate) == 1){
                        $edit_exam_list_detail = mysqli_fetch_array($edit_exam_list_checkmate);
                        
                        $edit_exam_list_moderator_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".trim(strip_tags($_GET['edit']))."' LIMIT 1"));
                    }
                }
            ?>
            <form method="post" enctype="multipart/form-data">
            <?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
                    <div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                        <?php echo $err_msg; ?>
                    </div>
                <?php } ?>
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="numeric-class" onchange="findExamTypeClassSession();" id="find-exam-type-class-session" class="form-select" required>
                        <option selected disabled hidden value="">Select Class</option>
                        <?php
                            $select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' GROUP BY numeric_class_name");
                           	
                            if(mysqli_num_rows($select_classes_detail_using_id) > 0){
                                while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
                                    echo '<option value="'.$classes_details["numeric_class_name"].'" >'.$classes_details["class_name"].' ('.$classes_details["numeric_class_name"].')</option>';
                                }
                            }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Class Name*</span>
                </div>
                
                <!--<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="class-session" id="add-exam-type-class-session" class="form-select" required>
                        <option disabled hidden selected value="">Select Class Session</option>
                        <?php
                            // if((mysqli_num_rows($edit_exam_list_checkmate) == 1)){
                            //  $select_sessions_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."' && numeric_class_name='".$edit_exam_list_detail['numeric_class_name']."'");
                    
                            //  if(mysqli_num_rows($select_sessions_detail_using_id) > 0){
                            //      while($sessions_details = mysqli_fetch_assoc($select_sessions_detail_using_id)){
                            //          if($sessions_details["session"] == $edit_exam_list_detail['session']){
                            //              $selected = "selected";
                            //              echo '<option value="'.$sessions_details["session"].'" '.$selected.'>'.str_replace("-","/",$sessions_details["session"]).'</option>';
                            //          }else{
                            //              echo '<option value="'.$sessions_details["session"].'" >'.str_replace("-","/",$sessions_details["session"]).'</option>';
                            //          }
                                        
                            //      }
                            //  }
                            // }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Session Name*</span>
                </div>-->
                
                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="subject-code" class="form-select" required>
                        <option selected disabled hidden value="">Select Subject</option>
                        <?php
                            $select_exams_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
                
                            if(mysqli_num_rows($select_exams_detail_using_id) > 0){
                                while($exams_details = mysqli_fetch_assoc($select_exams_detail_using_id)){
                                    echo '<option value="'.$exams_details["subject_code"].'" >'.$exams_details["subject_name"].' ('.$exams_details["subject_code"].')</option>';
                                }
                            }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Subject Name*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="day-code" class="form-select" required>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Day*</span>
                </div>
                
                <!--<div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="term" class="form-select" required>
                        <option disabled hidden selected value="">Select Term</option>
                        <?php
                            // $select_terms_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_terms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
                
                            // if(mysqli_num_rows($select_terms_detail_using_id) > 0){
                            //  while($terms_details = mysqli_fetch_assoc($select_terms_detail_using_id)){
                            //      echo '<option value="'.$terms_details["id_number"].'">'.$terms_details["term_name"].'</option>';
                            //  }
                            // }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Term*</span>
                </div>-->

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="date" value="" type="date" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Exam Date*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="start-time" value="" type="time" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Start Time*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <input name="end-time" value="" type="time" placeholder="" class="form-input" required/>
                    <span class="form-span mobile-font-size-12 system-font-size-14">End Time*</span>
                </div>
                
                <input hidden id="exam-type-school-id" value="<?php echo $get_logged_user_details['school_id_number']; ?>" />
                
                <button name="add-exam" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    ADD EXAM
                </button>
                
            </form>
            <script>
                function findExamTypeClassSession(){
                    const find_exam_type_class_session = document.getElementById("find-exam-type-class-session");
                    const add_exam_type_class_session = document.getElementById("add-exam-type-class-session");
                    const exam_type_school_id_number = document.getElementById("exam-type-school-id");

                    add_exam_type_class_session.innerHTML = "";
                    const createSelectSessionOption = document.createElement("option");
                    createSelectSessionOption.hidden = true;
                    createSelectSessionOption.disabled = true;
                    createSelectSessionOption.selected = true;
                    createSelectSessionOption.text = "Select Class Session";
                    createSelectSessionOption.value = "";
                    add_exam_type_class_session.add(createSelectSessionOption);

                    const classSessionHttpRequest = new XMLHttpRequest();
                    classSessionHttpRequest.open("POST","./get-class-session.php");
                    classSessionHttpRequest.setRequestHeader("Content-Type","application/json");
                    const classSessionHttpRequestBody = JSON.stringify({sch_no: exam_type_school_id_number.value, class_id_no: find_exam_type_class_session.value});

                    classSessionHttpRequest.onload = function(){
                        if((classSessionHttpRequest.readyState == 4) && (classSessionHttpRequest.status == 200)){
                            
                            const session_list_array = JSON.parse(classSessionHttpRequest.responseText)["response"];
                            
                            for(i=0; i < session_list_array.length; i++){
                                const createSelectOption = document.createElement("option");
                                createSelectOption.text = session_list_array[i].replace("-","/");
                                createSelectOption.value = session_list_array[i];
                                add_exam_type_class_session.add(createSelectOption);
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
<?php } ?>-->


