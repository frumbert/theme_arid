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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.If not, see <http://www.gnu.org/licenses/>.

/**
 * @package theme_arid
 * @copyright 2022 tim st clair
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

function theme_arid_get_main_scss_content($theme)
{
    global $CFG;

    $scss = '';
    $variables = file_get_contents($CFG->dirroot . '/theme/arid/scss/variables.scss');
    $pre = file_get_contents($CFG->dirroot . '/theme/arid/scss/pre.scss');
    $post = file_get_contents($CFG->dirroot . '/theme/arid/scss/post.scss');
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();
    $context = context_system::instance();
    if ($filename == 'default.scss') {                                                                                              
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');  
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_arid', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    } else {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    // Combine them together. 
    return $variables . "\n" . $pre . "\n" . $scss . "\n" . $post;
}

// serve a file from the theme
function theme_arid_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {

    static $theme = null;
    if (empty($theme)) {
        $theme = theme_config::load('arid');
    }

    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        if ($filearea === 'cachedassets') {
            $value = $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
            return $value;

        } else if ($filearea === 'headerlogo') {
            $fs = get_file_storage();
            $file = $fs->get_file($context->id, 'theme_arid', $filearea, $args[0], '/', $args[1]);
            if (!$file) {
                send_file_not_found();
            }
            send_stored_file($file, null, 0, $forcedownload, $options);

        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}

function theme_arid_get_extra_scss($theme) {
    return !empty($theme->settings->scss) ? $theme->settings->scss : '';
}

function theme_arid_get_pre_scss($theme) {
    return !empty($theme->settings->scsspre) ? $theme->settings->scsspre : '';
}

function theme_arid_get_precompiled_css($theme) {
    global $CFG;
    $file = $CFG->dirroot . '/theme/arid/style/style.css';
    return file_exists($file) ? file_get_contents($file) : '';
}