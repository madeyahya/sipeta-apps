<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResidentRequest;
use App\Interfaces\ResidentRepositoryInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private ResidentRepositoryInterface $residentRepository;

    public function __construct(ResidentRepositoryInterface $residentRepository)
    {
        $this->residentRepository = $residentRepository;
    }


    public function index()
    {
        return view('pages.auth.register');
    }

    public function store(StoreResidentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('assets/avatar', 'public');
        } else {
            $data['avatar'] = null; // biarkan null, accessor yang urus fallback
        }

        $this->residentRepository->createResident($data);

        return redirect()->route('login')->with('success', "Pendaftaran Berhasil. Silahkan Login");
    }
}
