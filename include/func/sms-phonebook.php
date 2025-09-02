<?php
$school_id = $get_logged_user_details['school_id_number'];

if (isset($_POST['add-external-contact'])) {
    $name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['name'])));
    $phone_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['phone-number'])));

    if (!empty($name) && !empty($phone_number)) {
        $insert_contact = mysqli_query($connection_server, "INSERT INTO sm_sms_phonebook (school_id_number, name, phone_number, is_parent) VALUES ('$school_id', '$name', '$phone_number', 0)");
        if ($insert_contact) {
            header("Location: /bc-admin.php?page=smgt_sms_phonebook&id=$school_id");
        }
    }
}

if (isset($_POST['edit-external-contact'])) {
    $contact_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['contact-id'])));
    $name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['name'])));
    $phone_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['phone-number'])));

    if (!empty($name) && !empty($phone_number) && !empty($contact_id)) {
        $update_contact = mysqli_query($connection_server, "UPDATE sm_sms_phonebook SET name = '$name', phone_number = '$phone_number' WHERE id = '$contact_id' AND school_id_number = '$school_id'");
        if ($update_contact) {
            header("Location: /bc-admin.php?page=smgt_sms_phonebook&id=$school_id");
        }
    }
}

if (isset($_GET['tab']) && $_GET['tab'] == 'delete_external' && isset($_GET['contact_id'])) {
    $contact_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET['contact_id'])));
    $delete_contact = mysqli_query($connection_server, "DELETE FROM sm_sms_phonebook WHERE id = '$contact_id' AND school_id_number = '$school_id'");
    header("Location: /bc-admin.php?page=smgt_sms_phonebook&id=$school_id");
}
?>
