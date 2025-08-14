<?php
require_once('../config.php');
require_once($CFG->dirroot . '/test/form.php');

global $CFG, $DB, $USER, $OUTPUT, $PAGE;

$item_id  = optional_param('id', 0, PARAM_INT);
$context  = context_system::instance();

// For redirection
$redirecturl = new moodle_url('/test/index.php', ['id' => $item_id]);

// Setup page
$PAGE->set_context($context);
$PAGE->set_url('/test/index.php', ['id' => $item_id]);
$PAGE->set_heading('Email list form');
$PAGE->set_title('Email list form');

// Init form
$mform = new simplehtml_form();

// =======================
// Prepare form data
// =======================
if ($item_id > 0) {
    // Editing existing record
    $data = $DB->get_record('email_list', ['id' => $item_id], '*', MUST_EXIST);

    // Prepare draft file area for existing files
    $draftitemid = file_get_submitted_draft_itemid('shree_attachments');
    file_prepare_draft_area(
        $draftitemid,
        $context->id,
        'ram_component',
        'ram_filearea',
        $item_id,
        ['subdirs' => 0, 'maxbytes' => get_max_upload_sizes(), 'maxfiles' => 3]
    );
    $data->shree_attachments = $draftitemid;

} else {
    // New record
    $data = new stdClass();
    $data->id = null;
    $draftitemid = file_get_submitted_draft_itemid('shree_attachments');
    $data->shree_attachments = $draftitemid;
}

$mform->set_data($data);

// =======================
// Output starts here
// =======================
echo $OUTPUT->header();

// =======================
// Form cancelled
// =======================
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/test/index.php'));
}

// =======================
// Form submitted
// =======================
else if ($fromform = $mform->get_data()) {

    if ($item_id > 0) {
        // Update
        $record = $DB->get_record('email_list', ['id' => $item_id], '*', MUST_EXIST);
        $record->email         = $fromform->email;
        $record->modified_time = time();
        $DB->update_record('email_list', $record);

        // Save files for same itemid
        file_save_draft_area_files(
            $fromform->shree_attachments,
            $context->id,
            'ram_component',
            'ram_filearea',
            $item_id,
            ['subdirs' => 0, 'maxfiles' => 3]
        );

        redirect(
            new moodle_url('/test/index.php', ['id' => $item_id]),
            "Record updated successfully",
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );

    } else {
        // Insert new
        $record = new stdClass();
        $record->email       = $fromform->email;
        $record->added_time  = time();
        $record->added_by    = $USER->id;
        $newid = $DB->insert_record('email_list', $record);

        // Save files for new itemid
        file_save_draft_area_files(
            $fromform->shree_attachments,
            $context->id,
            'ram_component',
            'ram_filearea',
            $newid,
            ['subdirs' => 0, 'maxfiles' => 3]
        );

        redirect(
            new moodle_url('/test/index.php', ['id' => $newid]),
            "Record created successfully",
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    }
}

// =======================
// Display form
// =======================
$mform->display();

// =======================
// Show existing files in edit mode
// =======================
if ($item_id > 0) {
    $files = $DB->get_records_sql("
        SELECT * FROM {files}
        WHERE component = ? 
          AND filearea = ? 
          AND itemid = ? 
          AND filename != '.'",
        ['ram_component', 'ram_filearea', $item_id]
    );

    if ($files) {
        echo html_writer::tag('h3', 'Existing files:');
        foreach ($files as $file) {
            $fileurl = moodle_url::make_pluginfile_url(
                $file->contextid,
                $file->component,
                $file->filearea,
                $file->itemid,
                $file->filepath,
                $file->filename
            );
            $fileurl_custom = str_replace('pluginfile.php', 'test/uploads', $fileurl);
            echo html_writer::link($fileurl, $file->filename) . '<br>';
        }
    }
}

echo $OUTPUT->footer();
