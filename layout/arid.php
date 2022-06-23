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
 * A single column layout for theme_arid.
 *
 * @package   theme_arid
 * @copyright 2022 tim st clair
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php');

$theme = \theme_config::load('arid');

$extraclasses = [];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$nav = $PAGE->flatnav;
$sitename = format_string($SITE->shortname, true, ['context' => \context_course::instance(SITEID), "escape" => false]);
$headerObj = new \stdClass();
$headerObj->link = $theme->settings->headerLink ?: $CFG->wwwroot;
$headerObj->label = $theme->settings->headerLabel ?: $sitename;
$headerObj->html = $theme->settings->headerHtml ?: false;
if ($theme->settings->headerLogo) {
    $headerObj->logo = true;
    $headerObj->logourl = \moodle_url::make_pluginfile_url(
                            \context_system::instance()->id,
                            'theme_arid',
                            'headerlogo',
                            0,
                            '',
                            $theme->settings->headerLogo
                        );
                            // '',theme_get_revision(),
                            // $theme->settings->headerLogo);
}

$templatecontext = [
    'sitename' => $sitename,
    'output' => $OUTPUT,
    'header' => $headerObj,
    'bodyattributes' => $bodyattributes,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'user_id' => (int) $USER->id, // To use in notification read all.
    'is_admin' => is_siteadmin(),
    'flatnavigation' => $nav,
    'firstcollectionlabel' => $nav->get_collectionlabel(),
];

echo $OUTPUT->render_from_template('theme_arid/arid', $templatecontext);