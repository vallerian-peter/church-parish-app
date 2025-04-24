<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Baptism;
use App\Models\Group;
use App\Models\Leader;
use App\Models\LeaderPosition;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminManipulationController extends Controller
{

    // *************************************************** start USER ********************************************
    public  function adminAddUser(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|min:2|max:20',
            'lastname' => 'required|min:2|max:20',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'user_type' => 'required',
            'password' => 'required|min:8|max:20'
        ],[
            'firstname.required' => 'Jina la kwanza linahitajika',
            'firstname.min' => 'Jina la kwanza Angalau liwe herufi 2',
            'firstname.max' => 'Jina la kwanza liwe herufi 20',
            'lastname.required' => 'Jina la Mwisho linahitajika',
            'lastname.min' => 'Jina la Mwisho Angalau liwe herufi 2',
            'lastname.max' => 'Jina la Mwisho liwe herufi 20',
            'email.required' => 'Barua pepe inahitajika',
            'email.email' => 'Mtindo sio wa barua pepe (example@gmal.com)',
            'email.unique' => 'Barua pepe imeshatumika',
            'phone.required' => 'Namba ya Simu inahitajika',
            'phone.unique' => 'Namba ya Simu imeshatumika',
            'user_type.required' => 'Aina ya Mhusika inahitajika'
        ]);

        $validatedData['firstname'] = Str::title(Str::lower($validatedData['firstname']));
        $validatedData['lastname'] = Str::title(Str::lower($validatedData['lastname']));
        $validatedData['name'] = $validatedData['firstname'] . ' ' . $validatedData['lastname'];

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect()->back()->with('success', 'Mhusika Amesajiliwa Kikamilifu');
    }

    public  function adminEditUser(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'firstname' => 'required|min:2|max:20',
            'lastname' => 'required|min:2|max:20',
            'email' => 'required|email',
            'phone' => 'required',
            'user_type' => 'required',
        ],[
            'firstname.required' => 'Jina la kwanza linahitajika',
            'firstname.min' => 'Jina la kwanza Angalau liwe herufi 2',
            'firstname.max' => 'Jina la kwanza liwe herufi 20',
            'lastname.required' => 'Jina la Mwisho linahitajika',
            'lastname.min' => 'Jina la Mwisho Angalau liwe herufi 2',
            'lastname.max' => 'Jina la Mwisho liwe herufi 20',
            'email.required' => 'Barua pepe inahitajika',
            'email.email' => 'Mtindo sio wa barua pepe (example@gmal.com)',
            'email.unique' => 'Barua pepe imeshatumika',
            'phone.required' => 'Namba ya Simu inahitajika',
            'phone.unique' => 'Namba ya Simu imeshatumika',
            'user_type.required' => 'Aina ya Mhusika inahitajika'
        ]);

        $user = User::find($validatedData['id']);

        if(!$user){
            return redirect()->back()->with('error', 'Mhusika Hajapatikana');
        }

        $validatedData['firstname'] = Str::title(Str::lower($validatedData['firstname']));
        $validatedData['lastname'] = Str::title(Str::lower($validatedData['lastname']));
        $validatedData['name'] = $validatedData['firstname'] . ' ' . $validatedData['lastname'];

        $user->update($validatedData);

        return redirect()->back()->with('success', 'Mhusika Amehaririwa Kikamilifu');
    }

    public function adminDeleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Mhusika Amefutwa Kikamilifu');
    }

    // ********************************************** end USER ***************************************************




    // *********************************************** start MEMBER ***********************************************
    public function adminAddMember(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'member_id'    => 'required|unique:members,member_id',
            'firstname'    => 'required|string|max:50',
            'middlename'   => 'nullable|string|max:50',
            'lastname'     => 'required|string|max:50',
            'sex'          => 'required',
            'dateOfBirth'  => 'required|date',
            'ambassador'   => 'nullable|string|max:100',
            'phone'        => 'required|string|max:20|unique:members,phone',
            'street'       => 'nullable|string|max:100',
            'is_guest'     => 'nullable',
            'group_id'     => 'nullable',
            'status'       => 'required|string|max:20',
        ], [
            'user_id.required'     => 'Tafadhali chagua mtumiaji.',
            'user_id.exists'       => 'Mtumiaji hapatikani.',
            'member_id.required'   => 'Tafadhali weka namba ya mshirika.',
            'member_id.unique'     => 'Namba ya mshirika tayari ipo.',
            'phone.unique'         => 'Namba ya Simu tayari ipo',
            'firstname.required'   => 'Weka jina la kwanza.',
            'middlename.required'   => 'Weka jina la kati.',
            'lastname.required'    => 'Weka jina la mwisho.',
            'sex.required'         => 'Chagua jinsia.',
            'dateOfBirth.required' => 'Weka tarehe ya kuzaliwa.',
            'dateOfBirth.date'     => 'Tarehe si sahihi.',
            'ambassador.max'       => 'Jina la balozi ni refu sana.',
            'status.require'       => 'Weka hali'
        ]);

        $validated['is_guest'] = $request->has('is_guest');
        $validated['member_id'] = Str::trim($validated['member_id']);

        if($validated['is_guest']){
            if($validated['ambassador'] != null || $validated['group_id'] != null ){
                return redirect()->back()->with('error', 'Kama NiMgeni, Balozi na Kikundi Visijazwe');
            }
        }else{
            if($validated['ambassador'] == null || $validated['group_id'] == null ){
                return redirect()->back()->with('error', 'Kama SiMgeni, Balozi na Kikundi Vijazwe');
            }

            $validated['ambassador'] = Str::title(Str::lower($validated['ambassador']));
        }

        $validated['age'] = Carbon::parse($validated['dateOfBirth'])->age;
        $validated['firstname'] = Str::title(Str::lower($validated['firstname']));
        $validated['middlename'] = Str::title(Str::lower($validated['middlename']));
        $validated['lastname'] = Str::title(Str::lower($validated['lastname']));

        $member = Member::create($validated);

        return redirect()->back()->with('success', 'Mshirika ameongezwa kikamilifu.');
    }

    public function adminEditMember(Request $request)
    {
        $validated = $request->validate([
            'id'           => 'required',
            'user_id'      => 'required|exists:users,id',
            'member_id'    => ['required', Rule::unique('members')->ignore($request->id)],
            'firstname'    => 'required|string|max:50',
            'middlename'   => 'required|string|max:50',
            'lastname'     => 'required|string|max:50',
            'sex'          => 'required',
            'dateOfBirth'  => 'required|date',
            'ambassador'   => 'nullable|string|max:100',
            'phone'        => ['required', Rule::unique('members','phone')->ignore($request->id)],
            'street'       => 'nullable|string|max:100',
            'is_guest'     => 'nullable',
            'group_id'     => 'nullable',
            'status'       => 'required|string|max:20',
        ], [
            'member_id.required'   => 'Tafadhali weka namba ya mshirika.',
            'member_id.unique'     => 'Namba ya mshirika tayari ipo.',
            'phone.unique'         => 'Namba ya Simu tayari ipo.',
            'firstname.required'   => 'Weka jina la kwanza.',
            'middlename.required'  => 'Weka jina la kati.',
            'lastname.required'    => 'Weka jina la mwisho.',
            'sex.required'         => 'Chagua jinsia.',
            'dateOfBirth.required' => 'Weka tarehe ya kuzaliwa.',
            'dateOfBirth.date'     => 'Tarehe si sahihi.',
            'ambassador.max'       => 'Jina la balozi ni refu sana.',
            'group_id.required'    => 'Chagua kundi.',
            'group_id.exists'      => 'Kundi halipo.',
            'is_guest.required'    => 'Chagua kama ni mgeni au la.',
            'is_guest.boolean'     => 'Chaguo la mgeni si sahihi.',
        ]);

        $member = Member::findOrFail($validated['id']);
        $validated['member_id'] = Str::trim($validated['member_id']);

        $validated['is_guest'] = $request->has('is_guest');

        if($validated['is_guest']){
            if($validated['ambassador'] != null || $validated['group_id'] != null ){
                return redirect()->back()->with('error', 'Kama NiMgeni, Balozi na Kikundi Visijazwe');
            }
        }else{
            if($validated['ambassador'] == null || $validated['group_id'] == null ){
                return redirect()->back()->with('error', 'Kama SiMgeni, Balozi na Kikundi Vijazwe');
            }

            $validated['ambassador'] = Str::title(Str::lower($validated['ambassador']));
        }

        $validated['age'] = Carbon::parse($validated['dateOfBirth'])->age;
        $validated['firstname'] = Str::title(Str::lower($validated['firstname']));
        $validated['middlename'] = Str::title(Str::lower($validated['middlename']));
        $validated['lastname'] = Str::title(Str::lower($validated['lastname']));

        $member->update($validated);

        return redirect()->back()->with('success', 'Mshirika Amehaririwa kikamilifu.');
    }

    public function adminDeleteMember($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return redirect()->back()->with('success', 'Mshirika amefutwa kikamilifu');
    }

    // ************************************************** end MEMBER *********************************************




    // ************************************************** start GROUP *********************************************
    public function adminAddGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:groups,name',
            'user_id' => 'required|exists:users,id',
            'status' => 'required'
        ], [
            'name.required' => 'jina linahitajika',
            'name.max' => 'Jina herufi 20 mwisho',
            'name.unique' => 'Jina limeshatumika',
            'status.required' => 'Hali inahitajika'
        ]);

        $validated['name'] = Str::title(Str::lower($validated['name']));

        Group::create($validated);

        return redirect()->back()->with('success', 'Kikundi kimeongezwa kikamilifu');
    }

    public function adminEditGroup(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => ['required', 'max:20', Rule::unique('groups', 'name')->ignore($request->id)],
            'user_id' => 'required|exists:users,id',
            'status' => 'required'
        ], [
            'name.required' => 'jina linahitajika',
            'name.max' => 'Jina herufi 20 mwisho',
            'name.unique' => 'Jina limeshatumika',
            'status.required' => 'Hali inahitajika'
        ]);

        $group = Group::findOrFail($validated['id']);
        $validated['name'] = Str::title(Str::lower($validated['name']));

        $group->update($validated);

        return redirect()->back()->with('success', 'Kikundi kimehaririwa kikamilifu');
    }

    public function adminDeleteGroup($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect()->back()->with('success', 'Kikundi kimefutwa kikamilifu');
    }

    // ****************************************** start GROUP *******************************************************




    // ****************************************** start LEADER POSITION **********************************************
    public function adminAddLeaderPosition(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:20|unique:groups,name',
            'user_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'jina linahitajika',
            'name.max' => 'Jina herufi 20 mwisho',
            'name.unique' => 'Jina limeshatumika',
        ]);

        $validated['name'] = Str::title(Str::lower($validated['name']));

        LeaderPosition::create($validated);

        return redirect()->back()->with('success', 'Nafasi imeongezwa kikamilifu');
    }

    public function adminEditLeaderPosition(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => ['required', 'max:20', Rule::unique('leaderPositions', 'name')->ignore($request->id)],
            'user_id' => 'required',
        ], [
            'name.required' => 'jina linahitajika',
            'name.max' => 'Jina herufi 20 mwisho',
            'name.unique' => 'Jina limeshatumika',
        ]);

        $position = LeaderPosition::findOrFail($validated['id']);
        $validated['name'] = Str::title(Str::lower($validated['name']));

        $position->update($validated);

        return redirect()->back()->with('success', 'Nafasi imehaririwa kikamilifu');
    }

    public function adminDeleteLeaderPosition($id)
    {
        $position = LeaderPosition::findOrFail($id);
        $position->delete();
        return redirect()->back()->with('success', 'Nafasi imefutwa kikamilifu');
    }

    // ****************************************** end LEADER POSITION ************************************************




    // ******************************************* start LEADER ****************************************************
    public function adminAddLeader(Request $request)
    {
        $validated = $request->validate([
            'user_id'                       => 'required',
            'member_id'                     => 'required|max:8|exists:members,member_id',
            'group_id'                      => 'required|exists:groups,id',
            'leader_position_id'            => 'required|exists:leader_positions,id|unique:leaders,leader_position_id',
            'status'                        => 'required',
        ], [
            'member_id.required'            => 'Jaza namba ya mshirika',
            'member_id.max'                 => 'Namba ya mshirila mwisho  herufi 8',
            'member_id.unique'              => 'Namba ya mshirika imetumika',
            'member_id.exists'              => 'Namba ya mshirika haipo',
            'group_id.required'             => 'Jaza kikundi',
            'leader_position_id.required'   => 'Jaza nafasi',
            'leader_positions_id.unique'    => 'Nafasi ishajazwa',
            'status.required'               => 'Jaza hali'
        ]);

        $validated['member_id'] = Str::trim($validated['member_id']);

        // Leader -> member_id => contains member->id ...not member_id
        $member = Member::where('member_id', $validated['member_id'])->first();
        $validated['member_id'] = $member->id;
        $leader = Leader::where('member_id', $validated['member_id'])->first();

        if(!empty($leader)){
            if($leader->leader_position_id == $validated['leader_position_id'] && $leader->member_id == $validated['member_id']){
                return redirect()->back()->with('error', 'Kiongozi ashasajiliwa na hii nafasi');
            }
        }

        Leader::create($validated);

        return redirect()->back()->with('success', 'Kiongozi amesajiliwa kikamilifu');
    }

    public function adminEditLeader(Request $request)
    {
        $validated = $request->validate([
            'id'                            => 'required',
            'user_id'                       => 'required',
            'member_id'                     => 'required|max:8|exists:members,id',
            'group_id'                      => 'required|exists:groups,id',
            'leader_position_id'            => ['required', 'exists:leader_positions,id', Rule::unique('leaders', 'leader_positions_id')->ignore($request->leader_position_id)],
            'status'                        => 'required',
        ], [
            'member_id.required'            => 'Jaza namba ya mshirika',
            'member_id.max'                 => 'Namba ya mshirila mwisho  herufi 8',
            'member_id.unique'              => 'Namba ya mshirika imetumika',
            'member_id.exists'              => 'Namba ya mshirika haipo',
            'group_id.required'             => 'Jaza kikundi',
            'leader_position_id.required'   => 'Jaza nafasi',
            'leader_positions_id.unique'    => 'Nafasi ishajazwa',
            'status.required'               => 'Jaza hali'
        ]);

        $leader = Leader::finfOrFail($validated['id']);

        $validated['member_id'] = Str::trim($validated['member_id']);

        $leader = Leader::where('member_id', $validated['member_id'])->get();

        if($leader->leader_position_id == $validated['leader_position_id'] && $leader->member_id == $validated['member_id']){
            return redirect()->back()->with('error', 'Kiongozi ashasajiliwa na hii nafasi');
        }

        $leader->update($validated);

        return redirect()->back()->with('success', 'Kiongozi amehaririwa kikamilifu');
    }

    public function adminDeleteLeader($id)
    {
        $leader = Leader::findOrFail($id);
        $leader->delete();

        return redirect()->back()->with('success', 'Kiongozi amefutwa kikamilifu');
    }

    // ********************************************* end LEADER ****************************************************





    // ********************************************* start ANNOUNCEMENTS ********************************************
    public function adminAddAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'announcement_type' => 'required',
            'description' => 'required|string',
            'announcement_asset' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ], [
            'announcement_type.required' => 'Aina ya taarifa inahitajika.',
            'description.required' => 'Maelezo ya taarifa yanahitajika.',
            'description.string' => 'Maelezo lazima yawe maandishi.',
            'announcement_asset.required' => 'Tafadhali weka faili la taarifa.',
            'announcement_asset.file' => 'Faili lazima liwe halali.',
            'announcement_asset.mimes' => 'Faili linapaswa kuwa aina ya: jpg, jpeg, png, pdf, doc, au docx.',
        ]);

        $extension = $request->file('announcement_asset')->getClientOriginalExtension();
        $filename = 'announcement_' . now()->format('Ymd') . '_' . rand(1000, 9999) . '.' . $extension;
        $filePath = $request->file('announcement_asset')->storeAs('announcements', $filename, 'public');
        $validated['announcement_asset'] = $filePath;

        Announcement::create($validated);

        return redirect()->back()->with('success', 'Tangazo limeongezwa kikamilifu');
    }


    public function adminUpdateAnnouncement(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'user_id' => 'required|exists:users,id',
            'announcement_type' => 'required',
            'description' => 'required|string',
            'announcement_asset' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ], [
            'announcement_type.required' => 'Aina ya taarifa inahitajika.',
            'description.required' => 'Maelezo ya taarifa yanahitajika.',
            'description.string' => 'Maelezo lazima yawe maandishi.',
            'announcement_asset.required' => 'Tafadhali weka faili la taarifa.',
            'announcement_asset.file' => 'Faili lazima liwe halali.',
            'announcement_asset.mimes' => 'Faili linapaswa kuwa aina ya: jpg, jpeg, png, pdf, doc, au docx.',
        ]);

        $announcement = Announcement::findOrFail($validated['id']);

        if($announcement->announcement_asset != $validated['announcement_asset']){
            $extension = $request->file('announcement_asset')->getClientOriginalExtension();
            $filename = 'announcement_' . now()->format('Ymd') . '_' . rand(1000, 9999) . '.' . $extension;
            $filePath = $request->file('announcement_asset')->storeAs('announcements', $filename, 'public');
            $validated['announcement_asset'] = $filePath;

            Storage::delete('public' . $announcement->announcement_asset);
        }

        $announcement->update($validated);

        return redirect()->back()->with('success', 'Tangazo limehaririwa kikamilifu');
    }

    public function adminDeleteAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $asset = $announcement->announcement_asset;

        if($asset == null){
            return redirect()->back()->with('error', 'Faili la Tangazo halipo');
        }

        Storage::delete('storage/' . $asset);
        $announcement->delete();

        return redirect()->back()->with('success', 'Tangazo limefutwa kikamilifu');
    }

    // ********************************************* end ANNOUNCEMENTS **********************************************




    // ********************************************* start BAPTISM **********************************************
    public function adminAddBaptism(Request $request)
    {
        $validated = $request->validate([
            'user_id'                   => 'required|exists:users,id',
            'father_member_id'          => 'required|exists:members,member_id',
            'mother_member_id'          => 'required|exists:members,member_id',
            'baby_firstname'            => 'required|string',
            'baby_middlename'           => 'required|string',
            'baby_lastname'             => 'required|string',
            'dateOfBirth'               => 'required',
            'dateOfBaptism'             => 'required',
            'status'                    => 'required'
        ], [
            'father_member_id.required' => 'Ingiza namba ya mshirika (Baba)',
            'mother_member_id.required' => 'Ingiza namba ya mshirika (Mama)',
            'mother_member_id.exists'   => 'Namba ya mshirika (Mama) haipo',
            'father_member_id.exists'   => 'Namba ya mshirika (Baba) haipo',
            'baby_firstname.required'   => 'Ingiza Jina la kwanza',
            'baby_middlename.required'  => 'Ingiza Jina la Kati',
            'baby_lastname.required'    => 'Ingiza Jina la Mwisho',
            'dateOfBirth.required'      => 'Ingiza tarehe ya kuzaliwa',
            'dateOfBaptism.required'    => 'Ingiza tarehe ya kubatizwa',
            'status.required'           => 'Ingiza hali'
        ]);

        $father = Member::where('member_id', $validated['father_member_id'])
                        ->where('sex', 'Mwanaume')
                        ->first();

        $mother = Member::where('member_id', $validated['mother_member_id'])
                        ->where('sex', 'Mwanamke')
                        ->first();

        if($father == null){
            return redirect()->back()->with('error', 'Namba ya mshirika ya baba si Mwanaume')->withInput();
        }

        if($mother == null){
            return redirect()->back()->with('error', 'Namba ya mshirika ya mama si Mwanamke')->withInput();
        }

        $validated['father_member_id'] = $father->id;
        $validated['mother_member_id'] = $mother->id;

        $validated['baby_firstname'] = Str::title(Str::lower($validated['baby_firstname']));
        $validated['baby_middlename'] = Str::title(Str::lower($validated['baby_middlename']));
        $validated['baby_lastname'] = Str::title(Str::lower($validated['baby_lastname']));


        $validated['age'] = $this->displayAge($validated['dateOfBirth']);
        // $validated['age'] = Carbon::parse($validated['dateOfBirth'])->age;

        //  dd($validated);

        Baptism::create($validated);

        return redirect()->back()->with('success', 'Ubatizo umeongezwa kikamilifu');
    }

    public function adminEditBaptism(Request $request)
    {

    }

    public function adminDeleteBaptism($id)
    {
        $baptism = Baptism::findOrFail($id);
        $baptism->delete();

        return redirect()->back()->with('success', 'Ubatizo umefutwa kikamilifu');
    }

    public function displayAge($birthDate)
    {
        $age = Carbon::parse($birthDate)->diff(Carbon::now());

        if ($age->y == 0){
            if($age->m > 1){
                return 'miezi ' . $age->m;
            }else{
                return 'mwezi ' . $age->m;
            }
        }else{
            if($age->y == 1){
                if($age->m > 1){
                    return 'mwaka '.  $age->y . ' na miezi '. $age->m;
                }else{
                    return 'mwaka '.  $age->y . ' na mwezi '. $age->m;
                }
            }else{
                if($age->m > 1){
                    return 'miaka '.  $age->y . ' na miezi '. $age->m;
                }else{
                    return 'miaka '.  $age->y . ' na mwezi '. $age->m;
                }
            }
        }
    }
    // ********************************************* end BAPTISM **********************************************

}
