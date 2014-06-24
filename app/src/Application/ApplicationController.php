<?php
namespace Application;

use Event\EventApi;

class ApplicationController extends BaseController
{
    protected function defineRoutes(\Slim\Slim $app)
    {
        $app->get('/', array($this, 'index'));
        $app->get('/apps', array($this, 'apps'))->name('apps');
        $app->get('/about', array($this, 'about'))->name('about');
    }

    public function index()
    {
        $page    = $this->application->request()->get('page');
        $page    = ((int)$page === 0) ? 1 : $page;
        $perPage = 6;
        $start   = ($page -1) * $perPage;

        $events = $this->getEventApi()->getCollection($perPage, $start, 'hot');

        $this->render('Application/index.html.twig', array('events' => $events, 'page'   => $page));
    }

    public function apps()
    {
        $this->render('Application/apps.html.twig');
    }

    /**
     * Render the about page
     */
    public function about()
    {
        $this->render('Application/about.html.twig');
    }

    /**
     * Returns the service used to talk to the API for events.
     *
     * @return EventApi
     */
    protected function getEventApi()
    {
        return $this->application->event_api_service;
    }
}
