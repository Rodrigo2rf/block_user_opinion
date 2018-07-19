<?php

    require_once(dirname(__FILE__) ."/../../config.php");
    require_once("../../lib/moodlelib.php");
    require_once("$CFG->libdir/formslib.php");

	require_login( );
	
    $context = get_context_instance(CONTEXT_SYSTEM);
    // require_capability('block/matuto:view', $context);
   
    $PAGE->set_context($context);
	$PAGE->set_url('/blocks/user_opinion/cadastrar_semestre.php');
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title('Block User opinion: Manage instances of block');

	$PAGE->set_cacheable(true);

	
    // Breadcrumb_navigation
	$PAGE->navbar->add( get_string('pluginname', 'block_user_opinion'), $CFG->wwwroot.'/blocks/user_opinion');
    $PAGE->navbar->add( get_string('manageinstances','block_user_opinion'));

	echo $OUTPUT->header();

	$outputhtml .= html_writer::tag('h3', get_string('semestres_cadastrados','block_user_opinion'));
	
	echo $OUTPUT->footer();

?>