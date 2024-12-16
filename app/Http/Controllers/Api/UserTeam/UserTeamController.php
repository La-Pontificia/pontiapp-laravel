<?php

namespace App\Http\Controllers\Api\UserTeam;

use App\Http\Controllers\Controller;
use App\Models\UserTeam;
use App\Models\UserTeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTeamController extends Controller
{
    public function all(Request $req)
    {
        $match = UserTeam::orderBy('created_at', 'desc');
        $q = $req->query('q');

        if ($q) {
            $match->where('name', 'like', '%' . $q . '%')
                ->orWhere('description', 'like', '%' . $q . '%');
        }

        $includes = explode(',', $req->query('relationship'));
        if (in_array('members', $includes)) $match->with('members');
        if (in_array('members.user', $includes)) $match->with('members.user');
        if (in_array('members.user.role', $includes)) $match->with('members.user.role');
        if (in_array('members.user.role.job', $includes)) $match->with('members.user.role.job');
        if (in_array('members.user.role.job.department', $includes)) $match->with('members.user.role.job.department');
        if (in_array('members.user.role.job.department.area', $includes)) $match->with('members.user.role.job.department.area');
        $userTeams = $match->get();

        $userTeams->map(function ($team) {
            return $team->membersCount = $team->membersCount();
            return $team;
        });

        $userTeams->map(function ($team) {
            $team->ownersCount = $team->ownersCount();
            return $team;
        });


        return response()->json($userTeams);
    }

    public function slug($slug)
    {
        $team = UserTeam::find($slug);
        $team->membersCount = $team->membersCount();
        $team->ownersCount = $team->ownersCount();
        return response()->json($team);
    }

    public function delete($slug)
    {
        $team = UserTeam::find($slug);
        $members = UserTeamMember::where('userTeamId', $slug)->get();
        foreach ($members as $member) {
            $member->delete();
        }
        $team->delete();
        return response()->json($team);
    }

    public function members(Request $req, $slug)
    {
        $match = UserTeamMember::where('userTeamId', $slug)->orderBy('created_at', 'desc')->with('user');
        $q = $req->query('q');

        if ($q) {
            $match->whereHas('user', function ($query) use ($q) {
                $query->where('fullName', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%')
                    ->orWhere('documentId', 'like', '%' . $q . '%');
            });
        }
        $includes = explode(',', $req->query('relationship'));
        if (in_array('user.role', $includes)) $match->with('user');

        if (in_array('user.role.job', $includes)) $match->with('user.role.job');
        if (in_array('user.role.department', $includes)) $match->with('user.role.department');
        if (in_array('user.role.department.area', $includes)) $match->with('user.role.department.area');

        $members = $match->paginate();

        if (in_array('user.userRole', $includes)) {
            foreach ($members as $member) {
                $member->user->userRole = $member->user->userRole;
            }
        }
        return response()->json($members);
    }

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'photoURL' => 'nullable|string',
            'members' => 'nullable|array',
            'owners' => 'nullable|array',
        ]);

        $userTeam = new UserTeam();
        $userTeam->name = $req->name;
        $userTeam->description = $req->description;
        $userTeam->photoURL = $req->photoURL;
        $userTeam->createdBy = Auth::id();
        $userTeam->save();

        // Add members
        foreach ($req->members as $member) {
            UserTeamMember::create([
                'userId' => $member['id'],
                'userTeamId' => $userTeam->id,
                'type' => 'member',
            ]);
        }

        // Add owners
        foreach ($req->owners as $owner) {
            UserTeamMember::create([
                'userId' => $owner['id'],
                'userTeamId' => $userTeam->id,
                'type' => 'owner',
            ]);
        }

        return response()->json($userTeam);
    }

    public function update(Request $req, $slug)
    {
        $req->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'photoURL' => 'nullable|string',
        ]);

        $team = UserTeam::find($slug);
        $team->name = $req->name;
        $team->description = $req->description;
        $team->photoURL = $team !== $req->photoURL ? $req->photoURL : $team->photoURL;
        $team->updatedBy = Auth::id();
        $team->save();

        return response()->json($team);
    }

    public function removeMember($slug)
    {
        $member = UserTeamMember::find($slug);
        $member->delete();
        return response()->json($member);
    }

    public function addMembers(Request $req, $slug)
    {
        $team = UserTeam::find($slug);
        $req->validate([
            'members' => 'nullable|array',
            'owners' => 'nullable|array',
        ]);

        UserTeamMember::where('userTeamId', $team->id)
            ->whereIn('userId', $req->members ? $req->members : [])
            ->orWhereIn('userId', $req->owners ? $req->owners : [])
            ->delete();

        if ($req->members) {
            foreach ($req->members as $id) {
                UserTeamMember::create([
                    'userId' => $id,
                    'userTeamId' => $team->id,
                    'role' => 'member',
                ]);
            }
        }

        if ($req->owners) {
            foreach ($req->owners as $id) {
                UserTeamMember::create([
                    'userId' => $id,
                    'userTeamId' => $team->id,
                    'role' => 'owner',
                ]);
            }
        }

        return response()->json($team);
    }

    public function isOwner($slug)
    {
        $isOwner = UserTeamMember::where('userId', Auth::id())
            ->where('userTeamId', $slug)
            ->where('role', 'owner')
            ->exists();

        return response()->json($isOwner);
    }
}
