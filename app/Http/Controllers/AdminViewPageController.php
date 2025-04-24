<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Baptism;
use App\Models\Message;
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
            'baptisms' => Baptism::all(),
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
            'baptisms' => Baptism::all(),
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
            'baptisms' => Baptism::all(),
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
            'baptisms' => Baptism::all(),
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
            'baptisms' => Baptism::all(),
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
            'baptisms' => Baptism::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }

    public function adminViewAnnouncementsPage()
    {
        return view('users.admin.pages.admin_announcements_page', [
            'leaders' => Leader::all(),
            'members' => Member::all(),
            'baptisms' => Baptism::all(),
            'leaderPositions' => LeaderPosition::all(),
            'groups' => Group::all(),
            'users' => User::all(),
            'messages' => Message::all(),
            'announcements' => Announcement::all(),
            'user' => Auth::user(),
        ]);
    }

    public function adminViewBaptismsPage()
    {
        return view('users.admin.pages.admin_baptism_page', [
            'leaders' => Leader::all(),
            'baptisms' => Baptism::all(),
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
