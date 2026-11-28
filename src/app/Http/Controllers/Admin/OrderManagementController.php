<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManagementController extends Controller
{
    /**
     * Lista de pedidos activos con filtros
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'user'])->latest();

        if ($request->filled('invoice_number')) {
            $query->where('invoice_number', 'like', '%' . trim($request->invoice_number) . '%');
        }

        if ($request->filled('customer_number')) {
            $customerNum = trim($request->customer_number);
            $query->whereHas('customer', function ($q) use ($customerNum) {
                $q->where('customer_number', 'like', '%' . $customerNum . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    /**
     * Formulario de creación de pedido
     */
    public function create()
    {
        $customers = Customer::orderBy('business_name')->get();
        $nextInvoice = (Order::withTrashed()->max('invoice_number') ?? 1000) + 1;

        return view('orders.create', compact('customers', 'nextInvoice'));
    }

    /**
     * Guardar pedido nuevo (siempre inicia en "Ordered")
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number'   => 'required|integer|unique:orders,invoice_number',
            'customer_number'  => 'required|string|max:20',
            'business_name'    => 'required|string|max:150',
            'tax_data'         => 'required|string',
            'delivery_address' => 'required|string',
            'notes'            => 'nullable|string',
            'created_at'       => 'nullable|date',
        ]);

        $customer = Customer::updateOrCreate(
            ['customer_number' => trim($validated['customer_number'])],
            [
                'business_name'   => $validated['business_name'],
                'tax_data'        => $validated['tax_data'],
                'default_address' => $validated['delivery_address'],
            ]
        );

        $order = new Order([
            'invoice_number'   => $validated['invoice_number'],
            'customer_id'      => $customer->id,
            'user_id'          => Auth::id(),
            'status'           => 'Ordered',
            'delivery_address' => $validated['delivery_address'],
            'notes'            => $validated['notes'] ?? null,
        ]);

        if (!empty($validated['created_at'])) {
            $order->created_at = $validated['created_at'];
        }

        $order->save();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$order->invoice_number} created with status Ordered.");
    }

    /**
     * Detalle y edición de pedido
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'user'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Actualizar pedido según permisos del rol logueado
     */
    public function update(Request $request, $id)
    {
        $order = Order::with('customer')->findOrFail($id);
        $role = Auth::user()->role->name ?? '';

        $validated = $request->validate([
            'status'           => 'required|in:Ordered,In process,In route,Delivered',
            'delivery_address' => 'nullable|string',
            'notes'            => 'nullable|string',
            'business_name'    => 'nullable|string|max:150',
            'tax_data'         => 'nullable|string',
        ]);

        $order->status = $validated['status'];
        $order->notes = $validated['notes'] ?? $order->notes;

        if (in_array($role, ['Admin', 'Administrator', 'Sales', 'Ventas'])) {
            if (!empty($validated['delivery_address'])) {
                $order->delivery_address = $validated['delivery_address'];
            }
            if ($order->customer) {
                $order->customer->update([
                    'business_name' => $validated['business_name'] ?? $order->customer->business_name,
                    'tax_data'      => $validated['tax_data'] ?? $order->customer->tax_data,
                ]);
            }
        }

        $order->save();

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', "Order #{$order->invoice_number} updated successfully.");
    }

    /**
     * Borrado lógico (Soft Delete)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$order->invoice_number} moved to Deleted Orders.");
    }

    /**
     * Pantalla separada de pedidos eliminados lógicamente
     */
    public function trashed(Request $request)
    {
        $query = Order::onlyTrashed()->with(['customer', 'user'])->latest('deleted_at');

        if ($request->filled('search')) {
            $term = trim($request->search);
            $query->where(function ($q) use ($term) {
                $q->where('invoice_number', 'like', "%{$term}%")
                  ->orWhereHas('customer', function ($cq) use ($term) {
                      $cq->where('customer_number', 'like', "%{$term}%")
                         ->orWhere('business_name', 'like', "%{$term}%");
                  });
            });
        }

        $deletedOrders = $query->paginate(10)->withQueryString();

        return view('orders.deleted', compact('deletedOrders'));
    }

    /**
     * Editar pedido eliminado
     */
    public function updateTrashed(Request $request, $id)
    {
        $order = Order::onlyTrashed()->with('customer')->findOrFail($id);

        $validated = $request->validate([
            'status'           => 'required|in:Ordered,In process,In route,Delivered',
            'delivery_address' => 'required|string',
            'notes'            => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()
            ->route('admin.orders.deleted')
            ->with('success', "Deleted order #{$order->invoice_number} updated.");
    }

    /**
     * Restaurar pedido eliminado
     */
    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$order->invoice_number} restored to active orders.");
    }
}