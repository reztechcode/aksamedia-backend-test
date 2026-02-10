<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $q = Employee::query()->with('division');

        if ($request->filled('name')) {
            $name = $request->query('name');
            $q->where('name', 'like', "%{$name}%");
        }

        if ($request->filled('division_id')) {
            $q->where('division_id', $request->query('division_id'));
        }

        $employees = $q->latest()->paginate(10)->withQueryString();

        // mapping sesuai format soal + image jadi URL
        $mapped = collect($employees->items())->map(function ($e) {
            $imageUrl = null;
            if ($e->image) {
                $imageUrl = str_starts_with($e->image, 'http')
                    ? $e->image
                    : url(Storage::url($e->image));
            }

            return [
                'id'       => $e->id,
                'image'    => $imageUrl,
                'name'     => $e->name,
                'phone'    => $e->phone,
                'division' => [
                    'id'   => $e->division?->id,
                    'name' => $e->division?->name,
                ],
                'position' => $e->position,
            ];
        })->values();

        return $this->ok('OK', [
            'employees' => $mapped,
        ], $employees->toArray());
    }

    public function store(EmployeeStoreRequest $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('employees', 'public');
        }

        Employee::create([
            'image' => $path,
            'name' => $request->name,
            'phone' => $request->phone,
            'division_id' => $request->division,
            'position' => $request->position,
        ]);

        return $this->ok('Berhasil menambahkan karyawan.',);
    }

    public function show(Employee $employee)
    {
        return $this->ok('Show Employee', [
            'employee' => [
                'id' => $employee->id,
                'image' => $employee->image,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'division' => [
                    'id' => $employee->division?->id,
                    'name' => $employee->division?->name,
                ],
                'position' => $employee->position,
            ],
        ]);
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
        $path = $employee->image;

        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::disk('public')->delete($employee->image);
            }
            $path = $request->file('image')->store('employees', 'public');
        }

        $employee->update([
            'image' => $path,
            'name' => $request->name,
            'phone' => $request->phone,
            'division_id' => $request->division,
            'position' => $request->position,
        ]);

        return $this->ok('Berhasil memperbarui karyawan.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->image) {
            Storage::disk('public')->delete($employee->image);
        }

        $employee->delete();

        return $this->ok('Berhasil menghapus karyawan.');
    }
}
