<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreDespachoDetalleRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [
            'detalles' => 'required|array',
            'detalles.*' => 'exists:detalle_pedido,id_detalle_pedido'
        ];
    }
}
