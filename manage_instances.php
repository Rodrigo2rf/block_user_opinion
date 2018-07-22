<?php

    require_once(dirname(__FILE__) ."/../../config.php");
    require_once(dirname(__FILE__) . "/classes/instance-class.php");

	require_login( );
	
    $systemcontext = context_system::instance();
    
    require_capability('block/user_opinion:manager', $systemcontext);
   
    $PAGE->set_context($systemcontext);
	$PAGE->set_url('/blocks/user_opinion/manage_instances.php');
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title('Block User opinion: Manage instances of block');

	$PAGE->set_cacheable(true);
    $instance = new Instance;

    $courseid = optional_param('courseid', NULL, PARAM_INT);
   
    // Breadcrumb_navigation
	$PAGE->navbar->add( get_string('pluginname', 'block_user_opinion'), $CFG->wwwroot.'/blocks/user_opinion');
    $PAGE->navbar->add( get_string('manageinstances','block_user_opinion'));

    echo $OUTPUT->header();
    
    if($courseid != NULL){
        
        $course = $instance->get_course_by_id($courseid);                
        $instance_by_course = $instance->get_instance_by_courseid($courseid);
        echo html_writer::tag('h3', 'Instance in '.$course[1]->fullname);
        if($instance_by_course != NULL){       
            echo html_writer::tag('h4', 'Edit instance');
        }else{
            echo html_writer::tag('h4', 'Configure instance');
        }
        $instance->renderer_form();

    }else{

        $outputhtml = "";
        $list = $instance->get_instances();
        $outputhtml .= html_writer::tag('h3', 'Instances found');
        $outputhtml .= $instance->renderer_list($list);
        echo $outputhtml;
    }
    
	echo $OUTPUT->footer();

?>