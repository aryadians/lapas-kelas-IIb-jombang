<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the announcements.
     */
    public function index(Request $request)
    {
        $allAnnouncements = Announcement::where('status', 'published')->latest('date')->paginate(5);

        if ($request->query('json') === 'true') {
            return response()->json($allAnnouncements);
        }

        return view('announcements.index', compact('allAnnouncements'));
    }

    /**
     * Display the specified announcement.
     */
    public function show(Announcement $announcement)
    {
        // Ensure only published announcements are shown
        if ($announcement->status !== 'published') {
            abort(404);
        }

        return view('announcements.show', compact('announcement'));
    }
}
