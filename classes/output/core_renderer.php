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

namespace theme_arid\output;

use moodle_url;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_arid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class core_renderer extends \core_renderer {

    /**
     * Returns HTML to display a "Turn editing on/off" button in a form.
     *
     * @param moodle_url $url The URL + params to send through when clicking the button
     * @return string HTML the button
     */
    public function edit_button(moodle_url $url) {
        $url->param('sesskey', sesskey());
        $class = 'btn-turnediting btn-turneditingoff';
        if ($this->page->user_is_editing()) {
            $url->param('edit', 'off');
            $editstring = get_string('turneditingoff');
        } else {
            $class = 'btn-turnediting btn-turneditingon';
            $url->param('edit', 'on');
            $editstring = get_string('turneditingon');
        }
        return $this->single_button($url, $editstring, 'post', ['class' => $class]);
    }

    /**
     * Wrapper for header elements.
     *
     * @return string HTML to display the main header.
     */
    public function full_header() {
        global $PAGE, $DB, $USER;

        $header = new \stdClass();
        $header->settingsmenu = $this->context_header_settings_menu();
        $header->contextheader = $this->context_header();
        $header->hasnavbar = empty($PAGE->layout_options['nonavbar']);
        $header->navbar = $this->navbar();
        $header->courseheader = $this->course_header();
        $header->pageheadingbutton = $this->page_heading_button();
        $header->selfenrolbutton = $this->self_enrol_button();
        $header->headeractions = $this->page->get_header_actions(); //TIM, added

        $profileuser = '';
        if ($PAGE->pagetype === "user-profile") {
           $profileuser = $DB->get_record('user', ['id' => $PAGE->url->get_param('id')]);
           profile_load_custom_fields($profileuser);
        }

        return $this->render_from_template('theme_arid/full_header', $header);
    }

    protected function self_enrol_button() {
        global $PAGE;

        $course = $PAGE->course;
        $coursecontext = \context_course::instance($course->id);
        $instances = enrol_get_instances($course->id, true);
        $plugins   = enrol_get_plugins(true);

        $button = '';
        if ($course->id == SITEID or isguestuser() or !isloggedin() or is_enrolled($coursecontext) or is_viewing($coursecontext)) {
            // Do not show self enrol button.
        } else {
            foreach ($instances as $instance) {
                if (!isset($plugins[$instance->enrol])) {
                    continue;
                }
                $plugin = $plugins[$instance->enrol];
                if ($plugin->show_enrolme_link($instance)) {
                    $url = new moodle_url('/enrol/index.php', array('id'=>$course->id));
                    $shortname = format_string($course->shortname, true, array('context' => $coursecontext));
                    $title = get_string('enrolme', 'core_enrol', $shortname);
                    //$button = $this->single_button($url, $title);
                    $button = '<a class="btn btn-secondary btn-self-enrol" href="' . $url . '">' . $title . '</a>';
                    break;
                }
            }
        }
        return $button;
    }

}
