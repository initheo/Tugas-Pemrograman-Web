<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index() // nama fungsi yang tampil secara default
    {
        $employees = Employee::latest()->paginate(5); // data yang ditampilkan maksimal sebelum ada info next.
        return view('employees.index', compact('employees')); // memanggil views untuk tampilan
    }

    public function create() // nama fungsi create
    {
        return view('employees.create'); // memanggil views
    }

    public function store(Request $request) //fungsi untuk requst pengiriman ke DB
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'nullable|email',
            'jabatan' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Employee berhasil ditambahkan.'); // jika sukses akan di redirect ke halaman index
    }

    public function show(Employee $employee) // fungsi untuk detail dengan pengambilan data dari Models
    {
        return view('employees.show', compact('employee')); //memanggil ke views 
    }

    public function edit(Employee $employee) // fungsi edit dengan pengambilan data dari Models
    {
        return view('employees.edit', compact('employee')); //memanggil ke views 
    }

    public function update(Request $request, Employee $employee)
    {

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'nullable|email',
            'jabatan' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Employee berhasil diperbarui.');
    }

    public function destroy(Employee $employee)

    {
        $employee->delete(); // Fungsi Hapus by Id dari DB

        return redirect()->route('employees.index')
            ->with('success', 'Employee berhasil dihapus.');
    }
}
