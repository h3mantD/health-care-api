<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientConsultationRequest;
use App\Http\Requests\PatientDemographicsRequest;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\PatientConsultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocController extends Controller
{
    public $user;
    protected $patient = null;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function setUser()
    {
        $this->user = Auth::user();
    }

    public function getPatients(Request $request)
    {
        try {
            $this->setUser();
            $consultations = $this->user->doctor->consultation->pluck('id')->toArray();
            $patientsWithConsultations = PatientConsultation::with('patient.user')
                ->whereIn('consultation_id', $consultations)
                ->get();

            $patientDetails = collect([]);
            foreach ($patientsWithConsultations as $patientConsultations) {
                $patientDetails->add($patientConsultations->patient);
            }

            return response()->json($patientDetails);
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    public function checkForPatientsConsent()
    {
        if (session('user_id')) {
            if (!$this->patient || $this->patient->user_id != session('user_id')) {
                $this->patient = Patient::whereUserId(session('user_id'))->first();

                if (!$this->patient) {
                    throw new \Exception('No Patient Found!', 404);
                }
            }
            return true;
        }

        throw new \Exception('You are not authorized to get this patient details!', 403);
    }

    public function getPatientConsultations()
    {
        $this->setUser();
        try {
            if ($this->checkForPatientsConsent()) {
                $consultations = $this->patient->getConsultationsWithAuthenticatedDoc();
                return response()->json($consultations);
            }
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    public function getPatientHistory()
    {
        try {
            $this->setUser();
            if ($this->checkForPatientsConsent()) {
                $consultations = $this->patient->patient_consultation;
                return response()->json($consultations);
            }
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    public function addUpdatePatientDemographic(PatientDemographicsRequest $request)
    {
        try {
            $this->setUser();
            if ($this->checkForPatientsConsent()) {
                $validated = $request->validated();

                $patient = Patient::updateOrCreate(['user_id' => session('user_id')], ['demographics' => $validated]);

                return response()->json([
                    'status' => true,
                    'message' => 'Added/Updated patient demographics',
                    'patient' => $patient,
                ]);
            }
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }

    public function addConsultation(PatientConsultationRequest $request)
    {
        try {
            $this->setUser();
            if ($this->checkForPatientsConsent()) {
                $validated = $request->validated();
                $validated['doctor_id'] = Auth::user()->id;

                $consultation = Consultation::create($validated);

                return response()->json([
                    'status' => true,
                    'message' => 'Create Consultation',
                    'consultation' => $consultation,
                ]);
            }
        } catch (\Throwable $th) {
            return errorResponse($th->getMessage());
        }
    }
}
