<?php

namespace App\Http\Controllers;

use App\Models\SO;
use Mail;
use App\Mail\ClientMailer;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('setup');
        $this->middleware('agreed');
        $this->middleware('admin');
    }

    public function send($id)
    {
        return redirect()->back()->with('error', 'This feature is disabled for now!');

        $so = SO::findOrFail($id);
        $client = $so->project->client;

        $data = [
            'subject' => 'Invoice',
            'so' => $so,
            'client' => $client,
        ];

        try {
            Mail::to($client->email)->send(new ClientMailer($data));
            return redirect('/so')->with('success', 'Email sent successfully');
        } catch (\Exception $e) {
            return redirect('/so')->with('error', 'Something went wrong!');
        }
    }
}
