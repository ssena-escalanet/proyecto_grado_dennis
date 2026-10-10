<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDespachoDetalleRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [
            'estado_entrega' => 'required|in:Pendiente,Entregado,Rechazado',
            'hora_entrega' => 'required_if:estado_entrega,Entregado',
            'motivo_rechazo' => 'required_if:estado_entrega,Rechazado|max:150',
            'observaciones' => 'nullable|max:200'
        ];
    }
}
