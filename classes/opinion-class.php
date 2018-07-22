<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * User Opinion block
 *
 * @package    block_user_opinion
 * @copyright  Rodrigo Reinaldo <rodrigo_2rf@hotmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_user_opinion;

class Opinion {

    private $id;
    private $userid;
    private $instance;
    private $grades;
    private $timecreated;
    private $message;
    private $show;

    public function __construct( $id = NULL, $userid = NULL, $instance = NULL, $grades = NULL, $timecreated = NULL, $message = NULL, $show = NULL ){
        $this->id = $id;
        $this->userid = $userid;
        $this->instance = $instance;
        $this->grades = $grades;
        $this->timecreated = $timecreated;
        $this->message = $message;
        $this->show = $show;
    }

}