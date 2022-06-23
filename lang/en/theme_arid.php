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
 * @package   theme_arid
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// A description shown in the admin theme selector.                                                                                 
$string['choosereadme'] = 'This theme extends Boost and is desgined for use in courses or categories where you want to show generic single-column page information and don\'t want to show most Moodle site features, such as Single Activity courses. It it not recommended to use this as a site-wide theme.';
$string['configtitle'] = 'Arid settings';
$string['generalsettings'] = 'Common settings';
$string['scsssettings'] = 'CSS/SCSS';
$string['advancedsettings'] = 'Less used settings';
$string['pluginname'] = 'Arid';
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this field to provide SCSS or CSS code which will be injected at the end of the style sheet.';
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'In this field you can provide initialising SCSS code, it will be injected before everything else. Most of the time you will use this setting to define variables.';
$string['privacy:metadata'] = 'The Arid theme plugin does not store any personal data.';

$string['headerhtml_desc'] = 'Custom HTML to be added to the header of the page (raw). Moodle uses Bootstrap 4.4, so any code based on that will work well (see <a href="https://getbootstrap.com/docs/4.4/examples/">https://getbootstrap.com/docs/4.4/examples/</a> for examples).';
$string['headerhtml'] = 'Custom HTML';
$string['headerlogo'] = 'Custom logo, overrides site logo or header label if set';
$string['headerlabel'] = 'Label, instead of the logo or sitename';
$string['headerlink'] = 'URL for logo, instead of the webroot';
