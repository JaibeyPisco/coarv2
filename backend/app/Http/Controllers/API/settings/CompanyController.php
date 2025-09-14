<?php

namespace App\Http\Controllers\API\settings;
 
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Settings\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CompanyController extends BaseController
{
    /**
     * Obtener datos de la empresa
     */
    public function index(): JsonResponse 
    {
        try {
            $company = Company::first();
            
            if (!$company) {
                return $this->sendResponse([
                    'id' => null,
                    'document_number' => '',
                    'business_name' => '',
                    'trade_name' => '',
                    'address' => '',
                    'phone' => '',
                    'email' => '',
                    'logo' => '',
                    'logo_factura' => ''
                ], 'No hay datos de empresa configurados.');
            }

            // Retornar directamente los datos del modelo
            $data = [
                'id' => $company->id,
                'document_number' => $company->document_number,
                'business_name' => $company->business_name,
                'trade_name' => $company->trade_name,
                'address' => $company->address,
                'phone' => $company->phone,
                'email' => $company->email,
                'logo' => $company->logo ?? '',
                'logo_factura' => $company->logo_factura ?? ''
            ];

            return $this->sendResponse($data, 'Datos de empresa obtenidos correctamente.');
        } catch (\Exception $e) {
            return $this->sendError('Error al obtener datos de empresa.', $e->getMessage());
        }
    }

    /**
     * Guardar empresa (crear o actualizar)
     * Usa una sola función para ambos casos según las instrucciones
     */
    public function save(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'document_number' => 'required|string|max:255',
                'business_name' => 'required|string|max:255',
                'trade_name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Error de validación.', $validator->errors());
            }

            $input = $request->all();
            
            // Manejar imágenes usando Storage de Laravel
            if ($request->hasFile('imagen')) {
                $logo = $request->file('imagen')->store('images', 'public');
                $urlLogo = Storage::url($logo);
                $input['logo'] = $urlLogo;
            }
            
            if ($request->hasFile('imagen_factura')) {
                $docLogo = $request->file('imagen_factura')->store('images', 'public');
                $urlDocLogo = Storage::url($docLogo);
                $input['logo_factura'] = $urlDocLogo;
            }

            // Usar directamente los nombres del modelo
            $companyData = [
                'document_number' => $input['document_number'],
                'business_name' => $input['business_name'],
                'trade_name' => $input['trade_name'],
                'address' => $input['address'],
                'phone' => $input['phone'],
                'email' => $input['email'],
            ];

            // Agregar logos si existen
            if (isset($input['logo'])) {
                $companyData['logo'] = $input['logo'];
            }
            
            if (isset($input['logo_factura'])) {
                $companyData['logo_factura'] = $input['logo_factura'];
            }

            // Buscar si ya existe una empresa
            $company = Company::first();
            
            if ($company) {
                // Actualizar empresa existente
                $company->update($companyData);
                $message = 'Empresa actualizada correctamente.';
            } else {
                // Crear nueva empresa
                $company = Company::create($companyData);
                $message = 'Empresa creada correctamente.';
            }

            // Retornar directamente los datos del modelo actualizado
            // $responseData = [
            //     'id' => $company->id,
            //     'document_number' => $company->document_number,
            //     'business_name' => $company->business_name,
            //     'trade_name' => $company->trade_name,
            //     'address' => $company->address,
            //     'phone' => $company->phone,
            //     'email' => $company->email,
            //     'logo' => $company->logo ?? '',
            //     'logo_factura' => $company->logo_factura ?? ''
            // ];

            return $this->sendResponse([], $message);
            
        } catch (\Exception $e) {
            return $this->sendError('Error al guardar empresa.', $e->getMessage());
        }
    }
}
