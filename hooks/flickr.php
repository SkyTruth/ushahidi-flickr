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

        $tags = array();
        foreach($update->incident_category as $incident_category) {
            array_push($tags, str_replace(" ", "-", $incident_category->category->category_title));
        }
        $tags = implode(" ", $tags);

        $lat = $update->location->latitude;
        $lon = $update->location->longitude;
        $title = $update->incident_title;
        $desc = $update->incident_description;

        foreach($update->media as $media) {
            $photoid = $api->sync_upload('media/uploads/' . $media->media_link, $title, $desc, $tags, true);
            $api->photos_geo_setLocation($photoid, $lat, $lon);
        }
    }
}
 
new Flickr;
