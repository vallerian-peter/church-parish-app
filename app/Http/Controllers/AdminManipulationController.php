<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Leader;
use App\Models\LeaderPosition;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $leader = Leader::where('member_id', $validated['member_id'])->get();

        if($leader->leader_position_id == $validated['leader_position_id'] && $leader->member_id == $validated['member_id']){
            return redirect()->back()->with('error', 'Kiongozi ashasajiliwa na hii nafasi');
        }

        dd($validated);

        Leader::create($validated);

        return redirect()->back()->with('success', 'Kiongozi amesajiliwa kikamilifu');
    }

    public function adminEditLeader(Request $request)
    {
        $validated = $request->validate([
            'id'                            => 'required',
            'user_id'                       => 'required',
            'member_id'                     => 'required|max:8|exists:members,member_id',
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
}
