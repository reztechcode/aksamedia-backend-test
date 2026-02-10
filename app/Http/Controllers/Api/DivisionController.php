<?php

namespace App\Http\Controllers\Api;

use App\Models\Division;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $q = Division::query();

        if ($request->filled('name')) {
            $name = $request->query('name');
            $q->where('name', 'like', "%{$name}%");
        }

        $divisions = $q->orderBy('name')->paginate(10)->withQueryString();

        $pagination = $divisions->toArray();
        unset($pagination['data']);

        return $this->ok('OK', [
            'divisions' => $divisions->items(),
        ], $pagination);
    }
}
