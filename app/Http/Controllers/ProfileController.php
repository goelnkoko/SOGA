<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use App\Models\Work;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
        $profile = Profile::with(['user', 'educations', 'works', 'contacts'])->findOrFail($id);
        return response()->json($profile);
    }

    public function addHobby(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->addHobby($request->hobby);
        return response()->json(['message' => 'Hobby added successfully', 'profile' => $profile]);
    }

    public function removeHobby(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->removeHobby($request->hobby);
        return response()->json(['message' => 'Hobby removed successfully', 'profile' => $profile]);
    }

    public function addInterest(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->addInterest($request->interest);
        return response()->json(['message' => 'Interest added successfully', 'profile' => $profile]);
    }

    public function removeInterest(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->removeInterest($request->interest);
        return response()->json(['message' => 'Interest removed successfully', 'profile' => $profile]);
    }

    public function updateProfile(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($request->all());
        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile]);
    }

    public function updatePhoto(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        if ($request->hasFile('photo')) {
            $filePath = $request->file('photo')->store('photos');
            $profile->update(['photo' => $filePath]);
        }
        return response()->json(['message' => 'Photo updated successfully', 'profile' => $profile]);
    }

    public function removePhoto($id)
    {
        $profile = Profile::findOrFail($id);
        if ($profile->photo) {
            Storage::delete($profile->photo);
            $profile->update(['photo' => null]);
        }
        return response()->json(['message' => 'Photo removed successfully', 'profile' => $profile]);
    }

    public function updateBiography(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update(['biography' => $request->biography]);
        return response()->json(['message' => 'Biography updated successfully', 'profile' => $profile]);
    }

    public function addEducation(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $education = new Education($request->all());
        $profile->educations()->save($education);
        return response()->json(['message' => 'Education added successfully', 'education' => $education]);
    }

    public function removeEducation($profileId, $educationId)
    {
        $profile = Profile::findOrFail($profileId);
        $education = Education::findOrFail($educationId);
        $education->delete();
        return response()->json(['message' => 'Education removed successfully']);
    }

    public function addWork(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $work = new Work($request->all());
        $profile->works()->save($work);
        return response()->json(['message' => 'Work added successfully', 'work' => $work]);
    }

    public function removeWork($profileId, $workId)
    {
        $profile = Profile::findOrFail($profileId);
        $work = Work::findOrFail($workId);
        $work->delete();
        return response()->json(['message' => 'Work removed successfully']);
    }

    public function addContact(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $contact = new Contact($request->all());
        $profile->contacts()->save($contact);
        return response()->json(['message' => 'Contact added successfully', 'contact' => $contact]);
    }

    public function removeContact($profileId, $contactId)
    {
        $profile = Profile::findOrFail($profileId);
        $contact = Contact::findOrFail($contactId);
        $contact->delete();
        return response()->json(['message' => 'Contact removed successfully']);
    }
}
