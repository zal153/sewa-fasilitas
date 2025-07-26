<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function page(Request $request)
    {
        $query = Auth::user()->notifications()
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        // Filter berdasarkan tipe
        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('data->title', 'like', '%' . $request->search . '%')
                    ->orWhere('data->message', 'like', '%' . $request->search . '%');
            });
        }

        $notifications = $query->paginate(15);

        // Get statistics
        $allNotifications = Auth::user()->notifications();
        $stats = [
            'total' => $allNotifications->count(),
            'unread' => $allNotifications->whereNull('read_at')->count(),
            'read' => $allNotifications->whereNotNull('read_at')->count(),
        ];

        // Get notification types for filter
        $types = Auth::user()->notifications()
            ->select('type', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notification) {
                $type = class_basename($notification->type);
                return [
                    'value' => $type,
                    'label' => $this->getTypeLabel($type)
                ];
            })
            ->unique('value') // Unik berdasarkan 'value' (alias nama class notifikasi)
            ->values();

        return view('user.notifikasi.index', compact('notifications', 'stats', 'types'));
    }

    private function getTypeLabel($type)
    {
        $labels = [
            'PeminjamanDisetujuiNotification' => 'Peminjaman Disetujui',
            'PembayaranDisetujuiNotification' => 'Pembayaran Disetujui',
        ];

        return $labels[$type] ?? ucfirst(str_replace('Notification', '', $type));
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                $data = $notification->data;
                return [
                    'id' => $notification->id,
                    'type' => $data['type'] ?? class_basename($notification->type),
                    'title' => $data['title'] ?? '',
                    'message' => $data['message'] ?? '',
                    'read_at' => $notification->read_at,
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'data' => $data['data'] ?? []
                ];
            });

        return response()->json($notifications);
    }

    public function count()
    {
        $count = Auth::user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    public function bulkMarkAsRead(Request $request)
    {
        $ids = $request->ids;

        Auth::user()->notifications()
            ->whereIn('id', $ids)
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Notifikasi berhasil ditandai sebagai dibaca');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        Auth::user()->notifications()
            ->whereIn('id', $ids)
            ->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }

    public function delete($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan');
    }
}
