<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::with('jobs')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'cnpj' => 'required|unique:companies,cnpj',
            'plan' => 'required|in:Free,Premium',
        ]);

        $company = Company::create($data);
        return response()->json($company, 201);
    }

    public function show(Company $company)
    {
        return $company->load('jobs');
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'cnpj' => 'sometimes|unique:companies,cnpj,' . $company->id,
            'plan' => 'sometimes|in:Free,Premium',
        ]);

        $company->update($data);
        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(['message' => 'Empresa removida']);
    }
}