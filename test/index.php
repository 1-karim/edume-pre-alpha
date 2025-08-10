<?php

// Instantiate the myform form from within the plugin.
require_once('../config.php');

global $CFG,$DB,$USER,$OUTPUT;
require_once($CFG->dirroot . '/test/form.php');

$redirect = $CFG->wwwroot.'/test/index.php';
echo $OUTPUT->header();
$mform = new simplehtml_form();

// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    echo "Form cancelled";
}else if ($fromform = $mform->get_data()) {
    $data = new stdClass;
    // stop everything and print a message
    $data->email = $fromform->email;

    $data->added_time = time();
    $data->added_by = $USER->id;
    $file = $mform->get_new_filename('shree_file');
    $fullpath = "uploads/". $file;
    $success = $mform->save_file('shree_file', $fullpath, false);
    $data->file_path = $fullpath;
    if (!$success) {
        echo "Oops! File upload failed.";
    }
    $DB->insert_record('email_list', $data);
    redirect($redirect, "form submitted successfully", null, \core\output\notification::NOTIFY_SUCCESS);
} else {
    // This branch is executed if the form is submitted but the data doesn't
    // validate and the form should be redisplayed or on the first display of the form.
    // Set anydefault data (if any).
    $mform->set_data($toform);

    // Display the form.
    $mform->display();
}
echo $OUTPUT->footer();
?>