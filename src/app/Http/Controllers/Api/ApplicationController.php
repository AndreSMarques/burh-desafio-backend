<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'resume' => 'nullable|url',
        ]);

        // Evita candidatura duplicada
        if (Application::where('user_id', $data['user_id'])->where('job_id', $data['job_id'])->exists()) {
            return response()->json(['message' => 'Usuário já se candidatou'], 422);
        }

        $application = Application::create($data);
        return response()->json($application, 201);
    }

    public function index()
    {
        return Application::with('user', 'job.company')->get();
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return response()->json(['message' => 'Candidatura removida']);
    }
}