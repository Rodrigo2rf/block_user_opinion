<?php

    require_once(dirname(__FILE__) ."/../../config.php");
    require_once(dirname(__FILE__) . "/classes/instance-class.php");
    require_once(dirname(__FILE__) . "/classes/opinion-class.php");

    require_login( );
	
    $systemcontext = context_system::instance();
    
    require_capability('block/user_opinion:manager', $systemcontext);
   
    $PAGE->set_context($systemcontext);
	$PAGE->set_url('/blocks/user_opinion/manage_reviews.php');
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title('Block User opinion: Manage reviews');

	$PAGE->set_cacheable(true);
    $instance = new Instance;
    $review = new Opinion;

    $courseid = optional_param('courseid', NULL, PARAM_INT);

    $reviewid = NULL;
    if( optional_param('reviewid', NULL, PARAM_INT) != NULL ){
        $reviewid = optional_param('reviewid', NULL, PARAM_INT);
    }
	
    // Breadcrumb_navigation
	$PAGE->navbar->add( get_string('pluginname', 'block_user_opinion'), $CFG->wwwroot.'/blocks/user_opinion');
    $PAGE->navbar->add( get_string('manageinstances','block_user_opinion'));

    echo $OUTPUT->header();
    
    if( $reviewid != NULL && $courseid != NULL ){
        $data = $review->get_review_by_id($reviewid);

        $record = new stdclass();

        $record->id = $data->id;
        $record->userid = $data->userid;
        $record->courseid = $data->courseid;
        $record->grades = $data->grades;
        $record->message = $data->message;
        $record->timecreated = $data->timecreated;
        $record->shared = optional_param('shared', NULL, PARAM_INT);

        $review->edit_review($record);

        redirect( $CFG->wwwroot . '/blocks/user_opinion/manage_reviews.php?courseid='.$courseid, 'Data was successfully saved !!!', 3);
    }

    if($courseid != NULL){

        $outputhtml = "";
        
        $course = $instance->get_course_by_id($courseid); 
        $review = $instance->get_reviews($courseid);               

        $outputhtml .= html_writer::tag('h3', 'Instance in '.$course[1]->fullname);
        $outputhtml .= html_writer::tag('h4', 'List of survey answers:');

        $outputhtml .= $instance->renderer_reviews_list($review);
  
        echo $outputhtml;

    }else{

        $outputhtml = "";
        $outputhtml .= html_writer::tag('h3', 'Course not found');
        echo $outputhtml;
    }
	
	echo $OUTPUT->footer();

?>