<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LostItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminLostItemController extends Controller
{
    // Display list of lost items for admins
    public function index()
    {
        $lostItems = LostItem::with('user')->latest()->get();


        return view('admin.lost_items.index', compact('lostItems'));
    }

    // Show the form for admins to report a new lost item
    public function create()
    {
        return view('admin.lost_items.create');
    }

    public function show(LostItem $lostItem)
    {
        return view('admin.lost_items.show', compact('lostItem'));
    }

    // Store a new lost item in the database (for admins)
    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_lost' => 'required|date',
            'time_lost' => 'required',
            'location' => 'required|string|max:255',
        ]);

        $lostItem = LostItem::create([
            'user_id' => Auth::id(),
            'item_type' => $request->item_type,
            'description' => $request->description,
            'date_lost' => $request->date_lost,
            'time_lost' => $request->time_lost,
            'location' => $request->location,
            'status' => 'lost',
        ]);

        return redirect()->route('admin.lost_items.index')->with('success', 'Lost item reported successfully.');
    }

    // Update method with edit prevention
    public function update(Request $request, LostItem $lostItem)
    {
        // Check if the item is editable
        if (!$lostItem->isEditable()) {
            return redirect()->route('admin.lost_items.index')
                ->with('error', 'Found items cannot be edited.');
        }

        $request->validate([
            'item_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_lost' => 'required|date',
            'time_lost' => 'required',
            'location' => 'required|string|max:255',
        ]);

        $lostItem->update($request->validated());

        return redirect()->route('admin.lost_items.index')
            ->with('success', 'Lost item updated successfully.');
    }

    // Update the status of an item (e.g., mark as found)
    public function updateStatus(Request $request, LostItem $lostItem)
    {
        $request->validate([
            'status' => ['required', Rule::in(['lost', 'found'])],
        ]);

        // Prevent changing status from 'found' back to 'lost'
        if ($lostItem->status === 'found' && $request->status === 'lost') {
            return redirect()->route('admin.lost_items.index')
                ->with('error', 'Cannot change status from Found to Lost.');
        }

        $lostItem->status = $request->status;
        $lostItem->save();

        return redirect()->route('admin.lost_items.index')
            ->with('success', 'Item status updated.');
    }

    // Delete a lost item
    public function destroy(LostItem $lostItem)
    {
        $lostItem->delete();

        return redirect()->route('admin.lost_items.index')->with('success', 'Lost item deleted.');
    }
}
