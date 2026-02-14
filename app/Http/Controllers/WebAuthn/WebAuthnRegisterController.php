<?php

namespace App\Http\Controllers\WebAuthn;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Laragear\WebAuthn\Http\Requests\AttestationRequest;
use Laragear\WebAuthn\Http\Requests\AttestedRequest;

use function response;

class WebAuthnRegisterController
{
    /**
     * Returns a challenge to be verified by the user device.
     */
    public function options(AttestationRequest $request): Responsable|JsonResponse
    {
        try {
            \Illuminate\Support\Facades\Log::info('WebAuthn Register Options called', ['user' => auth()->id()]);
            return $request
                ->fastRegistration()
//            ->userless()
//            ->allowDuplicates()
                ->toCreate();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WebAuthn Register Options failed', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to generate registration challenge: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registers a device for further WebAuthn authentication.
     */
    public function register(AttestedRequest $request): Response|JsonResponse
    {
        try {
            $data = $request->all();
            $credentialId = $request->save([
                'alias' => $data['name'] ?? 'Unnamed Passkey',
            ]);
            \Illuminate\Support\Facades\Log::info('WebAuthn Credential saved', ['id' => $credentialId, 'alias' => $data['name'] ?? 'N/A']);
            return response()->noContent();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WebAuthn Register Store failed', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to register passkey: ' . $e->getMessage()
            ], 500);
        }
    }
}
