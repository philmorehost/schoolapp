<?php
	if(($user_identifier_auth_id != "super_mod") && ($user_identifier_auth_id == "mod_adm") && ($user_identifier_auth_id != "adm_staff") && ($user_identifier_auth_id != "teacher") && ($user_identifier_auth_id != "stu_par") && ($user_identifier_auth_id != "stu")){
?>
<?php if(strip_tags($_GET['page']) == 'smgt_migration'){ ?>
    <div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
        <center>
            <form method="post" enctype="multipart/form-data">
                <?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
                    <div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-92 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
                        <?php echo $err_msg; ?>
                    </div>
                <?php } ?>
                
                <div style="text-align: left;" class="container-box color-5 bg-3 text-bold-500 mobile-width-90 system-width-95 mobile-margin-top-3 system-margin-top-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-2 system-margin-right-2">
                    MIGRATION INFORMATION
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="current-class" class="form-select" required>
                        <option selected disabled hidden value="">Select Class</option>
                        <?php
                            $select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
                
                            if(mysqli_num_rows($select_classes_detail_using_id) > 0){
                                while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
                                    echo '<option value="'.$classes_details["numeric_class_name"].' '.$classes_details["session"].'" >'.$classes_details["class_name"].' ( '.$classes_details["numeric_class_name"].' ) ( '.str_replace("-","/",$classes_details["session"]).' )</option>';
                                }
                            }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Select Current Class*</span>
                </div>

                <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    <select name="next-class" class="form-select" required>
                        <option selected disabled hidden value="">Select Class</option>
                        <?php
                            $select_classes_detail_using_id = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
                
                            if(mysqli_num_rows($select_classes_detail_using_id) > 0){
                                while($classes_details = mysqli_fetch_assoc($select_classes_detail_using_id)){
                                    echo '<option value="'.$classes_details["numeric_class_name"].' '.$classes_details["session"].'" >'.$classes_details["class_name"].' ( '.$classes_details["numeric_class_name"].' ) ( '.str_replace("-","/",$classes_details["session"]).' )</option>';
                                }
                            }
                
                        ?>
                    </select>
                    <span class="form-span mobile-font-size-12 system-font-size-14">Select Next Class Name*</span>
                </div>
                
                <button name="migrate" style="float: left; clear: left;" type="submit" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                    GO
                </button>
            </form>     
        </center>
    </div>
<?php } ?> 

<?php } ?>
