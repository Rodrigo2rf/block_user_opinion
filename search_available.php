<?php

require_once(dirname(__FILE__) ."/../../config.php");
require_once(dirname(__FILE__) . "/classes/instance-class.php");
require_once(dirname(__FILE__) . "/classes/opinion-class.php");
require_once("$CFG->libdir/formslib.php");

    require_login( );
    
    global $USER;
	
    $systemcontext = context_system::instance();
       
    $PAGE->set_context($systemcontext);
	$PAGE->set_url('/blocks/user_opinion/submit_review.php');
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title('Block User opinion: Answer Survey');

    $PAGE->set_cacheable(true);
    
    $instance = new Instance();
    $opinion = new Opinion();

    $instance_by_course = $instance->get_instance_by_courseid(optional_param('courseid', NULL, PARAM_INT));

    // Breadcrumb_navigation
	$PAGE->navbar->add( get_string('pluginname', 'block_user_opinion'), $CFG->wwwroot.'/blocks/user_opinion');
    $PAGE->navbar->add( get_string('manageinstances','block_user_opinion'));

    class rendererSurveyForm extends moodleform {
        
        // Add elements to form
        public function definition() {

            $mform = $this->_form;

            $mform->addElement('hidden', 'courseid', optional_param('courseid', NULL, PARAM_INT));
            $mform->setType('courseid', PARAM_INT); 

            $mform->addElement('select', 'grade', 'What grade would you give for this course?', array(0, 1, 2, 3, 4, 5),'');

            $mform->addElement('textarea', 'message', 'Place your comment here.', 'wrap="virtual" rows="10" cols="50"');
             
            // button
            $this->add_action_buttons(true, 'Save');
        }
    }

	echo $OUTPUT->header();

    $form = new rendererSurveyForm();
    if($fromform = $form->get_data()){

        $survey = new Opinion();
        
        $record = new stdclass();
        $record->userid = $USER->id;
        $record->courseid =  $fromform->courseid;
        $record->grades = $fromform->grade;
        $record->timecreated = time();
        $record->message = $fromform->message;
        $record->shared = 0;

        $survey->saveData($record);

        redirect( $CFG->wwwroot . '/course/view.php?id='.$fromform->courseid, 'Data was successfully saved !!!', 2);
    }else{
        $is_answered = $opinion->check_answer(optional_param('courseid', NULL, PARAM_INT), $USER->id);
        if($is_answered == false){

            echo html_writer::tag('h3', $instance_by_course->fullname);
            echo html_writer::tag('h4', 'What did you think about this course?');

            $form->display();
        }else{
            redirect( $CFG->wwwroot . '/course/view.php?id='.optional_param('courseid', NULL, PARAM_INT), 'Survey already answered !!!', 4);
        }    
    }

	echo $OUTPUT->footer();

?>