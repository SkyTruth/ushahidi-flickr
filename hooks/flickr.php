<?php

require_once(Kohana::find_file('libs', 'phpFlickr-3.1/phpFlickr'));

class Flickr {
    public function __construct() {
        Event::add('ushahidi_action.report_approve', array($this, 'add'));
    }
 
    public function add() {
        $update = Event::$data;

        $api = new phpFlickr(Settings_Model::get_setting('flickr_key'), Settings_Model::get_setting('flickr_secret'));
        $api->setToken(Settings_Model::get_setting('flickr_token'));

        foreach($update->media as $media) {
            $api->async_upload('media/uploads/' . $media->media_link, $update->incident_title);
        }
    }
}
 
new Flickr;
