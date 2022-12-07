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

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingarid', get_string('configtitle', 'theme_arid'));

    // Each page is a tab - the first is the "General" tab.
    $page = new admin_settingpage('theme_arid_general', get_string('generalsettings', 'theme_arid'));

         // HEADER LINK (defaults to wwwroot)
        $name = 'theme_arid/headerLink';
        $title = get_string('headerlink', 'theme_arid');
        $setting = new admin_setting_configtext($name, $title, '', '', PARAM_RAW);
        $page->add($setting);

        // HEADER LABEL (defaults to sitename)
        $name = 'theme_arid/headerLabel';
        $title = get_string('headerlabel', 'theme_arid');
        $setting = new admin_setting_configtext($name, $title, '', '', PARAM_RAW);
        $page->add($setting);

        $name = 'theme_arid/headerLogo';
        $title = get_string('headerlogo', 'theme_arid');
        $setting = new admin_setting_configstoredfile($name, $title, '', 'headerlogo');
        $page->add($setting);

    $settings->add($page);

    // CSS related settings
    $page = new admin_settingpage('theme_arid_scss', get_string('scsssettings', 'theme_arid'));

        // Custom footer HTML.
        $name = 'theme_arid/fixedwidth';
        $title = get_string('fixedwidth', 'theme_arid');
        $desc = get_string('fixedwidth_desc', 'theme_arid');
        $setting = new admin_setting_configcheckbox($name, $title, $desc, 0, 1, 0);
        $page->add($setting);

        // Replicate the preset setting from boost; allow us to specify our own preset files.
        $name = 'theme_arid/preset';
        $title = get_string('preset', 'theme_boost');
        $description = get_string('preset_desc', 'theme_boost');
        $default = 'default.scss';
        $context = context_system::instance();
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'theme_arid', 'preset', 0, 'itemid, filepath, filename', false);
        $choices = [];
        foreach ($files as $file) {
            $choices[$file->get_filename()] = $file->get_filename();
        }
        $choices['default.scss'] = 'default.scss';
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // PRE SCSS
        $setting = new admin_setting_scsscode('theme_arid/scsspre',
            get_string('rawscsspre', 'theme_arid'), get_string('rawscsspre_desc', 'theme_arid'), '', PARAM_RAW);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // POST SCSS
        $setting = new admin_setting_scsscode('theme_arid/scss', get_string('rawscss', 'theme_arid'),
            get_string('rawscss_desc', 'theme_arid'), '', PARAM_RAW);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        // PAGE JS
        $setting = new admin_setting_configtextarea('theme_arid/js', get_string('rawjs', 'theme_arid'),
            get_string('rawjs_desc', 'theme_arid'), '', PARAM_RAW);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_arid_advanced', get_string('advancedsettings', 'theme_arid'));

        // HEADER CUSTOM HTML
        $name = 'theme_arid/headerHtml';
        $title = get_string('headerhtml', 'theme_arid');
        $desc = get_string('headerhtml_desc', 'theme_arid');
        $setting = new admin_setting_configtextarea($name, $title, $desc, '', PARAM_RAW);
        $page->add($setting);

        // Custom footer HTML.
        $name = 'theme_arid/footerHtml';
        $title = get_string('footerhtml', 'theme_arid');
        $desc = get_string('footerhtml_desc', 'theme_arid');
        $setting = new admin_setting_configtextarea($name, $title, $desc, '', PARAM_RAW);
        $page->add($setting);



    $settings->add($page);
}