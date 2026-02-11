<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Company;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return Job::with('company')->get();
    }

    public function store(Request $request)
   {
    $data = $request->validate([
        'company_id' => 'required|exists:companies,id',
        'title' => 'required|string',
        'description' => 'nullable|string',
        'type' => 'required|in:pj,clt,internship',
        'salary' => 'nullable|numeric',
        'workload' => 'nullable|integer',
    ]);

    $company = Company::find($data['company_id']);
    $limit = $company->plan === 'Free' ? 5 : 10;

    if ($company->jobs()->count() >= $limit) {
        return response()->json(['message' => "Plano {$company->plan} permite até {$limit} vagas"], 422);
    }

    // Validações específicas por tipo
    if ($data['type'] === 'clt') {
        if (!isset($data['salary']) || $data['salary'] < 1212) {
            return response()->json(['message' => 'CLT deve ter salário mínimo 1212'], 422);
        }
        if (!isset($data['workload'])) {
            return response()->json(['message' => 'CLT deve ter workload'], 422);
        }
    }

    if ($data['type'] === 'internship') {
        if (!isset($data['workload']) || $data['workload'] > 6) {
            return response()->json(['message' => 'Estágio deve ter workload ≤ 6 horas'], 422);
        }
    }

    $job = Job::create($data);
    return response()->json($job, 201);
}

    public function show(Job $job)
    {
        return $job->load('company');
    }

    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'type' => 'sometimes|in:pj,clt,internship',
            'salary' => 'sometimes|numeric',
            'workload' => 'sometimes|integer',
        ]);

        $job->update($data);
        return response()->json($job);
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return response()->json(['message' => 'Vaga removida']);
    }
}