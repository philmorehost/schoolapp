<?php session_start(); error_reporting(1);

	if(isset($_SESSION["stu_session"])){
        include("include/config-file.php");
        $get_post_info = json_decode(file_get_contents('php://input'),true);
        $get_cbt_id = mysqli_real_escape_string($connection_server, preg_replace("/[^0-9]+/", "", trim($get_post_info["id"])));
        $get_cbt_score = mysqli_real_escape_string($connection_server, preg_replace("/[^0-9]+/", "", trim($get_post_info["score"])));
        $cbt_exam_type_column_array = array("1ca" => "first_ca","2ca" => "second_ca","3ca" => "third_ca","exam" => "exam");

        if(is_numeric($get_cbt_id) && is_numeric($get_cbt_score)){
            $check_cbt_scheldule_list = mysqli_query($connection_server,"SELECT * FROM sm_cbt_scheldule_lists WHERE cbt_id='".$get_cbt_id."' AND school_id_number='".$get_logged_user_details["school_id_number"]."' AND numeric_class_name='".$get_logged_user_details["current_class"]."' AND session='".$get_logged_user_details["session"]."'");
            if(mysqli_num_rows($check_cbt_scheldule_list) == 1){
                $fetch_cbt_details = mysqli_fetch_array($check_cbt_scheldule_list);

                // SERVER-SIDE DURATION VALIDATION
                $check_started_query = mysqli_query($connection_server, "SELECT * FROM sm_started_cbt_lists WHERE cbt_id_number='".$get_cbt_id."' AND school_id_number='".$get_logged_user_details["school_id_number"]."' AND admission_number='".$get_logged_user_details["admission_number"]."'");

                if (mysqli_num_rows($check_started_query) == 0) {
                    echo json_encode(array("response"=>"error", "message"=>"You have not officially started this exam."), true);
                    exit();
                }

                $started_details = mysqli_fetch_assoc($check_started_query);
                $start_time = strtotime($started_details['date_started']);

                list($hours, $minutes) = explode(':', $fetch_cbt_details["exam_duration"]);
                $duration_in_seconds = ($hours * 3600) + ($minutes * 60);
                $deadline = $start_time + $duration_in_seconds;
                $current_time = time();

                if ($current_time > $deadline) {
                    mysqli_query($connection_server, "INSERT INTO sm_submitted_cbt_lists (school_id_number, cbt_id_number, admission_number) VALUES ('".$get_logged_user_details["school_id_number"]."','".$get_cbt_id."','".$get_logged_user_details["admission_number"]."')");
                    echo json_encode(array("response"=>"error", "message"=>"Your time for this exam has expired. Your submission was not recorded."), true);
                    exit();
                }

                if($fetch_cbt_details["exam_questions"] >= $get_cbt_score){
                    $check_cbt_submitted_list = mysqli_query($connection_server,"SELECT * FROM sm_submitted_cbt_lists WHERE cbt_id_number='".$get_cbt_id."' AND school_id_number='".$get_logged_user_details["school_id_number"]."' AND admission_number='".$get_logged_user_details["admission_number"]."'");
                    if(mysqli_num_rows($check_cbt_submitted_list) == 0){

                        $search_student_result_release_date_database = mysqli_query($connection_server, "SELECT * FROM sm_result_release_dates WHERE school_id_number='".$fetch_cbt_details["school_id_number"]."' AND numeric_class_name='".$fetch_cbt_details["numeric_class_name"]."' AND session='".$fetch_cbt_details["session"]."' AND term_id_number='".$fetch_cbt_details["term_id_number"]."'");
                        if(mysqli_num_rows($search_student_result_release_date_database) < 1){
                            $insert_student_result_release_date_database = mysqli_query($connection_server, "INSERT INTO sm_result_release_dates (school_id_number, numeric_class_name, session, term_id_number, release_date) VALUES ('".$fetch_cbt_details["school_id_number"]."','".$fetch_cbt_details["numeric_class_name"]."','".$fetch_cbt_details["session"]."','".$fetch_cbt_details["term_id_number"]."','')");
                        }

                        $get_all_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".$fetch_cbt_details["school_id_number"]."' AND numeric_class_name='".$fetch_cbt_details["numeric_class_name"]."' AND session='".$fetch_cbt_details["session"]."' AND admission_number='".$get_logged_user_details["admission_number"]."'");
                        if(mysqli_num_rows($get_all_students_in_class) > 0){

                            while($add_student_to_result_database = mysqli_fetch_array($get_all_students_in_class)){
                                $get_if_student_exists_in_result_database = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='".$fetch_cbt_details["school_id_number"]."' AND numeric_class_name='".$fetch_cbt_details["numeric_class_name"]."' AND session='".$fetch_cbt_details["session"]."' AND term_id_number='".$fetch_cbt_details["term_id_number"]."' AND subject_code='".$fetch_cbt_details["subject_code"]."' AND admission_number='".$add_student_to_result_database["admission_number"]."'");
                                if(mysqli_num_rows($get_if_student_exists_in_result_database) == 0){

                                    $search_student_to_result_list_database = mysqli_query($connection_server, "SELECT * FROM sm_result_lists WHERE school_id_number='".$fetch_cbt_details["school_id_number"]."' AND numeric_class_name='".$fetch_cbt_details["numeric_class_name"]."' AND session='".$fetch_cbt_details["session"]."' AND term_id_number='".$fetch_cbt_details["term_id_number"]."' AND admission_number='".$add_student_to_result_database["admission_number"]."'");
                                    if(mysqli_num_rows($search_student_to_result_list_database) == 0){
                                        $ref_char = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
                                        $result_ref = substr(str_shuffle($ref_char),0,20);
                                        $insert_student_to_result_list_database = mysqli_query($connection_server, "INSERT INTO sm_result_lists (school_id_number, result_ref, numeric_class_name, session, term_id_number, admission_number) VALUES ('".$fetch_cbt_details["school_id_number"]."','$result_ref','".$fetch_cbt_details["numeric_class_name"]."','".$fetch_cbt_details["session"]."','".$fetch_cbt_details["term_id_number"]."','".$add_student_to_result_database["admission_number"]."')");
                                    }

                                    $result_cbt_type_column = $cbt_exam_type_column_array[$fetch_cbt_details["cbt_type"]];
                                    $insert_student_to_result_database = mysqli_query($connection_server, "INSERT INTO sm_results (school_id_number, numeric_class_name, session, term_id_number, subject_code, admission_number, ".$result_cbt_type_column.", comment) VALUES ('".$fetch_cbt_details["school_id_number"]."','".$fetch_cbt_details["numeric_class_name"]."','".$fetch_cbt_details["session"]."','".$fetch_cbt_details["term_id_number"]."','".$fetch_cbt_details["subject_code"]."','".$add_student_to_result_database["admission_number"]."','".$get_cbt_score."','')");
                                    mysqli_query($connection_server, "INSERT INTO sm_submitted_cbt_lists (school_id_number, cbt_id_number, admission_number) VALUES ('".$fetch_cbt_details["school_id_number"]."','".$get_cbt_id."','".$add_student_to_result_database["admission_number"]."')");

                                }else{
                                    if(mysqli_num_rows($get_if_student_exists_in_result_database) == 1){
                                        //Update Student Mark
                                        $result_cbt_type_column = $cbt_exam_type_column_array[$fetch_cbt_details["cbt_type"]];
                                        mysqli_query($connection_server, "UPDATE sm_results SET ".$result_cbt_type_column."='".$get_cbt_score."' WHERE school_id_number='".$fetch_cbt_details["school_id_number"]."' AND numeric_class_name='".$fetch_cbt_details["numeric_class_name"]."' AND session='".$fetch_cbt_details["session"]."' AND term_id_number='".$fetch_cbt_details["term_id_number"]."' AND subject_code='".$fetch_cbt_details["subject_code"]."' AND admission_number='".$get_logged_user_details["admission_number"]."'");
                                        mysqli_query($connection_server, "INSERT INTO sm_submitted_cbt_lists (school_id_number, cbt_id_number, admission_number) VALUES ('".$fetch_cbt_details["school_id_number"]."','".$get_cbt_id."','".$add_student_to_result_database["admission_number"]."')");
                                    }
                                }
                            }
                        }

                        echo json_encode(array("response"=>1),true);
                    }else{
                        echo json_encode(array("response"=>2),true);
                    }
                }else{
                    echo json_encode(array("response"=>2),true);
                }
            }else{
                echo json_encode(array("response"=>2),true);
            }
        }else{
            echo json_encode(array("response"=>2),true);
        }
    }

?>