<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Traits\FileUploadTrait;

class FaqController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return view('admin.faq.index');
    }

    public function getData(Request $request)
    {
        $query = Faq::orderBy('sort_order', 'asc');

        // Optional filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        return DataTables::of($query)
            ->addColumn('image', function ($row) {
                if (!$row->image) {
                    return '<span class="text-muted">No Image</span>';
                }
                // Lazy loading image
                return '<img src="'.asset($row->image).'" class="lazy-load" width="120" />';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '
                    <label class="switch">
                        <input type="checkbox" class="toggleFaqStatus" data-id="' . $row->id . '" ' . $checked . '>
                        <span class="slider round" title="Click to toggle status"></span>
                    </label>
                ';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M, Y h:i A') : '-';
            })
            ->addColumn('action', function ($row) {
                $actions = '';
                if (auth()->user()->hasPermission('edit_faq')) {
                    $actions .= '<a href="'.url('admin/faq/'.$row->id.'/edit').'"
                                    class="btn btn-sm btn-info"
                                    title="Edit Faq">
                                    <i class="la la-pencil"></i>
                                  </a> ';
                }
                if (auth()->user()->hasPermission('delete_faq')) {
                    $actions .= '<button class="btn btn-sm btn-danger deleteFaq"
                                    data-id="'.$row->id.'"
                                    title="Delete Faq">
                                    <i class="la la-trash"></i>
                                  </button>';
                }
                return $actions ?: '<span class="text-muted">No actions</span>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(StoreFaqRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'uploads/faq/', 'faq');
        }

        $item = Faq::create($data);

        log_activity('create', Faq::class, $item->id, 'Created new faq: ' . ($item->title ?? 'N/A'));

        return redirect('admin/faq')
            ->with('message', 'Faq added successfully!');
    }

    public function show(Faq $faq)
    {
        return view('admin.faq.show', compact('faq'));
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteFile($faq->image);
            $data['image'] = $this->uploadFile($request->file('image'), 'uploads/faq/', 'faq');
        }

        $oldData = $faq->toArray();
        $faq->update($data);

        log_activity('update', Faq::class, $faq->id, 'Updated faq', [
            'before' => $oldData,
            'after' => $faq->toArray()
        ]);

        return redirect()->route('admin.faq.index')->with('message', 'Faq updated successfully!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        log_activity('delete', Faq::class, $faq->id, "Deleted faq");
        return response()->json(['success' => 'Faq deleted successfully.']);
    }

    public function toggleStatus(Faq $faq)
    {
        $oldStatus = $faq->status;
        $faq->status = !$oldStatus;
        $faq->save();

        log_activity('status_toggle', Faq::class, $faq->id, 'Toggled status', [
            'old_status' => $oldStatus,
            'new_status' => $faq->status
        ]);

        return response()->json([
            'success' => true,
            'status' => $faq->status ? 'Active' : 'Inactive',
        ]);
    }

    public function trash()
    {
        return view('admin.faq.trash');
    }

    public function getTrashedData(Request $request)
    {
        $items = Faq::onlyTrashed()->orderByDesc('id')->get();

        return DataTables::of($items)
            ->addColumn('checkbox', fn($row) =>
                '<input type="checkbox" class="rowCheckbox" value="'.$row->id.'">'
            )
            ->addColumn('image', function($row) {
                return $row->image
                    ? '<img src="'.asset($row->image).'" class="lazy-load" width="120" />'
                    : '<span class="text-muted">No Image</span>';
            })
            ->addColumn('action', function($row) {
                $restore = '<button class="btn btn-sm btn-success restoreFaq" data-id="'.$row->id.'"><i class="la la-refresh"></i></button>';
                $delete = '<button class="btn btn-sm btn-danger forceDeleteFaq" data-id="'.$row->id.'"><i class="la la-trash"></i></button>';
                return $restore . ' ' . $delete;
            })
            ->rawColumns(['checkbox', 'image', 'action'])
            ->make(true);
    }

    public function restore($id)
    {
        $item = Faq::withTrashed()->findOrFail($id);
        $item->restore();
        log_activity('restore', Faq::class, $id, "Restored faq");
        return response()->json(['success' => 'Faq restored successfully!']);
    }

    public function forceDelete($id)
    {
        $item = Faq::withTrashed()->findOrFail($id);
        $this->deleteFile($item->image);
        $item->forceDelete();

        log_activity('force_delete', Faq::class, $id, "Permanently deleted faq");
        return response()->json(['success' => 'Faq permanently deleted.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];
        if (empty($ids)) return response()->json(['error' => 'No items selected.'], 400);

        Faq::whereIn('id', $ids)->delete();
        log_activity('bulk_delete', Faq::class, null, 'Bulk delete', ['ids' => $ids]);
        return response()->json(['success' => 'Selected faq deleted successfully.']);
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->ids ?? [];
        if (empty($ids)) return response()->json(['error' => 'No items selected.'], 400);

        Faq::withTrashed()->whereIn('id', $ids)->restore();
        log_activity('bulk_restore', Faq::class, null, 'Bulk restore', ['ids' => $ids]);
        return response()->json(['success' => 'Selected faq restored successfully.']);
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->ids ?? [];
        if (empty($ids)) return response()->json(['error' => 'No items selected.'], 400);

        $items = Faq::withTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            $this->deleteFile($item->image);
            $item->forceDelete();
        }

        log_activity('bulk_force_delete', Faq::class, null, 'Bulk permanently delete', ['ids' => $ids]);
        return response()->json(['success' => 'Selected faq permanently deleted.']);
    }

    public function sort(Request $request)
    {
        $order = $request->input('order', []);
        if (!is_array($order) || empty($order)) {
            return response()->json(['success' => false, 'message' => 'No order data received'], 400);
        }

        foreach ($order as $item) {
            $pos = $item['position'] ?? $item['newPosition'] ?? null;
            $id  = $item['id'] ?? null;
            if ($id && $pos !== null) {
                Faq::where('id', $id)->update(['sort_order' => (int)$pos]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully']);
    }
}