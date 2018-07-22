<?php

require_once(dirname(__FILE__) ."/../../config.php");
require_once(dirname(__FILE__) . "/classes/instance-class.php");
require_once("$CFG->libdir/formslib.php");

    require_login( );
    
    global $USER;
	
    $systemcontext = context_system::instance();
    
    // require_capability('block/user_opinion:manager', $systemcontext);
   
    $PAGE->set_context($systemcontext);
	$PAGE->set_url('/blocks/user_opinion/submit_review.php');
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title('Block User opinion: Answer Survey');

	$PAGE->set_cacheable(true);
    $instance = new Instance;

    $courseid = optional_param('courseid', NULL, PARAM_INT);
    $instance_by_course = $instance->get_instance_by_courseid($courseid);

    // Breadcrumb_navigation
	$PAGE->navbar->add( get_string('pluginname', 'block_user_opinion'), $CFG->wwwroot.'/blocks/user_opinion');
    $PAGE->navbar->add( get_string('manageinstances','block_user_opinion'));

    class rendererSurveyForm extends moodleform {
        
        // Add elements to form
        public function definition() {

            $mform = $this->_form;

            $mform->addElement('select', 'type', 'What grade would you give for this course?', array(1,2,3,4,5),'');

            $mform->addElement('textarea', 'introduction', 'Place your comment here.', 'wrap="virtual" rows="20" cols="50"');
             
            // button
            $this->add_action_buttons(true, 'Save');
        }
    }

	echo $OUTPUT->header();

    echo html_writer::tag('h3', 'Instance - '.$instance_by_course->fullname);
    echo html_writer::tag('h4', 'What did you think about this course?');


    $form = new rendererSurveyForm();
    if($fromform = $form->get_data()){
        $instance_by_course->id;
        $USER->id;
        time();
        // redirect( $CFG->wwwroot . '/course/view.php?id=', 'Data was successfully saved !!!', 2);
    }else{
        $form->display();
    }

	echo $OUTPUT->footer();

?>