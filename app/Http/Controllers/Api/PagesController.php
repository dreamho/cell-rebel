<?php

namespace Ranking\Http\Controllers\Api;

use Illuminate\Support\Facades\Mail;
use Ranking\Http\Controllers\Controller;
use Ranking\Http\Requests\ContactRequest;

class PagesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

	public function about()
    {
        return $this->sendResponse([
            "view"      => "ptypev2.content.about",
            "data"      => [
                "content"   => "Content goes here..."
            ]
        ]);
    }

    public function contact()
    {
        return $this->sendResponse([
            "view"  => "ptypev2.content.contact_us",
            "data"  => [
                "content"   => "Content goes here..."
            ]
        ]);
    }

    public function contactPost(ContactRequest $request)
    {
        Mail::send('email.contact',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message) use($request)
            {
                $message
                    ->from(env('SENDER_EMAIL'))
                    ->to(env('ADMIN_EMAIL'), 'Admin')
                    ->subject('New Contact - '.$request->get('name'));
            });

        return back()->with('success', 'Thanks for contacting us!');
    }

    public function configs()
    {
        $result = [];
        $result['countries'] = $this->getApiCountries();

        $result['test_youtube'] = $this->youtubeTestLink;
        $result['test_site']    = $this->siteTestLink;
        $result['test_file']    = $this->fileTestLink;

        $result['active_measurements_every_hours'] = $this->active_measurements_every_hours;
        $result['background_measurements_every_hours'] = $this->background_measurements_every_hours;

        $result['timeout_file'] = $this->timeout_file;
        $result['timeout_site'] = $this->timeout_site;
        $result['timeout_youtube'] = $this->timeout_youtube;


        return $this->sendResponse([
            "data"  => [
                "configs" => $result
            ]
        ]);
    }
}
