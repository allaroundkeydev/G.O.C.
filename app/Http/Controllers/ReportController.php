<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tasksDue(Request $request)
    {
        // Logic to get tasks due in the next X days
        return response()->json([]);
    }

    /**
     * Display a listing of the resource.
     */
    public function tasksByStatus(Request $request)
    {
        // Logic to get tasks grouped by status
        return response()->json([]);
    }
}
