<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Flickr Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Egil Moeller <egil@skytruth.org>
 * @package    Flickr - http://source.ushahididev.com
 * @module     Flickr Settings Controller	
 * @copyright  SkyTruth.org & Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
* 
*/

require_once(Kohana::find_file('libs', 'phpFlickr-3.1/phpFlickr'));

class Flickr_Settings_Controller extends Admin_Controller {
    public function index()	{
        $this->template->this_page = 'addons';
        $this->template->content = new View("admin/addons/plugin_settings");
        $this->template->content->title = "Flickr Settings";
        $this->template->content->settings_form = new View("flickr/admin/flickr_settings");

        $form = array('flickr_key' => '', 'flickr_secret' => '');
        $errors = $form;
        $form_error = FALSE;
        $form_saved = FALSE;

        if ($_POST) {
            $post = new Validation($_POST);
            $post->pre_filter('trim', TRUE);
            $post->add_rules('flickr_key','required', 'length[32,32]');
            $post->add_rules('flickr_secret', 'required', 'length[16,16]');

            if ($post->validate()) {
                Settings_Model::save_setting('flickr_key', $post->flickr_key);
                Settings_Model::save_setting('flickr_secret', $post->flickr_secret);

                $api = new phpFlickr(Settings_Model::get_setting('flickr_key'), Settings_Model::get_setting('flickr_secret'));
                $api->auth("write");
            } else {
                $form = arr::overwrite($form, $post->as_array());
                $errors = arr::overwrite($errors, $post->errors('settings'));
                $form_error = TRUE;
            }
        } else {
            if (array_key_exists('frob', $_GET)) {
                $api = new phpFlickr(Settings_Model::get_setting('flickr_key'), Settings_Model::get_setting('flickr_secret'));
                $token = $api->auth_getToken($_GET['frob']);
                Settings_Model::save_setting('flickr_token', $token['token']);
            }

            $form = array(
                'flickr_key' => Settings_Model::get_setting('flickr_key'),
                'flickr_secret' => Settings_Model::get_setting('flickr_secret'),
                'flickr_token' => Settings_Model::get_setting('flickr_token')
            );
        }
		
        $this->template->content->settings_form->form = $form;
        $this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
    }
}
