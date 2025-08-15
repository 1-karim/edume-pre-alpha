<?php
require_once("$CFG->libdir/formslib.php");

class local_test_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        // Email field.
        $mform->addElement('text', 'email', 'email');
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', null, 'required', null, 'client');
        $mform->addRule('email', null, 'email', null, 'client');

        // Filemanager field.
        $mform->addElement('filemanager', 'attachments_filemanager', 'attachments', null, [
            'subdirs' => 0,
            'maxbytes' => 0,
            'maxfiles' => 3,
            'accepted_types' => '*'
        ]);

        // Hidden ID for editing.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        // Buttons.
        $this->add_action_buttons();
    }
}
