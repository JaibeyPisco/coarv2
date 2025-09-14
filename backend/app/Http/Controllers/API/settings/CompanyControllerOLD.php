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

    public function index() : JsonResponse {
        try {
            // Obtener la primera empresa (asumiendo que solo hay una)
            $company = Company::first();
            
            if (!$company) {
                return $this->sendResponse([
                    'id' => null,
                    'numero_documento' => '',
                    'razon_social' => '',
                    'nombre_comercial' => '',
                    'direccion' => '',
                    'telefono' => '',
                    'email' => '',
                    'logo' => '',
                    'logo_factura' => ''
                ], 'No hay datos de empresa configurados.');
            }

            // Mapear los campos del modelo a los nombres esperados por el frontend
            $data = [
                'id' => $company->id,
                'numero_documento' => $company->document_number,
                'razon_social' => $company->business_name,
                'nombre_comercial' => $company->trade_name,
                'direccion' => $company->address,
                'telefono' => $company->phone,
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
     * Guardar empresa
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'numero_documento' => 'required|string|max:255',
                'razon_social' => 'required|string|max:255',
                'nombre_comercial' => 'required|string|max:255',
                'direccion' => 'required|string|max:500',
                'telefono' => 'required|string|max:20',
                'email' => 'required|email|max:255',
            ]);

            if($validator->fails()){
                return $this->sendError('Error de validación.', $validator->errors());
            }

            $input = $request->all();
            
            // Manejar imágenes siguiendo el patrón del UserController
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

            // Mapear campos del frontend al modelo
            $companyData = [
                'document_number' => $input['numero_documento'],
                'business_name' => $input['razon_social'],
                'trade_name' => $input['nombre_comercial'],
                'address' => $input['direccion'],
                'phone' => $input['telefono'],
                'email' => $input['email'],
            ];

            // Si hay logos, agregarlos
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

            // Retornar la información completa para llenar los campos
            $responseData = [
                'id' => $company->id,
                'numero_documento' => $company->document_number,
                'razon_social' => $company->business_name,
                'nombre_comercial' => $company->trade_name,
                'direccion' => $company->address,
                'telefono' => $company->phone,
                'email' => $company->email,
                'logo' => $company->logo ?? '',
                'logo_factura' => $company->logo_factura ?? ''
            ];

            return $this->sendResponse($responseData, $message);
            
        } catch (\Exception $e) {
            return $this->sendError('Error al guardar empresa.', $e->getMessage());
        }
    }

    /**
     * Editar empresa existente
     */
    public function edit(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:empresa,id',
                'numero_documento' => 'required|string|max:255',
                'razon_social' => 'required|string|max:255',
                'nombre_comercial' => 'required|string|max:255',
                'direccion' => 'required|string|max:500',
                'telefono' => 'required|string|max:20',
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Error de validaciones.', $validator->errors());
            }

            $company = Company::find($request->id);
            
            if (!$company) {
                return $this->sendError('Empresa no encontrada.');
            }

            $input = $request->all();

            // Manejar imágenes siguiendo el patrón del UserController
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

            // Mapear campos del frontend al modelo
            $companyData = [
                'document_number' => $input['numero_documento'],
                'business_name' => $input['razon_social'],
                'trade_name' => $input['nombre_comercial'],
                'address' => $input['direccion'],
                'phone' => $input['telefono'],
                'email' => $input['email'],
            ];

            // Si hay logos, agregarlos
            if (isset($input['logo'])) {
                $companyData['logo'] = $input['logo'];
            }
            
            if (isset($input['logo_factura'])) {
                $companyData['logo_factura'] = $input['logo_factura'];
            }

            $company->update($companyData);

            // Retornar la información completa para llenar los campos
            $responseData = [
                'id' => $company->id,
                'numero_documento' => $company->document_number,
                'razon_social' => $company->business_name,
                'nombre_comercial' => $company->trade_name,
                'direccion' => $company->address,
                'telefono' => $company->phone,
                'email' => $company->email,
                'logo' => $company->logo ?? '',
                'logo_factura' => $company->logo_factura ?? ''
            ];

            return $this->sendResponse($responseData, 'Empresa actualizada correctamente.');
            
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar empresa.', $e->getMessage());
        }
    }
}




