<?php

namespace App\Http\Controllers;

use App\Models\BlockedIp;
use App\Models\LoginLog;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $loginLogs = LoginLog::orderBy('attempted_at', 'desc')
            ->paginate(50);
        
        $blockedIps = BlockedIp::orderBy('blocked_at', 'desc')
            ->get();
        
        $stats = [
            'total_attempts' => LoginLog::count(),
            'successful_logins' => LoginLog::where('success', true)->count(),
            'failed_logins' => LoginLog::where('success', false)->count(),
            'blocked_ips_count' => BlockedIp::count(),
        ];
        
        return view('security.index', compact('loginLogs', 'blockedIps', 'stats'));
    }

    public function unblockIp($id)
    {
        $blockedIp = BlockedIp::findOrFail($id);
        $blockedIp->delete();
        
        return redirect()->route('security.index')
            ->with('success', 'IP desbloqueada exitosamente.');
    }
}
