<?php
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/form.php');

require_login();

global $DB, $PAGE, $OUTPUT;

// Page setup.
$PAGE->set_url(new moodle_url('/local/test/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Email List');
$PAGE->set_heading('Email List');

// Get record ID from URL.
$id = optional_param('id', 0, PARAM_INT);

// Load existing record or create new.
if ($id) {
    $record = $DB->get_record('email_list', ['id' => $id], '*', MUST_EXIST);
} else {
    $record = new stdClass();
    $record->id = null;
}

// Prepare filemanager for display in form.
$context = context_system::instance();
$record = file_prepare_standard_filemanager(
    $record,
    'attachments',
    [
        'subdirs' => 0,
        'maxbytes' => 0,
        'maxfiles' => 3,
        'accepted_types' => '*'
    ],
    $context,
    'local_test',
    'attachments',
    $record->id
);

// Build and process form.
$mform = new local_test_form();
$mform->set_data($record);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/test/index.php'));
} else if ($data = $mform->get_data()) {
    // Insert or update record.
    if (empty($data->id)) {
        $data->id = $DB->insert_record('email_list', $data);
    } else {
        $DB->update_record('email_list', $data);
    }

    // Save uploaded files.
    file_postupdate_standard_filemanager(
        $data,
        'attachments',
        [
            'subdirs' => 0,
            'maxbytes' => 0,
            'maxfiles' => 3,
            'accepted_types' => '*'
        ],
        $context,
        'local_test',
        'attachments',
        $data->id
    );

    redirect(new moodle_url('/local/test/index.php', ['id' => $data->id]), 'Record saved successfully.');
}

// Output page.
echo $OUTPUT->header();
$mform->display();

// If editing an existing record, list the files with download links.
if ($id) {
    echo html_writer::tag('h3', 'Uploaded Files:');

    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'local_test', 'attachments', $id, "filename", false);

    if ($files) {
        $list = [];
        foreach ($files as $file) {
            $url = moodle_url::make_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                $file->get_itemid(),
                $file->get_filepath(),
                $file->get_filename()
            );
            $list[] = html_writer::link($url, $file->get_filename());
        }
        echo html_writer::alist($list);
    } else {
        echo html_writer::tag('p', 'No files uploaded.');
    }
}

echo $OUTPUT->footer();
