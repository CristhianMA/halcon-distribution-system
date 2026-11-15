<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Listar órdenes ordenadas de la más reciente a la más antigua.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'user'])
            ->latest()
            ->paginate(15);

        return response()->json($orders, 200);
    }

    /**
     * Crear una nueva orden.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number'   => 'required|string|max:50|unique:orders,invoice_number',
            'customer_id'      => 'required|exists:customers,id',
            'user_id'          => 'required|exists:users,id',
            'status'           => 'nullable|string|in:Ordered,In process,In route,Delivered',
            'delivery_address' => 'required|string|max:255',
            'notes'            => 'nullable|string',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'Ordered';
        }

        $order = Order::create($validated);

        return response()->json($order->load(['customer', 'user']), 201);
    }

    /**
     * Obtener una orden específica por ID.
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'user'])->findOrFail($id);
        return response()->json($order, 200);
    }

    /**
     * Buscar una orden por folio de factura (invoice_number).
     */
    public function searchByInvoice($invoice_number)
    {
        $order = Order::with(['customer', 'user'])
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();

        return response()->json($order, 200);
    }

    /**
     * Actualizar una orden o cambiar su estatus.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status'           => 'nullable|string|in:Ordered,In process,In route,Delivered',
            'delivery_address' => 'nullable|string|max:255',
            'notes'            => 'nullable|string',
            'user_id'          => 'nullable|exists:users,id',
        ]);

        $order->update($validated);

        return response()->json($order->fresh(['customer', 'user']), 200);
    }

    /**
     * Borrado lógico (archivar orden / soft delete).
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Order successfully archived (soft deleted)',
            'order_id' => $id
        ], 200);
    }

    /**
     * Listar órdenes archivadas / eliminadas lógicamente.
     */
    public function archived()
    {
        $archivedOrders = Order::onlyTrashed()
            ->with(['customer', 'user'])
            ->latest('deleted_at')
            ->paginate(15);

        return response()->json($archivedOrders, 200);
    }

    /**
     * Rastrear orden por Customer Number (ID o código CLI-XXXX) e Invoice Number.
     */
    public function trackOrder(Request $request)
    {
        $request->validate([
            'customer_number' => 'required',
            'invoice_number'  => 'required',
        ]);

        $customerInput = trim($request->customer_number);

        $order = Order::with(['customer', 'user'])
            ->where('invoice_number', trim($request->invoice_number))
            ->where(function ($query) use ($customerInput) {
                $query->where('customer_id', $customerInput)
                      ->orWhereHas('customer', function ($q) use ($customerInput) {
                          $q->where('customer_number', $customerInput);
                      });
            })
            ->first();

        if (!$order) {
            return response()->json([
                'message' => 'No order found with that Customer Number and Invoice Number.'
            ], 404);
        }

        return response()->json($order, 200);
    }
}