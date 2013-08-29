<?php

class Search_Controller extends Base_Controller {

    public function action_search() {
        $query = trim(Input::get('q'));
        $matches = Thread::where('title', 'LIKE', '%' . $query . '%')->order_by('updated_at', 'desc')->take(Config::get('ezrahub.num_homepage_threads'))->get();
        Section::inject('title', 'Search for "' . $query . '"');
        Section::inject('description', 'Ezra Hub is a popular and student-run forum for Cornell University students. Anonymous posting and user accounts are allowed and everything from frats, sororities, classes, drugs, housing and more is discussed. Ezra Hub is not endorsed by Cornell University.');
        Section::inject('canonical', '<link rel="canonical" href="http://ezrahub.com/search/' . $query . '"/>');
        $this->layout->nest('content', 'home.searchresults', array('threads' => $matches, 'query' => $query));
    }
}
