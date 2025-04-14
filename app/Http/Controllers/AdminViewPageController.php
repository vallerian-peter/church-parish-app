<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Leader;
use App\Models\Member;
use App\Models\LeaderPosition;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminViewPageController extends Controller
{
    public function viewAdminDashboard(){

        return view('users.admin.pages.admin_dashboard_page', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }
    public function viewUsersPage(){

        return view('users.admin.pages.adminUsersPage', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }

    public function adminMembersPage(){
        return view('users.admin.pages.adminMembersPage', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }

    public function viewGroupsPage()
    {
        return view('users.admin.pages.admin_groups_page', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }

    public function adminViewLeaderPositionsPage()
    {
        return view('users.admin.pages.admin_leader_positions', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }

    public function adminViewLeadersPage()
    {
        return view('users.admin.pages.admin_leaders_page', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }
}
