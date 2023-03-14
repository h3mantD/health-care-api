<?php

namespace App\Services;

use App\Models\PatientConsultation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    public function login($request)
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $role = $request->role;
            $authUser = Auth::user();

            if (!User::find($authUser->id)->checkRole($role)) {
                return $this->logout($request, false, 'Role does not match');
            } else {
                return $this->returnResponseAfterUserIsLoggedIn($role);
            }

            return response()->json(['status' => true, 'message' => 'User logged in!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function logout($request, $status = null, $message = null)
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->json(['status' => $status ?? true, 'message' => $message ?? 'User Logged Out!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function returnResponseAfterUserIsLoggedIn($role)
    {
        $user = Auth::user();
        switch ($role) {
            case 'doctor':
                $consultations = $user->doctor->consultation->pluck('id')->toArray();
                $patientsWithConsultations = PatientConsultation::with('patient.user')
                    ->whereIn('consultation_id', $consultations)
                    ->get();

                $patientDetails = collect([]);
                foreach ($patientsWithConsultations as $patientConsultations) {
                    $patientDetails->add($patientConsultations->patient);
                }

                return response()->json($patientDetails);
                break;

            case 'patient':
                # code...
                break;

            case 'gov':
                # code...
                break;

            default:
                # code...
                break;
        }

        return response()->json([]);
    }
}
