<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use Carbon\Carbon;
use App\Models\PcSession;
use App\Models\DiscussionRoom;
use App\Models\LostItem;
use App\Models\DiscussionRoomReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SuperadminmainnaniController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalBooks = Book::count();
        $totalAdmins = User::where('is_admin', true)->count(); // Add this line
        $totalDiscussionRooms = DiscussionRoom::count();

        return view('super-admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalAdmins',
            'totalDiscussionRooms'
        ));
    }


    public function manageAdmins()
    {
        $admins = User::where('is_admin', true)->get();
        return view('super-admin.manage-admins', compact('admins'));
    }

    public function createAdmin()
    {
        return view('super-admin.create-admin');
    }

    public function storeAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $admin = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_admin' => true,
        ]);

        Log::info('New admin created', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);

        return redirect()->route('super-admin.manage-admins')
            ->with('success', 'Admin created successfully');
    }

    public function deleteAdmin(Request $request, $adminId)
    {
        try {
            $admin = User::findOrFail($adminId);

            // Ensure we're not deleting the last admin
            $adminCount = User::where('is_admin', true)->count();
            if ($adminCount <= 1) {
                return redirect()->route('super-admin.manage-admins')
                    ->with('error', 'Cannot delete the last administrator.');
            }

            // Log the deletion
            Log::info('Admin deleted by super admin', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email
            ]);

            // Delete the admin
            $admin->delete();

            return redirect()->route('super-admin.manage-admins')
                ->with('success', 'Admin successfully deleted.');
        } catch (\Exception $e) {
            return redirect()->route('super-admin.manage-admins')
                ->with('error', 'An error occurred while deleting the admin.');
        }
    }
    public function userManagement()
    {
        $users = User::where('is_admin', false)->get();
        return view('super-admin.user-management', compact('users'));
    }
    public function deleteUser(Request $request, $userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Prevent deleting admin users
            if ($user->is_admin) {
                return redirect()->route('super-admin.user-management')
                    ->with('error', 'Cannot delete an administrator account.');
            }

            // Log the deletion
            Log::info('User deleted by super admin', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email
            ]);

            // Delete the user
            $user->delete();

            return redirect()->route('super-admin.user-management')
                ->with('success', 'User successfully deleted.');
        } catch (\Exception $e) {
            return redirect()->route('super-admin.user-management')
                ->with('error', 'An error occurred while deleting the user.');
        }
    }

    // You can remove the systemLogs method if it's no longer needed
    public function books()
    {
        $books = Book::with('category')->paginate(10);
        return view('super-admin.books.index', compact('books'));
    }
    public function sessionLogs()
    {
        $completedSessions = PcSession::with('user')
            ->where('status', 'completed')
            ->orderBy('end_time', 'desc')
            ->get();

        return view('super-admin.session-logs', [
            'completedSessions' => $completedSessions
        ]);
    }
    public function lostItemLogs()
    {
        $lostItemLogs = LostItem::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.lost-item-logs', [
            'lostItemLogs' => $lostItemLogs
        ]);
    }
    public function returnedBookLogs()
    {
        $returnedBooks = Borrow::with(['user', 'book'])
            ->whereNotNull('returned_at')
            ->orderBy('returned_at', 'desc')
            ->paginate(10);

        return view('super-admin.returned-book-logs', compact('returnedBooks'));
    }

    public function reportLogs(Request $request)
    {
        $query = Borrow::with(['user', 'book'])
            ->where('status', 'approved');

        // Handle status filter
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->whereNull('returned_at');
            } elseif ($request->status === 'returned') {
                $query->whereNotNull('returned_at');
            }
        }

        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        $allBorrows = $query->latest('borrow_date')
            ->paginate(10)
            ->appends(request()->query());

        return view('super-admin.report-logs', compact('allBorrows'));
    }
    public function discussionRoomHistory(Request $request)
    {
        $query = DiscussionRoomReservation::with(['user', 'discussionRoom']);

        // Validate and sanitize inputs
        $validStatuses = ['approved', 'rejected', 'pending'];

        // Status Filter with validation
        if ($request->filled('status') && in_array($request->status, $validStatuses)) {
            $query->where('status', $request->status);
        }

        // Search Filter with input sanitization
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('discussionRoom', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('purpose', 'like', "%{$search}%"); // Added purpose search
            });
        }

        // Additional optional date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            try {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // Log error, but don't break the query
                Log::warning('Invalid date range in discussion room history filter', [
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]);
            }
        }

        // Get paginated reservations
        $reservations = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(request()->query());

        // Get statistics for the dashboard
        $stats = [
            'total_reservations' => DiscussionRoomReservation::count(),
            'approved_count' => DiscussionRoomReservation::where('status', 'approved')->count(),
            'rejected_count' => DiscussionRoomReservation::where('status', 'rejected')->count(),
            'pending_count' => DiscussionRoomReservation::where('status', 'pending')->count(),
        ];

        return view('super-admin.history', compact('reservations', 'stats'));
    }
}
