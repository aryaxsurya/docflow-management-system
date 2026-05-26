<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{

    public function index()
    {
        $users = User::where('status','pending')
                    ->orderBy('created_at','desc')
                    ->get();

        return view('admin.approvals.index', compact('users'));
    }

    public function approve($id)
    {
        User::where('id',$id)->update([
            'status' => 'approved'
        ]);

        return back()->with('success','User berhasil di approve');
    }

    public function reject($id)
    {
        User::where('id',$id)->update([
            'status' => 'rejected'
        ]);

        return back()->with('success','User ditolak');
    }

}               
