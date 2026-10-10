<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'fecha_pedido' => 'required|date',
            'fecha_entrega_est' => 'required|date|after_or_equal:fecha_pedido',
            'estado_pedido' => 'required|in:Pendiente,En Despacho,Entregado,Rechazado,Pagado,Cancelado',
        ];
    }
}
