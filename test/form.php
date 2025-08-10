<?php
// moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends \moodleform
{
    // Add elements to form.
    public function definition()
    {
        global $CFG;
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!

        // Add elements to your form.
        $mform->addElement('text', 'email', get_string('email'));

        // Set type of element.
        $mform->setType('email', PARAM_NOTAGS);

        // Default value.
        $mform->setDefault('email', 'Please enter email');
        // add filepicker element.
        $mform->addElement('filepicker', 'shree_file', get_string('file'), null,
            [
                'maxbytes' => 11111111111, // Set max file size.
                'accepted_types' => '*',
            ]
        );
        $this->add_action_buttons(true, get_string('submit'));
    }

    // Custom validation should be added here.
    function validation($data, $files)
    {
        return [];
    }
}
